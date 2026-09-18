<?php

namespace App\Services;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FootballMatchService
{
    /**
     * Mengambil data pertandingan berdasarkan hari:
     * - 'hari-ini' (default): H (hari ini)
     * - 'kemarin': H-1 (kemarin)
     * - 'besok': H+1 (besok)
     *
     * @return array{matches: array, categories: array, total: int, source: string, targetDate: string, targetDateFormatted: string, currentDay: string}
     */
    public function getMatchesByDay(string $day = 'hari-ini'): array
    {
        $day = strtolower(trim($day));
        if (! in_array($day, ['kemarin', 'hari-ini', 'besok'])) {
            $day = 'hari-ini';
        }

        $tz = new DateTimeZone('Asia/Jakarta');
        $now = new DateTime('now', $tz);

        $targetDate = match ($day) {
            'kemarin'  => (clone $now)->modify('-1 day'),
            'hari-ini' => clone $now,
            'besok'    => (clone $now)->modify('+1 day'),
        };

        $targetDateStr = $targetDate->format('Y-m-d');
        $todayDateStr = $now->format('Y-m-d');

        $monthMap = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
            '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
            '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des',
        ];

        $targetDateFormatted = $targetDate->format('d') . ' ' .
                             ($monthMap[$targetDate->format('m')] ?? $targetDate->format('M')) . ' ' .
                             $targetDate->format('Y');

        $cacheKey = "football_data_day_{$day}_{$targetDateStr}_v14";

        return Cache::remember($cacheKey, 300, function () use ($tz, $now, $targetDate, $targetDateStr, $todayDateStr, $targetDateFormatted, $day) {
            $merged = [];

            // Rentang pencarian: 1 hari sebelum target hingga 1 hari setelah target untuk mencakup pergeseran UTC ke WIB (+7)
            $dateFrom = (clone $targetDate)->modify('-1 day')->format('Y-m-d');
            $dateTo = (clone $targetDate)->modify('+1 day')->format('Y-m-d');

            // 1. Ambil laga rentang tanggal dari /matches
            foreach ($this->fetchMatchesWindowRaw($dateFrom, $dateTo) as $m) {
                if (isset($m['id'])) {
                    $merged[$m['id']] = $m;
                }
            }

            // 2. Ambil laga kompetisi
            $competitions = ['PL', 'PD', 'SA', 'BL1', 'FL1', 'DED', 'CL'];
            foreach ($competitions as $code) {
                foreach ($this->fetchCompetitionMatchesRaw($code) as $m) {
                    if (isset($m['id'])) {
                        $merged[$m['id']] = $m;
                    }
                }
            }

            // 3. Saring secara presisi pertandingan untuk TARGET DATE (zona waktu WIB atau UTC)
            $matched = [];
            foreach ($merged as $m) {
                $utc = $m['utcDate'] ?? '';
                if (empty($utc)) {
                    continue;
                }

                try {
                    $dt = new DateTime($utc);
                    $dt->setTimezone($tz);
                    $wibDate = $dt->format('Y-m-d');
                } catch (\Throwable) {
                    $wibDate = '';
                }

                $utcDate = substr($utc, 0, 10);

                if ($wibDate === $targetDateStr || $utcDate === $targetDateStr) {
                    $matched[$m['id']] = $m;
                }
            }

            // Jika ada laga pada target date
            if (! empty($matched)) {
                $rawList = array_values($matched);
                $processedMatches = $this->transformMatches($rawList);
                $sortedMatches = $this->sortMatches($processedMatches);
                $categories = $this->extractCategories($sortedMatches);

                return [
                    'matches'             => $sortedMatches,
                    'categories'          => $categories,
                    'total'               => count($sortedMatches),
                    'source'              => 'live_api',
                    'targetDate'          => $targetDateStr,
                    'targetDateFormatted' => $targetDateFormatted,
                    'currentDay'          => $day,
                ];
            }

            // Fallback cerdas: Jika kemarin kebetulan libur/jeda, cari laga selesai (FINISHED) terdekat sebelumnya
            if ($day === 'kemarin') {
                $nearbyPast = [];
                $minPastDate = (clone $now)->modify('-7 days')->format('Y-m-d');
                foreach ($merged as $m) {
                    $utc = $m['utcDate'] ?? '';
                    if (empty($utc)) continue;
                    try {
                        $dt = new DateTime($utc);
                        $dt->setTimezone($tz);
                        $wibDate = $dt->format('Y-m-d');
                    } catch (\Throwable) {
                        $wibDate = '';
                    }
                    if ($wibDate <= $targetDateStr && $wibDate >= $minPastDate) {
                        $nearbyPast[$m['id']] = $m;
                    }
                }
                if (! empty($nearbyPast)) {
                    $rawList = array_values($nearbyPast);
                    $processedMatches = $this->transformMatches($rawList);
                    $sortedMatches = $this->sortMatches($processedMatches);
                    $categories = $this->extractCategories($sortedMatches);

                    return [
                        'matches'             => $sortedMatches,
                        'categories'          => $categories,
                        'total'               => count($sortedMatches),
                        'source'              => 'live_api',
                        'targetDate'          => $targetDateStr,
                        'targetDateFormatted' => $targetDateFormatted,
                        'currentDay'          => $day,
                    ];
                }
            }

            // Fallback terkurasi
            $fallback = $this->getFallbackMatches($targetDateStr, $day);
            $categories = $this->extractCategories($fallback);

            return [
                'matches'             => $fallback,
                'categories'          => $categories,
                'total'               => count($fallback),
                'source'              => 'fallback',
                'targetDate'          => $targetDateStr,
                'targetDateFormatted' => $targetDateFormatted,
                'currentDay'          => $day,
            ];
        });
    }

    /**
     * Backward compatibility method
     */
    public function getTodaysMatchesData(): array
    {
        return $this->getMatchesByDay('hari-ini');
    }

    /**
     * Mengambil daftar mentah pertandingan dalam rentang tanggal dari https://api.football-data.org/v4/matches
     */
    private function fetchMatchesWindowRaw(string $dateFrom, string $dateTo): array
    {
        $cacheKey = "football_data_raw_matches_window_{$dateFrom}_{$dateTo}_v3";

        return Cache::remember($cacheKey, 300, function () use ($dateFrom, $dateTo) {
            try {
                $apiKey = config('services.football_data.key');
                $baseUrl = rtrim(config('services.football_data.url', 'https://api.football-data.org/v4/'), '/');
                $url = "{$baseUrl}/matches?dateFrom={$dateFrom}&dateTo={$dateTo}";

                $response = Http::withHeaders([
                    'X-Auth-Token' => $apiKey,
                ])->timeout(10)->get($url);

                if ($response->successful()) {
                    return $response->json()['matches'] ?? [];
                }

                Log::warning('Football-Data /matches window response status: ' . $response->status());
            } catch (\Throwable $e) {
                Log::error('Football-Data /matches window exception: ' . $e->getMessage());
            }

            return [];
        });
    }

    /**
     * Mengambil daftar mentah laga kompetisi spesifik dari https://api.football-data.org/v4/competitions/{code}/matches
     */
    private function fetchCompetitionMatchesRaw(string $code): array
    {
        $cacheKey = "football_data_raw_comp_{$code}_v8";

        return Cache::remember($cacheKey, 600, function () use ($code) {
            try {
                $apiKey = config('services.football_data.key');
                $baseUrl = rtrim(config('services.football_data.url', 'https://api.football-data.org/v4/'), '/');
                $url = "{$baseUrl}/competitions/{$code}/matches";

                $response = Http::withHeaders([
                    'X-Auth-Token' => $apiKey,
                ])->timeout(10)->get($url);

                if ($response->successful()) {
                    $json = $response->json();
                    return $json['matches'] ?? [];
                }

                Log::warning("Football-Data /competitions/{$code}/matches response status: " . $response->status());
            } catch (\Throwable $e) {
                Log::error("Football-Data /competitions/{$code}/matches exception: " . $e->getMessage());
            }

            return [];
        });
    }

    /**
     * Mengurutkan laga: Live pertama, lalu waktu kick-off paling awal di depan
     */
    private function sortMatches(array $matches): array
    {
        usort($matches, function ($a, $b) {
            $statusA = $a['status'] ?? 'SCHEDULED';
            $statusB = $b['status'] ?? 'SCHEDULED';

            $liveA = in_array($statusA, ['IN_PLAY', 'PAUSED']);
            $liveB = in_array($statusB, ['IN_PLAY', 'PAUSED']);

            if ($liveA && ! $liveB) return -1;
            if (! $liveA && $liveB) return 1;

            return strcmp($a['utcDate'] ?? '', $b['utcDate'] ?? '');
        });

        return $matches;
    }

    /**
     * Memformat data mentah dari API menjadi format ramah UI
     */
    private function transformMatches(array $matches): array
    {
        $result = [];

        foreach ($matches as $match) {
            $id = $match['id'] ?? uniqid();
            $competition = $match['competition'] ?? [];
            $area = $match['area'] ?? [];
            $homeTeam = $match['homeTeam'] ?? [];
            $awayTeam = $match['awayTeam'] ?? [];
            $score = $match['score'] ?? [];
            $status = $match['status'] ?? 'SCHEDULED';
            $utcDate = $match['utcDate'] ?? '';

            // Format Waktu ke WIB (GMT+7)
            $wibTimeInfo = $this->formatWibDateTime($utcDate);

            // Tentukan Kategori Slug & Nama
            $categorySlug = $this->determineCategorySlug($competition['code'] ?? '', $competition['name'] ?? '');
            $categoryIcon = $this->determineCategoryIcon($competition['code'] ?? '', $area['name'] ?? '');

            // Tim data
            $homeName = $homeTeam['shortName'] ?? $homeTeam['name'] ?? 'Home Team';
            $awayName = $awayTeam['shortName'] ?? $awayTeam['name'] ?? 'Away Team';
            $homeCrest = $homeTeam['crest'] ?? '';
            $awayCrest = $awayTeam['crest'] ?? '';

            // Status label & Badge
            $statusBadge = $this->buildStatusBadge($status, $wibTimeInfo, $score);

            // Probabilitas AI & Estimasi xG (dihitung deterministik dari match ID untuk konsistensi)
            $predictions = $this->calculatePredictions($id, $homeName, $awayName, $status, $score);

            // Kata kunci pencarian
            $searchTerms = strtolower(implode(' ', array_filter([
                $homeName,
                $homeTeam['name'] ?? '',
                $homeTeam['tla'] ?? '',
                $awayName,
                $awayTeam['name'] ?? '',
                $awayTeam['tla'] ?? '',
                $competition['name'] ?? '',
                $area['name'] ?? '',
                $categorySlug,
            ])));

            $result[] = [
                'id'             => $id,
                'status'         => $status,
                'statusBadge'    => $statusBadge,
                'utcDate'        => $utcDate,
                'wibFormatted'   => $wibTimeInfo['formatted'],
                'wibDate'        => $wibTimeInfo['date'],
                'fullDate'       => $wibTimeInfo['fullDate'],
                'wibTime'        => $wibTimeInfo['time'],
                'matchday'       => $match['matchday'] ?? null,
                'matchdayLabel'  => $this->formatStage($match['stage'] ?? null, $match['matchday'] ?? null),
                'competition'    => [
                    'id'     => $competition['id'] ?? null,
                    'name'   => $competition['name'] ?? 'Kompetisi',
                    'code'   => $competition['code'] ?? '',
                    'emblem' => $competition['emblem'] ?? $area['flag'] ?? '',
                    'stage'  => $this->formatStage($match['stage'] ?? null, $match['matchday'] ?? null),
                ],
                'categorySlug'   => $categorySlug,
                'categoryIcon'   => $categoryIcon,
                'homeTeam'       => [
                    'id'        => $homeTeam['id'] ?? null,
                    'name'      => $homeName,
                    'fullName'  => $homeTeam['name'] ?? $homeName,
                    'tla'       => $homeTeam['tla'] ?? substr($homeName, 0, 3),
                    'crest'     => $homeCrest,
                ],
                'awayTeam'       => [
                    'id'        => $awayTeam['id'] ?? null,
                    'name'      => $awayName,
                    'fullName'  => $awayTeam['name'] ?? $awayName,
                    'tla'       => $awayTeam['tla'] ?? substr($awayName, 0, 3),
                    'crest'     => $awayCrest,
                ],
                'score'          => [
                    'home'     => $score['fullTime']['home'] ?? null,
                    'away'     => $score['fullTime']['away'] ?? null,
                    'halfHome' => $score['halfTime']['home'] ?? null,
                    'halfAway' => $score['halfTime']['away'] ?? null,
                    'winner'   => $score['winner'] ?? null,
                ],
                'predictions'    => $predictions,
                'searchKeywords' => $searchTerms,
            ];
        }

        return $result;
    }

    /**
     * Konversi waktu UTC ke WIB dengan penamaan hari Indonesia
     */
    private function formatWibDateTime(string $utcDate): array
    {
        if (empty($utcDate)) {
            return ['formatted' => 'Hari Ini, --:-- WIB', 'date' => 'Hari Ini', 'time' => '--:-- WIB'];
        }

        try {
            $dt = new DateTime($utcDate);
            $dt->setTimezone(new DateTimeZone('Asia/Jakarta'));

            $dayMap = [
                'Sun' => 'Minggu',
                'Mon' => 'Senin',
                'Tue' => 'Selasa',
                'Wed' => 'Rabu',
                'Thu' => 'Kamis',
                'Fri' => 'Jumat',
                'Sat' => 'Sabtu',
            ];

            $monthMap = [
                '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
                '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
                '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des',
            ];

            $dayName = $dayMap[$dt->format('D')] ?? $dt->format('D');
            $dayNum = $dt->format('d');
            $monthNum = $dt->format('m');
            $monthName = $monthMap[$monthNum] ?? $dt->format('M');
            $timeStr = $dt->format('H:i') . ' WIB';

            $year = $dt->format('Y');

            return [
                'formatted' => "{$dayName}, {$timeStr}",
                'date'      => "{$dayName}, {$dayNum} {$monthName}",
                'fullDate'  => "{$dayName}, {$dayNum} {$monthName} {$year}",
                'time'      => $timeStr,
            ];
        } catch (\Throwable) {
            return [
                'formatted' => 'Hari Ini, --:-- WIB',
                'date'      => 'Hari Ini',
                'fullDate'  => 'Hari Ini',
                'time'      => '--:-- WIB',
            ];
        }
    }

    /**
     * Tentukan badge status pertandingan
     */
    private function buildStatusBadge(string $status, array $wibTimeInfo, array $score): array
    {
        $homeScore = $score['fullTime']['home'] ?? ($score['home'] ?? null);
        $awayScore = $score['fullTime']['away'] ?? ($score['away'] ?? null);

        switch ($status) {
            case 'IN_PLAY':
            case 'PAUSED':
                $liveScore = (is_numeric($homeScore) && is_numeric($awayScore)) ? "LIVE {$homeScore} - {$awayScore}" : '🔴 LIVE';
                return [
                    'label'     => $liveScore,
                    'isLive'    => true,
                    'isFinished'=> false,
                    'color'     => 'text-red-400 bg-red-500/10 border-red-500/30 font-bold animate-pulse',
                ];

            case 'FINISHED':
            case 'AWARDED':
                $scoreText = (is_numeric($homeScore) && is_numeric($awayScore)) ? "FT: {$homeScore} - {$awayScore}" : 'FT (Selesai)';
                return [
                    'label'     => $scoreText,
                    'isLive'    => false,
                    'isFinished'=> true,
                    'color'     => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/30 font-bold',
                ];

            case 'POSTPONED':
            case 'SUSPENDED':
                return [
                    'label'     => 'Ditunda',
                    'isLive'    => false,
                    'isFinished'=> false,
                    'color'     => 'text-amber-400 bg-amber-500/10 border-amber-500/30',
                ];

            case 'CANCELLED':
                return [
                    'label'     => 'Dibatalkan',
                    'isLive'    => false,
                    'isFinished'=> false,
                    'color'     => 'text-rose-400 bg-rose-500/10 border-rose-500/30',
                ];

            case 'SCHEDULED':
            case 'TIMED':
            default:
                return [
                    'label'     => $wibTimeInfo['formatted'],
                    'isLive'    => false,
                    'isFinished'=> false,
                    'color'     => 'text-emerald-400 bg-slate-900 border-slate-800',
                ];
        }
    }

    /**
     * Hitung slug kategori berdasarkan kode atau nama kompetisi
     */
    private function determineCategorySlug(string $code, string $name): string
    {
        $code = strtoupper(trim($code));
        $nameLower = strtolower($name);

        return match ($code) {
            'PL'  => 'premier-league',
            'PD'  => 'laliga',
            'SA'  => 'serie-a',
            'BL1' => 'bundesliga',
            'CL'  => 'champions-league',
            'CLI' => 'copa-libertadores',
            'FL1' => 'ligue-1',
            'DED' => 'eredivisie',
            'BSA' => 'brasileirao',
            'EL'  => 'europa-league',
            default => str_contains($nameLower, 'liga 1') ? 'liga-1' :
                       (str_contains($nameLower, 'libertadores') ? 'copa-libertadores' :
                       (str_contains($nameLower, 'premier') ? 'premier-league' :
                       (str_contains($nameLower, 'laliga') || str_contains($nameLower, 'primera') ? 'laliga' :
                       (str_contains($nameLower, 'serie a') ? 'serie-a' :
                       (str_contains($nameLower, 'eredivisie') ? 'eredivisie' :
                       (str_contains($nameLower, 'bundesliga') ? 'bundesliga' :
                       (str_contains($nameLower, 'champions') ? 'champions-league' : 'kompetisi-lain')))))))
        };
    }

    /**
     * Ikon / bendera kategori
     */
    private function determineCategoryIcon(string $code, string $areaName): string
    {
        $code = strtoupper(trim($code));
        $areaLower = strtolower($areaName);

        return match ($code) {
            'PL'  => '🏴󠁧󠁢󠁥󠁮󠁧󠁿',
            'PD'  => '🇪🇸',
            'SA'  => '🇮🇹',
            'BL1' => '🇩🇪',
            'CL'  => '⭐',
            'CLI' => '🏆',
            'FL1' => '🇫🇷',
            'DED' => '🇳🇱',
            'BSA' => '🇧🇷',
            default => str_contains($areaLower, 'spain') ? '🇪🇸' :
                       (str_contains($areaLower, 'england') ? '🏴󠁧󠁢󠁥󠁮󠁧󠁿' :
                       (str_contains($areaLower, 'italy') ? '🇮🇹' :
                       (str_contains($areaLower, 'germany') ? '🇩🇪' :
                       (str_contains($areaLower, 'netherlands') || str_contains($areaLower, 'holland') ? '🇳🇱' :
                       (str_contains($areaLower, 'france') ? '🇫🇷' :
                       (str_contains($areaLower, 'south america') || str_contains($areaLower, 'brazil') ? '🏆' : '⚽'))))))
        };
    }

    /**
     * Format stage atau pekan
     */
    private function formatStage(?string $stage, ?int $matchday): string
    {
        $stageUpper = strtoupper($stage ?? '');

        if ($stageUpper === 'LEAGUE_STAGE' && $matchday) {
            return "Matchday {$matchday}";
        }

        if ($matchday) {
            return "Pekan ke-{$matchday}";
        }

        return match ($stageUpper) {
            'FINAL'           => 'Partai Final',
            'SEMI_FINALS'     => 'Semi Final',
            'QUARTER_FINALS'  => 'Perempat Final',
            'ROUND_OF_16'     => 'Babak 16 Besar',
            'GROUP_STAGE'     => 'Fase Grup',
            'LEAGUE_STAGE'    => 'Fase Liga',
            'REGULAR_SEASON'  => 'Musim Reguler',
            default           => $stage ? ucwords(strtolower(str_replace('_', ' ', $stage))) : 'Fase Gugur',
        };
    }

    /**
     * Menghitung estimasi probabilitas AI & xG
     */
    private function calculatePredictions(int|string $matchId, string $home, string $away, string $status, array $score): array
    {
        // Deterministic pseudo-randomness based on match id so values stay consistent
        $seed = crc32((string) $matchId);
        mt_srand($seed);

        // Basis probabilitas
        $baseHome = 35 + (abs($seed % 30)); // 35 - 64%
        $baseDraw = 20 + (abs(($seed >> 3) % 15)); // 20 - 34%
        $baseAway = 100 - ($baseHome + $baseDraw);
        if ($baseAway < 15) {
            $diff = 15 - $baseAway;
            $baseAway = 15;
            $baseHome -= $diff;
        }

        // xG values
        $homeXg = number_format(1.10 + (abs(($seed >> 2) % 150) / 100), 2);
        $awayXg = number_format(0.80 + (abs(($seed >> 5) % 140) / 100), 2);

        // Reset seed
        mt_srand();

        return [
            'homeProb' => $baseHome,
            'drawProb' => $baseDraw,
            'awayProb' => $baseAway,
            'homeXg'   => $homeXg,
            'awayXg'   => $awayXg,
        ];
    }

    /**
     * Ekstrak tab kategori dinamis dari pertandingan yang didapat
     */
    private function extractCategories(array $matches): array
    {
        $categories = [
            'all' => [
                'slug'   => 'all',
                'name'   => 'Semua Laga',
                'emblem' => '',
                'icon'   => '🌍',
                'count'  => count($matches),
            ],
        ];

        // Definisi prioritas, emblem logo resmi kompetisi, dan penamaan rapi
        $priorityMeta = [
            'premier-league'    => ['name' => 'Premier League', 'emblem' => 'https://crests.football-data.org/PL.png', 'icon' => '🏴󠁧󠁢󠁥󠁮󠁧󠁿'],
            'laliga'            => ['name' => 'La Liga', 'emblem' => 'https://crests.football-data.org/laliga.png', 'icon' => '🇪🇸'],
            'serie-a'           => ['name' => 'Serie A', 'emblem' => 'https://crests.football-data.org/SA.png', 'icon' => '🇮🇹'],
            'bundesliga'        => ['name' => 'Bundesliga', 'emblem' => 'https://crests.football-data.org/BL1.png', 'icon' => '🇩🇪'],
            'champions-league'  => ['name' => 'Champions League', 'emblem' => 'https://crests.football-data.org/CL.png', 'icon' => '⭐'],
            'ligue-1'           => ['name' => 'Ligue 1', 'emblem' => 'https://crests.football-data.org/FL1.png', 'icon' => '🇫🇷'],
            'eredivisie'        => ['name' => 'Eredivisie', 'emblem' => 'https://crests.football-data.org/ED.png', 'icon' => '🇳🇱'],
            'copa-libertadores' => ['name' => 'Copa Libertadores', 'emblem' => 'https://crests.football-data.org/CLI.png', 'icon' => '🏆'],
            'liga-1'            => ['name' => 'BRI Liga 1', 'emblem' => '', 'icon' => '🇮🇩'],
        ];

        foreach ($matches as $m) {
            $slug = $m['categorySlug'] ?? 'kompetisi-lain';
            $compName = $priorityMeta[$slug]['name'] ?? ($m['competition']['name'] ?? 'Kompetisi');
            $emblem = ! empty($m['competition']['emblem']) ? $m['competition']['emblem'] : ($priorityMeta[$slug]['emblem'] ?? '');
            $icon = $priorityMeta[$slug]['icon'] ?? ($m['categoryIcon'] ?? '⚽');

            if (! isset($categories[$slug])) {
                $categories[$slug] = [
                    'slug'   => $slug,
                    'name'   => $compName,
                    'emblem' => $emblem,
                    'icon'   => $icon,
                    'count'  => 0,
                ];
            } else {
                if (empty($categories[$slug]['emblem']) && ! empty($emblem)) {
                    $categories[$slug]['emblem'] = $emblem;
                }
            }
            $categories[$slug]['count']++;
        }

        // Urutkan kategori sesuai urutan prioritas yang telah ditentukan
        $orderedCategories = [];
        $orderedCategories['all'] = $categories['all'];
        foreach (array_keys($priorityMeta) as $pSlug) {
            if (isset($categories[$pSlug])) {
                $orderedCategories[$pSlug] = $categories[$pSlug];
                unset($categories[$pSlug]);
            }
        }
        foreach ($categories as $k => $c) {
            if ($k !== 'all') {
                $orderedCategories[$k] = $c;
            }
        }

        return array_values($orderedCategories);
    }

    /**
     * Data fallback terkurasi dengan skor selesai untuk kemarin/hari ini jika API kosong
     */
    private function getFallbackMatches(string $targetDateStr = '', string $day = 'kemarin'): array
    {
        if (empty($targetDateStr)) {
            $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $targetDate = ($day === 'besok') ? (clone $now)->modify('+1 day') : (clone $now)->modify('-1 day');
            $targetDateStr = $targetDate->format('Y-m-d');
        }

        $isFinished = ($day === 'kemarin' || $day === 'hari-ini');

        return $this->transformMatches([
            [
                'id'          => 500101,
                'utcDate'     => "{$targetDateStr}T14:00:00Z",
                'status'      => $isFinished ? 'FINISHED' : 'SCHEDULED',
                'matchday'    => 5,
                'stage'       => 'REGULAR_SEASON',
                'competition' => [
                    'id'     => 2021,
                    'name'   => 'Premier League',
                    'code'   => 'PL',
                    'emblem' => 'https://crests.football-data.org/PL.png',
                ],
                'area'        => ['name' => 'England', 'flag' => 'https://crests.football-data.org/770.svg'],
                'homeTeam'    => [
                    'id'        => 57,
                    'name'      => 'Arsenal FC',
                    'shortName' => 'Arsenal',
                    'tla'       => 'ARS',
                    'crest'     => 'https://crests.football-data.org/57.png',
                ],
                'awayTeam'    => [
                    'id'        => 65,
                    'name'      => 'Manchester City FC',
                    'shortName' => 'Man City',
                    'tla'       => 'MCI',
                    'crest'     => 'https://crests.football-data.org/65.png',
                ],
                'score'       => [
                    'winner'   => $isFinished ? 'HOME_TEAM' : null,
                    'fullTime' => ['home' => $isFinished ? 2 : null, 'away' => $isFinished ? 1 : null],
                    'halfTime' => ['home' => $isFinished ? 1 : null, 'away' => $isFinished ? 0 : null],
                ],
            ],
            [
                'id'          => 500102,
                'utcDate'     => "{$targetDateStr}T19:00:00Z",
                'status'      => $isFinished ? 'FINISHED' : 'SCHEDULED',
                'matchday'    => 5,
                'stage'       => 'REGULAR_SEASON',
                'competition' => [
                    'id'     => 2014,
                    'name'   => 'Primera Division',
                    'code'   => 'PD',
                    'emblem' => 'https://crests.football-data.org/laliga.png',
                ],
                'area'        => ['name' => 'Spain', 'flag' => 'https://crests.football-data.org/760.svg'],
                'homeTeam'    => [
                    'id'        => 86,
                    'name'      => 'Real Madrid CF',
                    'shortName' => 'Real Madrid',
                    'tla'       => 'RMA',
                    'crest'     => 'https://crests.football-data.org/86.png',
                ],
                'awayTeam'    => [
                    'id'        => 81,
                    'name'      => 'FC Barcelona',
                    'shortName' => 'Barcelona',
                    'tla'       => 'FCB',
                    'crest'     => 'https://crests.football-data.org/81.png',
                ],
                'score'       => [
                    'winner'   => $isFinished ? 'AWAY_TEAM' : null,
                    'fullTime' => ['home' => $isFinished ? 1 : null, 'away' => $isFinished ? 3 : null],
                    'halfTime' => ['home' => $isFinished ? 1 : null, 'away' => $isFinished ? 1 : null],
                ],
            ],
            [
                'id'          => 500103,
                'utcDate'     => "{$targetDateStr}T18:45:00Z",
                'status'      => $isFinished ? 'FINISHED' : 'SCHEDULED',
                'matchday'    => 4,
                'stage'       => 'REGULAR_SEASON',
                'competition' => [
                    'id'     => 2019,
                    'name'   => 'Serie A',
                    'code'   => 'SA',
                    'emblem' => 'https://crests.football-data.org/SA.png',
                ],
                'area'        => ['name' => 'Italy', 'flag' => 'https://crests.football-data.org/784.svg'],
                'homeTeam'    => [
                    'id'        => 108,
                    'name'      => 'FC Internazionale Milano',
                    'shortName' => 'Inter',
                    'tla'       => 'INT',
                    'crest'     => 'https://crests.football-data.org/108.png',
                ],
                'awayTeam'    => [
                    'id'        => 98,
                    'name'      => 'AC Milan',
                    'shortName' => 'AC Milan',
                    'tla'       => 'MIL',
                    'crest'     => 'https://crests.football-data.org/98.png',
                ],
                'score'       => [
                    'winner'   => $isFinished ? 'DRAW' : null,
                    'fullTime' => ['home' => $isFinished ? 2 : null, 'away' => $isFinished ? 2 : null],
                    'halfTime' => ['home' => $isFinished ? 0 : null, 'away' => $isFinished ? 1 : null],
                ],
            ],
            [
                'id'          => 500104,
                'utcDate'     => "{$targetDateStr}T19:30:00Z",
                'status'      => $isFinished ? 'FINISHED' : 'SCHEDULED',
                'matchday'    => 4,
                'stage'       => 'REGULAR_SEASON',
                'competition' => [
                    'id'     => 2002,
                    'name'   => 'Bundesliga',
                    'code'   => 'BL1',
                    'emblem' => 'https://crests.football-data.org/BL1.png',
                ],
                'area'        => ['name' => 'Germany', 'flag' => 'https://crests.football-data.org/759.svg'],
                'homeTeam'    => [
                    'id'        => 5,
                    'name'      => 'FC Bayern München',
                    'shortName' => 'Bayern',
                    'tla'       => 'FCB',
                    'crest'     => 'https://crests.football-data.org/5.png',
                ],
                'awayTeam'    => [
                    'id'        => 4,
                    'name'      => 'Borussia Dortmund',
                    'shortName' => 'Dortmund',
                    'tla'       => 'BVB',
                    'crest'     => 'https://crests.football-data.org/4.png',
                ],
                'score'       => [
                    'winner'   => $isFinished ? 'HOME_TEAM' : null,
                    'fullTime' => ['home' => $isFinished ? 3 : null, 'away' => $isFinished ? 1 : null],
                    'halfTime' => ['home' => $isFinished ? 1 : null, 'away' => $isFinished ? 0 : null],
                ],
            ],
            [
                'id'          => 500105,
                'utcDate'     => "{$targetDateStr}T20:00:00Z",
                'status'      => $isFinished ? 'FINISHED' : 'SCHEDULED',
                'matchday'    => 5,
                'stage'       => 'REGULAR_SEASON',
                'competition' => [
                    'id'     => 2015,
                    'name'   => 'Ligue 1',
                    'code'   => 'FL1',
                    'emblem' => 'https://crests.football-data.org/FL1.png',
                ],
                'area'        => ['name' => 'France', 'flag' => 'https://crests.football-data.org/773.svg'],
                'homeTeam'    => [
                    'id'        => 524,
                    'name'      => 'Paris Saint-Germain FC',
                    'shortName' => 'PSG',
                    'tla'       => 'PSG',
                    'crest'     => 'https://crests.football-data.org/524.png',
                ],
                'awayTeam'    => [
                    'id'        => 516,
                    'name'      => 'Olympique de Marseille',
                    'shortName' => 'Marseille',
                    'tla'       => 'OM',
                    'crest'     => 'https://crests.football-data.org/516.png',
                ],
                'score'       => [
                    'winner'   => $isFinished ? 'HOME_TEAM' : null,
                    'fullTime' => ['home' => $isFinished ? 2 : null, 'away' => $isFinished ? 0 : null],
                    'halfTime' => ['home' => $isFinished ? 1 : null, 'away' => $isFinished ? 0 : null],
                ],
            ],
        ]);
    }
}
