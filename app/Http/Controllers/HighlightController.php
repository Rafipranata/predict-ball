<?php

namespace App\Http\Controllers;

use App\Services\FootballMatchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HighlightController extends Controller
{
    public function index(Request $request, FootballMatchService $footballMatchService)
    {
        $cacheKey = 'soccer_highlights_season_2026_all';

        $highlights = Cache::remember($cacheKey, 600, function () {
            try {
                $baseUrl = rtrim(config('services.highlightly.url'), '/');
                $host = parse_url($baseUrl, PHP_URL_HOST) ?? 'football-highlights-api.p.rapidapi.com';

                // Tarik semua cuplikan laga musim 2026 tanpa filter liga/negara
                $queryParams = [
                    'season' => 2026,
                    'limit'  => 30, // Ambil kuota agak banyak sebelum disaring YouTube
                ];

                $response = Http::withHeaders([
                    'x-rapidapi-key'  => config('services.highlightly.key'),
                    'x-rapidapi-host' => $host,
                ])->timeout(10)->get($baseUrl . '/highlights', $queryParams);

                if ($response->successful()) {
                    $data = $response->json()['data'] ?? [];

                    if (! empty($data)) {
                        // Validasi: hanya ambil data yang memiliki embed video YouTube
                        $youtubeHighlights = collect($data)->filter(function ($item) {
                            $embed = $item['embedUrl'] ?? '';
                            return ! empty($embed) && (
                                str_contains($embed, 'youtube.com') ||
                                str_contains($embed, 'youtu.be') ||
                                str_contains($embed, 'youtube-nocookie.com')
                            );
                        })->values()->all();

                        if (! empty($youtubeHighlights)) {
                            return $youtubeHighlights;
                        }
                    }
                }

                Log::warning('Highlightly live data kosong atau non-200', [
                    'status' => $response->status(),
                    'body'   => $response->json(),
                ]);
            } catch (\Throwable $e) {
                Log::error('Highlightly API exception: ' . $e->getMessage());
            }

            // Fallback jika API gagal atau kosong
            return $this->getFallbackHighlights('All');
        });

        // Ambil data jadwal pertandingan besok hari dari Football-Data API v4
        $matchesPayload = $footballMatchService->getTodaysMatchesData();
        $todaysMatches = $matchesPayload['matches'] ?? [];
        $matchCategories = $matchesPayload['categories'] ?? [];
        $totalMatches = $matchesPayload['total'] ?? count($todaysMatches);
        $matchesSource = $matchesPayload['source'] ?? 'live_api';
        $targetDateFormatted = $matchesPayload['targetDateFormatted'] ?? 'Besok';

        return view('main', compact('highlights', 'todaysMatches', 'matchCategories', 'totalMatches', 'matchesSource', 'targetDateFormatted'));
    }

    /**
     * Menyediakan cuplikan video kurasi berkualitas tinggi spesifik per kategori
     * jika kuota API habis atau belum mencakup liga tertentu.
     */
    private function getFallbackHighlights(string $league): array
    {
        $categoryData = [
            'Premier League' => [
                [
                    'title' => 'Arsenal vs Manchester City: Drama Sengit Menit Akhir di Emirates',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/n7w0eI7e1B8?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=n7w0eI7e1B8',
                    'imgUrl' => 'https://i.ytimg.com/vi/n7w0eI7e1B8/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Pertarungan intensitas tinggi dengan 28 total tembakan. Cuplikan gol penyeimbang di injury time serta duel taktis Mikel Arteta vs Pep Guardiola.',
                    'match' => [
                        'date' => '2026-09-05T19:30:00.000Z',
                        'round' => 'Pekan ke-5',
                        'league' => ['name' => '🏴󠁧󠁢󠁥󠁮󠁧󠁿 Premier League'],
                        'homeTeam' => ['name' => 'Arsenal', 'logo' => 'https://crests.football-data.org/57.png'],
                        'awayTeam' => ['name' => 'Manchester City', 'logo' => 'https://crests.football-data.org/65.png'],
                    ],
                ],
                [
                    'title' => 'Liverpool vs Chelsea: Pertarungan Sengit Papan Atas di Anfield',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/kY3Onr6f6j8?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=kY3Onr6f6j8',
                    'imgUrl' => 'https://i.ytimg.com/vi/kY3Onr6f6j8/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Aksi serangan balik kilat The Reds dan penyelamatan krusial di bawah mistar gawang dalam laga panas Super Sunday.',
                    'match' => [
                        'date' => '2026-09-06T15:30:00.000Z',
                        'round' => 'Pekan ke-5',
                        'league' => ['name' => '🏴󠁧󠁢󠁥󠁮󠁧󠁿 Premier League'],
                        'homeTeam' => ['name' => 'Liverpool', 'logo' => 'https://crests.football-data.org/64.png'],
                        'awayTeam' => ['name' => 'Chelsea', 'logo' => 'https://crests.football-data.org/61.png'],
                    ],
                ],
                [
                    'title' => 'Manchester United vs Tottenham: Duel Taktikal Penuh Gengsi di Old Trafford',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/5D34Cq-z8fM?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=5D34Cq-z8fM',
                    'imgUrl' => 'https://i.ytimg.com/vi/5D34Cq-z8fM/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Cuplikan gol spektakuler dari luar kotak penalti serta peluang emas yang tercipta sepanjang 90 menit pertandingan.',
                    'match' => [
                        'date' => '2026-09-07T16:30:00.000Z',
                        'round' => 'Pekan ke-5',
                        'league' => ['name' => '🏴󠁧󠁢󠁥󠁮󠁧󠁿 Premier League'],
                        'homeTeam' => ['name' => 'Manchester United', 'logo' => 'https://crests.football-data.org/66.png'],
                        'awayTeam' => ['name' => 'Tottenham', 'logo' => 'https://crests.football-data.org/73.png'],
                    ],
                ],
            ],
            'La Liga' => [
                [
                    'title' => 'Real Madrid vs FC Barcelona: El Clásico Penuh Gengsi 5 Gol di Santiago Bernabéu',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/5qap5aO4i9A?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=5qap5aO4i9A',
                    'imgUrl' => 'https://i.ytimg.com/vi/5qap5aO4i9A/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Rangkuman aksi serangan balik cepat Real Madrid dan dominasi penguasaan bola Barcelona yang menghasilkan duel sengit hingga menit akhir.',
                    'match' => [
                        'date' => '2026-09-04T20:00:00.000Z',
                        'round' => 'El Clásico',
                        'league' => ['name' => '🇪🇸 La Liga'],
                        'homeTeam' => ['name' => 'Real Madrid', 'logo' => 'https://crests.football-data.org/86.png'],
                        'awayTeam' => ['name' => 'FC Barcelona', 'logo' => 'https://crests.football-data.org/81.png'],
                    ],
                ],
                [
                    'title' => 'Atletico Madrid vs Sevilla: Tensi Panas dan Pertahanan Baja di Metropolitano',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/6iQd3N2U5b8?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=6iQd3N2U5b8',
                    'imgUrl' => 'https://i.ytimg.com/vi/6iQd3N2U5b8/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Disiplin taktik racikan Diego Simeone meredam agresivitas Sevilla dengan serangan balik tajam yang mematikan.',
                    'match' => [
                        'date' => '2026-09-05T17:30:00.000Z',
                        'round' => 'Pekan ke-4',
                        'league' => ['name' => '🇪🇸 La Liga'],
                        'homeTeam' => ['name' => 'Atletico Madrid', 'logo' => 'https://crests.football-data.org/78.png'],
                        'awayTeam' => ['name' => 'Sevilla', 'logo' => 'https://crests.football-data.org/559.png'],
                    ],
                ],
                [
                    'title' => 'Athletic Club vs Real Sociedad: Derby Basque Penuh Kebanggaan dan Tekanan Tinggi',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/8tY4l-O5U3k?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=8tY4l-O5U3k',
                    'imgUrl' => 'https://i.ytimg.com/vi/8tY4l-O5U3k/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Intensitas fisik tinggi khas derby Basque di San Mamés dengan duel perebutan bola di lini tengah yang sangat ketat.',
                    'match' => [
                        'date' => '2026-09-06T19:00:00.000Z',
                        'round' => 'Pekan ke-4',
                        'league' => ['name' => '🇪🇸 La Liga'],
                        'homeTeam' => ['name' => 'Athletic Club', 'logo' => 'https://crests.football-data.org/77.png'],
                        'awayTeam' => ['name' => 'Real Sociedad', 'logo' => 'https://crests.football-data.org/92.png'],
                    ],
                ],
            ],
            'Serie A' => [
                [
                    'title' => 'Inter Milan vs AC Milan: Derby della Madonnina Membara di San Siro',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/9bZkp7q19f0?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                    'imgUrl' => 'https://i.ytimg.com/vi/9bZkp7q19f0/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Pertarungan prestisius dua raksasa kota Milan. Aksi jual beli serangan cepat dan gol-gol spektakuler penentu takhta klasemen.',
                    'match' => [
                        'date' => '2026-09-05T19:45:00.000Z',
                        'round' => 'Derby della Madonnina',
                        'league' => ['name' => '🇮🇹 Serie A'],
                        'homeTeam' => ['name' => 'Inter Milan', 'logo' => 'https://crests.football-data.org/108.png'],
                        'awayTeam' => ['name' => 'AC Milan', 'logo' => 'https://crests.football-data.org/98.png'],
                    ],
                ],
                [
                    'title' => 'Juventus vs AS Roma: Pertarungan Taktis Klasik Sepak Bola Italia',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/3vB8oP6J2kE?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=3vB8oP6J2kE',
                    'imgUrl' => 'https://i.ytimg.com/vi/3vB8oP6J2kE/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Duel ketat di Allianz Stadium. Soliditas lini pertahanan diuji oleh penetrasi sayap dan bola-bola mati berbahaya.',
                    'match' => [
                        'date' => '2026-09-06T19:45:00.000Z',
                        'round' => 'Pekan ke-3',
                        'league' => ['name' => '🇮🇹 Serie A'],
                        'homeTeam' => ['name' => 'Juventus', 'logo' => 'https://crests.football-data.org/109.png'],
                        'awayTeam' => ['name' => 'AS Roma', 'logo' => 'https://crests.football-data.org/100.png'],
                    ],
                ],
                [
                    'title' => 'Napoli vs Lazio: Hujan Gol dan Serangan Vertikal Cepat di Maradona',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/5nQ8L2z1W4M?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=5nQ8L2z1W4M',
                    'imgUrl' => 'https://i.ytimg.com/vi/5nQ8L2z1W4M/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Pesta gol di Stadion Diego Armando Maradona dengan kombinasi operan satu-dua serta tembakan jarak jauh memukau.',
                    'match' => [
                        'date' => '2026-09-07T17:00:00.000Z',
                        'round' => 'Pekan ke-3',
                        'league' => ['name' => '🇮🇹 Serie A'],
                        'homeTeam' => ['name' => 'Napoli', 'logo' => 'https://crests.football-data.org/113.png'],
                        'awayTeam' => ['name' => 'Lazio', 'logo' => 'https://crests.football-data.org/110.png'],
                    ],
                ],
            ],
            'Bundesliga' => [
                [
                    'title' => 'Bayern Munich vs Borussia Dortmund: Der Klassiker Penuh Sensasi dan Ketegangan',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/4X9T7z_Q5Lk?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=4X9T7z_Q5Lk',
                    'imgUrl' => 'https://i.ytimg.com/vi/4X9T7z_Q5Lk/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Rivalitas terbesar di sepak bola Jerman menyajikan tempo ultra-cepat, pressing agresif, dan drama gol di menit-menit akhir.',
                    'match' => [
                        'date' => '2026-09-05T17:30:00.000Z',
                        'round' => 'Der Klassiker',
                        'league' => ['name' => '🇩🇪 Bundesliga'],
                        'homeTeam' => ['name' => 'Bayern Munich', 'logo' => 'https://crests.football-data.org/5.png'],
                        'awayTeam' => ['name' => 'Borussia Dortmund', 'logo' => 'https://crests.football-data.org/4.png'],
                    ],
                ],
                [
                    'title' => 'Bayer Leverkusen vs RB Leipzig: Duel Kontemporer Penguasaan Bola dan Gegenpressing',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/7Y2W8eP0mK1?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=7Y2W8eP0mK1',
                    'imgUrl' => 'https://i.ytimg.com/vi/7Y2W8eP0mK1/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Sepak bola modern dengan sirkulasi bola dinamis dan transisi bertahan-menyerang secepat kilat di BayArena.',
                    'match' => [
                        'date' => '2026-09-06T16:30:00.000Z',
                        'round' => 'Pekan ke-3',
                        'league' => ['name' => '🇩🇪 Bundesliga'],
                        'homeTeam' => ['name' => 'Bayer Leverkusen', 'logo' => 'https://crests.football-data.org/3.png'],
                        'awayTeam' => ['name' => 'RB Leipzig', 'logo' => 'https://crests.football-data.org/721.png'],
                    ],
                ],
                [
                    'title' => 'Eintracht Frankfurt vs VfB Stuttgart: Laga Terbuka Bertabur Tembakan Spektakuler',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/1vR9xP8L5K2?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=1vR9xP8L5K2',
                    'imgUrl' => 'https://i.ytimg.com/vi/1vR9xP8L5K2/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Kedua tim tampil tanpa kompromi saling serang sepanjang laga menghasilkan cuplikan pertandingan yang sangat menghibur.',
                    'match' => [
                        'date' => '2026-09-07T14:30:00.000Z',
                        'round' => 'Pekan ke-3',
                        'league' => ['name' => '🇩🇪 Bundesliga'],
                        'homeTeam' => ['name' => 'Eintracht Frankfurt', 'logo' => 'https://crests.football-data.org/19.png'],
                        'awayTeam' => ['name' => 'VfB Stuttgart', 'logo' => 'https://crests.football-data.org/10.png'],
                    ],
                ],
            ],
            'Champions League' => [
                [
                    'title' => 'Manchester City vs Real Madrid: Adu Taktik Elit Eropa dan Drama Penalti Menegangkan',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/9bZkp7q19f0?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                    'imgUrl' => 'https://i.ytimg.com/vi/9bZkp7q19f0/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Pertarungan dua tim terbaik benua biru selama 120 menit berujung babak adu penalti emosional penentu semifinalis UCL.',
                    'match' => [
                        'date' => '2026-09-03T20:00:00.000Z',
                        'round' => 'Fase Knockout UCL',
                        'league' => ['name' => '⭐ UEFA Champions League'],
                        'homeTeam' => ['name' => 'Manchester City', 'logo' => 'https://crests.football-data.org/65.png'],
                        'awayTeam' => ['name' => 'Real Madrid', 'logo' => 'https://crests.football-data.org/86.png'],
                    ],
                ],
                [
                    'title' => 'Bayern Munich vs Arsenal: Duel Sengit Menuju Tiket Empat Besar Eropa',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/8bL5vP3M1qA?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=8bL5vP3M1qA',
                    'imgUrl' => 'https://i.ytimg.com/vi/8bL5vP3M1qA/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Intensitas tinggi di Allianz Arena. Gol tandukan krusial dan penyelamatan heroik memastikan langkah ke babak selanjutnya.',
                    'match' => [
                        'date' => '2026-09-04T20:00:00.000Z',
                        'round' => 'Fase Knockout UCL',
                        'league' => ['name' => '⭐ UEFA Champions League'],
                        'homeTeam' => ['name' => 'Bayern Munich', 'logo' => 'https://crests.football-data.org/5.png'],
                        'awayTeam' => ['name' => 'Arsenal', 'logo' => 'https://crests.football-data.org/57.png'],
                    ],
                ],
                [
                    'title' => 'Paris Saint-Germain vs Barcelona: Comeback Gemilang dan Drama Kartu Merah',
                    'embedUrl' => 'https://www.youtube-nocookie.com/embed/2vK8nL0P7wQ?rel=0',
                    'url' => 'https://www.youtube.com/watch?v=2vK8nL0P7wQ',
                    'imgUrl' => 'https://i.ytimg.com/vi/2vK8nL0P7wQ/hqdefault.jpg',
                    'source' => 'youtube',
                    'description' => 'Laga penuh gejolak emosi dengan pembalikan keadaan dramatis dan permainan sayap tanpa henti dari kedua kesebelasan.',
                    'match' => [
                        'date' => '2026-09-05T20:00:00.000Z',
                        'round' => 'Fase Knockout UCL',
                        'league' => ['name' => '⭐ UEFA Champions League'],
                        'homeTeam' => ['name' => 'Paris Saint-Germain', 'logo' => 'https://crests.football-data.org/524.png'],
                        'awayTeam' => ['name' => 'FC Barcelona', 'logo' => 'https://crests.football-data.org/81.png'],
                    ],
                ],
            ],
        ];

        return $categoryData[$league] ?? $categoryData['Premier League'];
    }
}
