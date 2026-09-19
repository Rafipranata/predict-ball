@section('highlight')
    <!-- 3.5. DEDICATED SECTION: HIGHLIGHTS PERTANDINGAN (Matte Solid) -->
    <section id="highlights" class="py-16 md:py-24 border-b border-[#285A48] bg-[#091413]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $highlights = $highlights ?? [];
            @endphp

            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div class="space-y-2">
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                        Highlights Pertandingan
                    </h2>
                    <p class="text-sm sm:text-base text-slate-400 max-w-2xl">
                        Tonton cuplikan gol spektakuler serta rangkuman laga akbar
                        dunia terkini yang disinkronkan langsung via API Highlightly.
                    </p>
                </div>

            </div>

            <!-- Highlight Cards Grid -->
            @php
                $youtubeHighlights = collect($highlights)->filter(function ($item) {
                    $embed = $item['embedUrl'] ?? '';
                    return !empty($embed) &&
                        (str_contains($embed, 'youtube.com') ||
                            str_contains($embed, 'youtu.be') ||
                            str_contains($embed, 'youtube-nocookie.com'));
                });
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($youtubeHighlights as $highlight)
                    <div class="match-card rounded-2xl overflow-hidden flex flex-col justify-between group">
                        <div>
                            <!-- Video Embed Container -->
                            <div class="relative aspect-video w-full bg-[#091413] overflow-hidden">
                                <iframe class="w-full h-full border-0" src="{{ $highlight['embedUrl'] }}"
                                    title="{{ $highlight['title'] ?? 'Video Highlights' }}" loading="lazy"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen>
                                </iframe>
                            </div>

                            <!-- Content -->
                            <div class="p-5 space-y-3">
                                <div class="flex items-center justify-between text-xs">
                                    <span
                                        class="font-bold text-[#408A71] bg-[#285A48]/30 px-2 py-0.5 rounded border border-[#285A48] truncate max-w-[180px]">
                                        {{ $highlight['match']['league']['name'] ?? ($highlight['channel'] ?? 'Highlight Bola') }}
                                    </span>
                                    <span
                                        class="text-slate-400 font-mono text-[11px] bg-[#091413] px-2 py-0.5 rounded border border-[#285A48] shrink-0">
                                        ⏱️
                                        {{ isset($highlight['match']['date']) ? \Carbon\Carbon::parse($highlight['match']['date'])->format('d M Y') : $highlight['match']['round'] ?? 'Update' }}
                                    </span>
                                </div>

                                @if (!empty($highlight['match']['homeTeam']['name']) && !empty($highlight['match']['awayTeam']['name']))
                                    <div
                                        class="flex items-center gap-2 text-xs font-medium text-slate-300 py-1 border-b border-[#285A48]/50">
                                        @if (!empty($highlight['match']['homeTeam']['logo']))
                                            <img src="{{ $highlight['match']['homeTeam']['logo'] }}"
                                                class="w-4 h-4 object-contain shrink-0" alt=""
                                                onerror="this.style.display='none'">
                                        @endif
                                        <span
                                            class="text-white font-semibold truncate">{{ $highlight['match']['homeTeam']['name'] }}</span>
                                        <span class="text-[#408A71] font-bold">vs</span>
                                        @if (!empty($highlight['match']['awayTeam']['logo']))
                                            <img src="{{ $highlight['match']['awayTeam']['logo'] }}"
                                                class="w-4 h-4 object-contain shrink-0" alt=""
                                                onerror="this.style.display='none'">
                                        @endif
                                        <span
                                            class="text-white font-semibold truncate">{{ $highlight['match']['awayTeam']['name'] }}</span>
                                    </div>
                                @endif

                                <h3
                                    class="font-bold text-white text-sm sm:text-base group-hover:text-[#408A71] transition-colors line-clamp-2">
                                    {{ $highlight['title'] ?? 'Pertandingan Sepak Bola' }}
                                </h3>

                                @if (!empty($highlight['description']))
                                    <p class="text-xs text-slate-400 leading-relaxed line-clamp-2">
                                        {{ $highlight['description'] }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        @if (!empty($highlight['url']) || !empty($highlight['embedUrl']))
                            <div class="px-5 pb-5 pt-2 border-t border-[#285A48]/40">
                                <a href="{{ $highlight['url'] ?? $highlight['embedUrl'] }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-white hover:text-white bg-[#408A71]/10 hover:bg-[#408A71] border border-[#408A71]/30 transition-all duration-200">
                                    <span>Tonton Video di YouTube</span>
                                    <span class="font-mono">↗</span>
                                </a>
                            </div>
                        @endif
                    </div>
                @empty
                    <!-- Fallback Cards jika API belum mengembalikan cuplikan live -->
                    <div class="match-card rounded-2xl overflow-hidden flex flex-col justify-between group">
                        <div>
                            <div class="relative aspect-video w-full bg-[#091413] overflow-hidden">
                                <iframe class="w-full h-full border-0"
                                    src="https://www.youtube-nocookie.com/embed/n7w0eI7e1B8?rel=0"
                                    title="Arsenal vs Manchester City" loading="lazy"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <div class="p-5 space-y-3">
                                <div class="flex items-center justify-between text-xs">
                                    <span
                                        class="font-bold text-[#408A71] bg-[#285A48]/30 px-2 py-0.5 rounded border border-[#285A48] truncate max-w-[180px]">
                                        🏴󠁧󠁢󠁥󠁮󠁧󠁿 Premier League
                                    </span>
                                    <span
                                        class="text-slate-400 font-mono text-[11px] bg-[#091413] px-2 py-0.5 rounded border border-[#285A48] shrink-0">
                                        ⏱️ Pekan ke-5
                                    </span>
                                </div>
                                <div
                                    class="flex items-center gap-2 text-xs font-medium text-slate-300 py-1 border-b border-[#285A48]/50">
                                    <img src="https://crests.football-data.org/57.png"
                                        class="w-4 h-4 object-contain shrink-0" alt="Arsenal" />
                                    <span class="text-white font-semibold truncate">Arsenal</span>
                                    <span class="text-[#408A71] font-bold">vs</span>
                                    <img src="https://crests.football-data.org/65.png"
                                        class="w-4 h-4 object-contain shrink-0" alt="Man City" />
                                    <span class="text-white font-semibold truncate">Manchester City</span>
                                </div>
                                <h3
                                    class="font-bold text-white text-sm sm:text-base group-hover:text-[#408A71] transition-colors line-clamp-2">
                                    Arsenal vs Manchester City: Drama Sengit Menit Akhir di Emirates
                                </h3>
                                <p class="text-xs text-slate-400 leading-relaxed line-clamp-2">
                                    Pertarungan intensitas tinggi dengan 28 total tembakan. Cuplikan gol penyeimbang di
                                    injury time serta duel taktis Mikel Arteta vs Pep Guardiola.
                                </p>
                            </div>
                        </div>
                        <div class="px-5 pb-5 pt-2 border-t border-[#285A48]/40">
                            <a href="https://www.youtube.com/watch?v=n7w0eI7e1B8" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-white hover:text-white bg-[#408A71]/10 hover:bg-[#408A71] border border-[#408A71]/30 transition-all duration-200">
                                <span>Tonton Video di YouTube</span>
                                <span class="font-mono">↗</span>
                            </a>
                        </div>
                    </div>

                    <div class="match-card rounded-2xl overflow-hidden flex flex-col justify-between group">
                        <div>
                            <div class="relative aspect-video w-full bg-[#091413] overflow-hidden">
                                <iframe class="w-full h-full border-0"
                                    src="https://www.youtube-nocookie.com/embed/kY3Onr6f6j8?rel=0"
                                    title="Liverpool vs Chelsea" loading="lazy"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <div class="p-5 space-y-3">
                                <div class="flex items-center justify-between text-xs">
                                    <span
                                        class="font-bold text-[#408A71] bg-[#285A48]/30 px-2 py-0.5 rounded border border-[#285A48] truncate max-w-[180px]">
                                        🏴󠁧󠁢󠁥󠁮󠁧󠁿 Premier League
                                    </span>
                                    <span
                                        class="text-slate-400 font-mono text-[11px] bg-[#091413] px-2 py-0.5 rounded border border-[#285A48] shrink-0">
                                        ⏱️ Pekan ke-5
                                    </span>
                                </div>
                                <div
                                    class="flex items-center gap-2 text-xs font-medium text-slate-300 py-1 border-b border-[#285A48]/50">
                                    <img src="https://crests.football-data.org/64.png"
                                        class="w-4 h-4 object-contain shrink-0" alt="Liverpool" />
                                    <span class="text-white font-semibold truncate">Liverpool</span>
                                    <span class="text-[#408A71] font-bold">vs</span>
                                    <img src="https://crests.football-data.org/61.png"
                                        class="w-4 h-4 object-contain shrink-0" alt="Chelsea" />
                                    <span class="text-white font-semibold truncate">Chelsea</span>
                                </div>
                                <h3
                                    class="font-bold text-white text-sm sm:text-base group-hover:text-[#408A71] transition-colors line-clamp-2">
                                    Liverpool vs Chelsea: Pertarungan Sengit Papan Atas di Anfield
                                </h3>
                                <p class="text-xs text-slate-400 leading-relaxed line-clamp-2">
                                    Aksi serangan balik kilat The Reds dan penyelamatan krusial di bawah mistar gawang dalam
                                    laga panas Super Sunday.
                                </p>
                            </div>
                        </div>
                        <div class="px-5 pb-5 pt-2 border-t border-[#285A48]/40">
                            <a href="https://www.youtube.com/watch?v=kY3Onr6f6j8" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-white hover:text-white bg-[#408A71]/10 hover:bg-[#408A71] border border-[#408A71]/30 transition-all duration-200">
                                <span>Tonton Video di YouTube</span>
                                <span class="font-mono">↗</span>
                            </a>
                        </div>
                    </div>

                    <div class="match-card rounded-2xl overflow-hidden flex flex-col justify-between group">
                        <div>
                            <div class="relative aspect-video w-full bg-[#091413] overflow-hidden">
                                <iframe class="w-full h-full border-0"
                                    src="https://www.youtube-nocookie.com/embed/5qap5aO4i9A?rel=0"
                                    title="Real Madrid vs FC Barcelona" loading="lazy"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <div class="p-5 space-y-3">
                                <div class="flex items-center justify-between text-xs">
                                    <span
                                        class="font-bold text-[#408A71] bg-[#285A48]/30 px-2 py-0.5 rounded border border-[#285A48] truncate max-w-[180px]">
                                        🇪🇸 La Liga
                                    </span>
                                    <span
                                        class="text-slate-400 font-mono text-[11px] bg-[#091413] px-2 py-0.5 rounded border border-[#285A48] shrink-0">
                                        ⏱️ El Clásico
                                    </span>
                                </div>
                                <div
                                    class="flex items-center gap-2 text-xs font-medium text-slate-300 py-1 border-b border-[#285A48]/50">
                                    <img src="https://crests.football-data.org/86.png"
                                        class="w-4 h-4 object-contain shrink-0" alt="Real Madrid" />
                                    <span class="text-white font-semibold truncate">Real Madrid</span>
                                    <span class="text-[#408A71] font-bold">vs</span>
                                    <img src="https://crests.football-data.org/81.png"
                                        class="w-4 h-4 object-contain shrink-0" alt="Barcelona" />
                                    <span class="text-white font-semibold truncate">FC Barcelona</span>
                                </div>
                                <h3
                                    class="font-bold text-white text-sm sm:text-base group-hover:text-[#408A71] transition-colors line-clamp-2">
                                    Real Madrid vs FC Barcelona: El Clásico Penuh Gengsi 5 Gol di Santiago Bernabéu
                                </h3>
                                <p class="text-xs text-slate-400 leading-relaxed line-clamp-2">
                                    Rangkuman aksi serangan balik cepat Real Madrid dan dominasi penguasaan bola Barcelona
                                    yang menghasilkan duel sengit hingga menit akhir.
                                </p>
                            </div>
                        </div>
                        <div class="px-5 pb-5 pt-2 border-t border-[#285A48]/40">
                            <a href="https://www.youtube.com/watch?v=5qap5aO4i9A" target="_blank"
                                rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-white hover:text-white bg-[#408A71]/10 hover:bg-[#408A71] border border-[#408A71]/30 transition-all duration-200">
                                <span>Tonton Video di YouTube</span>
                                <span class="font-mono">↗</span>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- 4. SECTION PREDIKSI & AKURASI DATA -->
    <section id="prediksi" class="py-16 md:py-24 border-b border-slate-800/60 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Bagaimana AI Kami Menghasilkan Prediksi Berakurasi Tinggi?
                </h2>
                <p class="text-slate-400 text-sm sm:text-base">
                    Bukan berdasarkan firasat. Setiap angka probabilitas dihitung melalui kalkulasi matematis
                    objektif dan data historis ribuan laga.
                </p>
            </div>

            <!-- 4 Key Metrics Strip (Matte Solid) -->
            <div id="akurasi"
                class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 mb-16 divide-y sm:divide-y-0 sm:divide-x divide-[#285A48] bg-[#0e1f1e] p-6 sm:p-8 rounded-2xl border border-[#285A48]">

                <div class="pt-4 sm:pt-0 sm:px-4 first:px-0">
                    <div class="font-mono text-3xl sm:text-4xl font-bold text-[#408A71] tracking-tight">88.4%
                    </div>
                    <div class="text-xs font-semibold uppercase tracking-wider text-white mt-1">Hit Rate Teruji
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Validasi silang di Top 5 Liga Eropa</p>
                </div>

                <div class="pt-4 sm:pt-0 sm:px-4">
                    <div class="font-mono text-3xl sm:text-4xl font-bold text-[#408A71] tracking-tight">120k+
                    </div>
                    <div class="text-xs font-semibold uppercase tracking-wider text-white mt-1">Simulasi Match /
                        Jam</div>
                    <p class="text-xs text-slate-400 mt-0.5">Iterasi Monte Carlo multithreaded</p>
                </div>

                <div class="pt-4 sm:pt-0 sm:px-4">
                    <div class="font-mono text-3xl sm:text-4xl font-bold text-[#408A71] tracking-tight">&lt; 200ms
                    </div>
                    <div class="text-xs font-semibold uppercase tracking-wider text-white mt-1">Latensi Prediksi
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Respon instan saat line-up resmi keluar</p>
                </div>

                <div class="pt-4 sm:pt-0 sm:px-4">
                    <div class="font-mono text-3xl sm:text-4xl font-bold text-slate-200 tracking-tight">42+</div>
                    <div class="text-xs font-semibold uppercase tracking-wider text-white mt-1">Variabel Per Laga
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">xG, cedera, cuaca, dan formasi taktis</p>
                </div>

            </div>

            <!-- 3 Pillars Grid (Matte Solid) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-[#0e1f1e] border border-[#285A48] rounded-2xl p-6 space-y-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-[#285A48] text-[#408A71] flex items-center justify-center font-mono font-bold text-sm">
                        01
                    </div>
                    <h3 class="font-bold text-base text-white">Algoritma Poisson & xG Terintegrasi</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Mengevaluasi kualitas peluang tembakan (Expected Goals) dan distribusi Poisson untuk
                        memetakan probabilitas skor yang realistis, bukan hanya melihat riwayat menang-kalah biasa.
                    </p>
                </div>

                <div class="bg-[#0e1f1e] border border-[#285A48] rounded-2xl p-6 space-y-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-[#285A48] text-[#408A71] flex items-center justify-center font-mono font-bold text-sm">
                        02
                    </div>
                    <h3 class="font-bold text-base text-white">Dynamic Squad & Line-up Feed</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Membaca secara otomatis susunan starting XI resmi 60 menit sebelum kick-off, kondisi cedera
                        pemain pilar, serta rotasi menit akhir pelatih.
                    </p>
                </div>

                <div class="bg-[#0e1f1e] border border-[#285A48] rounded-2xl p-6 space-y-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-[#285A48] text-[#408A71] flex items-center justify-center font-mono font-bold text-sm">
                        03
                    </div>
                    <h3 class="font-bold text-base text-white">Backtested on 10 Seasons</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Model telah divalidasi silang terhadap lebih dari 35.000 riwayat pertandingan liga-liga
                        besar guna memastikan kestabilan akurasi tanpa over-fitting.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- 5. BANNER CTA PERSUASIF MENUJU CHATBOT ADK (Matte Solid) -->
    <section class="py-16 md:py-24 relative overflow-hidden bg-[#091413] border-t border-[#285A48]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">

            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Ingin Analisis Laga Tertentu Secara Khusus?
            </h2>

            <p class="text-sm sm:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
                Gunakan asisten AI untuk menanyakan simulasi skor, prediksi corner, kondisi pemain absen, hingga
                value peluang pertandingan favorit Anda secara mendalam dan cepat.
            </p>

            <div class="pt-3">
                <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl text-base font-bold text-white bg-[#408A71] hover:bg-[#34725d] transition-all">
                    <span>Mulai Chat dengan Asisten AI Sekarang</span>
                    <span class="font-mono font-bold text-lg">↗</span>
                </a>
            </div>

            <div class="flex items-center justify-center gap-6 text-xs text-slate-400 pt-2 font-mono">
                <span>✓ Langsung Terhubung ke Bot AI</span>
                <span>✓ Bebas Tanya Seputar Semua Liga</span>
                <span>✓ Respon Cepat & Objektif</span>
            </div>

        </div>
    </section>
@endsection
