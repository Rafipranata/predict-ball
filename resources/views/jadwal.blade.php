@section('jadwal')
        <section id="jadwal" class="py-16 md:py-24 border-b border-[#285A48] bg-[#091413]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                    <div class="space-y-2">
                        <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                            Hasil & Jadwal Pertandingan
                        </h2>
                        <p class="text-sm sm:text-base text-slate-400 max-w-2xl">
                            Tinjau jadwal pertandingan hari ini dan hasil laga terkini beserta kalkulasi probabilitas model NataAI.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <!-- Day Selector Filter (Default Hari Ini) -->
                        <div class="inline-flex p-1 rounded-xl bg-[#0e1f1e] border border-[#285A48] text-xs font-semibold">
                            <a href="?day=kemarin#jadwal"
                                class="px-3 py-1.5 rounded-lg transition-all duration-200 {{ ($currentDay ?? 'hari-ini') === 'kemarin' ? 'bg-[#408A71] text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">
                                Kemarin
                            </a>
                            <a href="?day=hari-ini#jadwal"
                                class="px-3 py-1.5 rounded-lg transition-all duration-200 {{ ($currentDay ?? 'hari-ini') === 'hari-ini' ? 'bg-[#408A71] text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">
                                Hari Ini
                            </a>
                            <a href="?day=besok#jadwal"
                                class="px-3 py-1.5 rounded-lg transition-all duration-200 {{ ($currentDay ?? 'hari-ini') === 'besok' ? 'bg-[#408A71] text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">
                                Besok
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Bar & Search Controls (Matte Clean) -->
                <div class="mb-8 space-y-4">
                    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
                        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-2 lg:pb-0 scroll-smooth"
                            id="category-tabs">
                            @foreach($matchCategories ?? [] as $category)
                                <button type="button" data-category="{{ $category['slug'] }}"
                                    class="category-btn {{ $loop->first ? 'active bg-[#408A71] border-[#408A71] text-white' : 'border-[#285A48] bg-[#0e1f1e] text-slate-300 hover:text-white hover:border-[#408A71]' }} px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-200 flex items-center gap-2 border">
                                    @if(!empty($category['emblem']))
                                        <img src="{{ $category['emblem'] }}" alt="{{ $category['name'] }}" class="w-4 h-4 object-contain shrink-0 drop-shadow-sm" loading="lazy" onerror="this.style.display='none'" />
                                    @elseif($category['slug'] === 'all')
                                        <span class="text-sm shrink-0"></span>
                                    @else
                                        <span class="text-sm shrink-0"></span>
                                    @endif
                                    <span class="category-name">{{ $category['name'] }}</span>
                                    <span
                                        class="category-badge px-1.5 py-0.5 rounded-full text-[10px] {{ $loop->first ? 'bg-[#285A48] text-white' : 'bg-[#091413] text-slate-400' }}">{{ $category['count'] }}</span>
                                </button>
                            @endforeach
                        </div>

                        <!-- Quick Search Input (Matte) -->
                        <div class="relative w-full lg:w-72 shrink-0">
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input id="match-search" type="text" placeholder="Cari klub atau laga..."
                                class="w-full pl-9 pr-8 py-2 rounded-xl bg-[#0e1f1e] border border-[#285A48] text-xs text-white placeholder-slate-400 focus:outline-none focus:border-[#408A71] transition-colors" />
                            <button id="match-search-clear" type="button"
                                class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-white"
                                title="Hapus pencarian">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                    </div>

                    <!-- Status / Active Filter Feedback -->
                    <div
                        class="flex items-center justify-between text-xs font-mono text-slate-400 border-t border-[#285A48] pt-3">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span>Menampilkan <strong id="visible-match-count" class="text-[#408A71] font-bold">{{ $totalMatches ?? count($todaysMatches ?? []) }}</strong>
                            pertandingan (<span class="text-white">{{ $targetDateFormatted }}</span>)</span>
                        </div>
                        <div class="hidden sm:block text-[11px] text-slate-400">
                            Klik kartu untuk bertanya taktik spesifik ke Chatbot
                        </div>
                    </div>
                </div>

                <!-- Match Cards Grid -->
                <div id="match-cards-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @forelse($todaysMatches ?? [] as $match)
                        <div class="match-card rounded-2xl p-6 flex flex-col justify-between"
                            data-category="{{ $match['categorySlug'] }}"
                            data-teams="{{ $match['searchKeywords'] }}">
                            <div>
                                <!-- Header: Competition & Time/Status -->
                                <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                    <div class="flex items-center gap-2 min-w-0 pr-2">
                                        @if(!empty($match['competition']['emblem']))
                                            <img src="{{ $match['competition']['emblem'] }}" alt="{{ $match['competition']['name'] }}" class="w-4 h-4 object-contain shrink-0" loading="lazy" onerror="this.style.display='none'" />
                                        @else
                                            <span class="text-sm shrink-0">{{ $match['categoryIcon'] }}</span>
                                        @endif
                                        <span class="font-bold text-slate-200 truncate">
                                            {{ $match['competition']['name'] }}
                                        </span>
                                        <span class="text-slate-500 shrink-0">•</span>
                                        <span class="text-slate-400 shrink-0 text-[11px]">{{ $match['competition']['stage'] }}</span>
                                    </div>
                                </div>

                                <!-- Teams & Live/xG Scores -->
                                <div class="py-5 space-y-3.5">
                                    <!-- Home Team -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3 min-w-0 pr-2">
                                            @if(!empty($match['homeTeam']['crest']))
                                                <img src="{{ $match['homeTeam']['crest'] }}" alt="{{ $match['homeTeam']['name'] }}" class="w-6 h-6 object-contain shrink-0" loading="lazy" onerror="this.style.display='none'" />
                                            @else
                                                <span class="text-lg shrink-0">⚽</span>
                                            @endif
                                            <span class="font-bold text-white text-base truncate" title="{{ $match['homeTeam']['fullName'] }}">
                                                {{ $match['homeTeam']['name'] }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            @if(isset($match['score']['home']) && is_numeric($match['score']['home']))
                                                <span class="text-base font-extrabold font-mono px-3 py-0.5 rounded-lg {{ ($match['score']['home'] > ($match['score']['away'] ?? -1)) ? 'bg-[#408A71]/25 text-emerald-300 border border-[#408A71]' : 'bg-slate-900 text-slate-300 border border-slate-800' }}">
                                                    {{ $match['score']['home'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Away Team -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3 min-w-0 pr-2">
                                            @if(!empty($match['awayTeam']['crest']))
                                                <img src="{{ $match['awayTeam']['crest'] }}" alt="{{ $match['awayTeam']['name'] }}" class="w-6 h-6 object-contain shrink-0" loading="lazy" onerror="this.style.display='none'" />
                                            @else
                                                <span class="text-lg shrink-0">⚽</span>
                                            @endif
                                            <span class="font-bold text-white text-base truncate" title="{{ $match['awayTeam']['fullName'] }}">
                                                {{ $match['awayTeam']['name'] }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            @if(isset($match['score']['away']) && is_numeric($match['score']['away']))
                                                <span class="text-base font-extrabold font-mono px-3 py-0.5 rounded-lg {{ ($match['score']['away'] > ($match['score']['home'] ?? -1)) ? 'bg-[#408A71]/25 text-emerald-300 border border-[#408A71]' : 'bg-slate-900 text-slate-300 border border-slate-800' }}">
                                                    {{ $match['score']['away'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Probability Bar -->
                                    <div class="pt-3">
                                        <div class="flex justify-between text-xs font-mono mb-1.5">
                                            <span class="text-emerald-400 font-bold truncate pr-1">{{ $match['homeTeam']['name'] }} {{ $match['predictions']['homeProb'] }}%</span>
                                            <span class="text-slate-400 shrink-0 px-1">Seri {{ $match['predictions']['drawProb'] }}%</span>
                                            <span class="text-sky-400 font-bold truncate pl-1 text-right">{{ $match['awayTeam']['name'] }} {{ $match['predictions']['awayProb'] }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                            <div class="bg-emerald-400 h-full" style="width: {{ $match['predictions']['homeProb'] }}%"
                                                title="{{ $match['homeTeam']['name'] }}: {{ $match['predictions']['homeProb'] }}%"></div>
                                            <div class="bg-slate-500 h-full" style="width: {{ $match['predictions']['drawProb'] }}%"
                                                title="Seri: {{ $match['predictions']['drawProb'] }}%"></div>
                                            <div class="bg-sky-400 h-full" style="width: {{ $match['predictions']['awayProb'] }}%"
                                                title="{{ $match['awayTeam']['name'] }}: {{ $match['predictions']['awayProb'] }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Matchday & Tanggal Pertandingan -->
                                    <div
                                        class="p-3.5 rounded-xl  bg-[#0e1f1e] border border-[#285A48] text-xs  flex items-center justify-center mt-4">

                                        <div class="flex items-center text-[11px] font-mono text-slate-300 shrink-0">
                                            <span class="text-white font-medium">{{ $match['fullDate'] ?? $match['wibDate'] }}</span>
                                            <span class="text-slate-500">•</span>
                                            <span class="text-emerald-400 font-semibold">{{ $match['wibTime'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mini CTA to Chatbot -->
                            <div class="pt-4 border-t border-slate-800/80 mt-auto">
                                <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                    class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                    <span>Minta Rincian Taktis di Chatbot</span>
                                    <span class="font-mono">→</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 px-4 rounded-2xl bg-[#0e1f1e] border border-[#285A48] text-center space-y-3">
                            <div class="text-3xl">⚽</div>
                            <h3 class="text-base font-bold text-white">Tidak ada data pertandingan untuk {{ $targetDateFormatted }}</h3>
                            <p class="text-xs text-slate-400 max-w-md mx-auto">
                                Kompetisi yang terdaftar sedang tidak memiliki jadwal laga aktif untuk periode ini. Silakan periksa pilihan hari lainnya.
                            </p>
                        </div>
                    @endforelse

                </div>

                <!-- Empty State (Hidden by default) -->
                <div id="no-matches-found"
                    class="hidden py-16 px-4 rounded-2xl bg-[#0e1f1e] border border-[#285A48] text-center space-y-4 my-6">
                    <div
                        class="w-14 h-14 mx-auto rounded-2xl bg-[#091413] border border-[#285A48] flex items-center justify-center text-2xl text-[#408A71]">
                        🔍
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-base font-bold text-white">Tidak ada pertandingan yang cocok</h3>
                        <p class="text-xs text-slate-400 max-w-md mx-auto">
                            Tidak ditemukan jadwal untuk kategori atau kata kunci yang Anda masukkan. Silakan coba kata
                            kunci lain atau reset filter.
                        </p>
                    </div>
                    <button type="button" id="reset-filter-btn"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-[#408A71] hover:bg-[#34725d] text-white transition">
                        <span>Tampilkan Semua Pertandingan</span>
                        <span class="font-mono">↺</span>
                    </button>
                </div>

                <!-- Bot Prompt Suggestion Strip (Matte) -->
                <div
                    class="mt-10 p-5 rounded-2xl bg-[#0e1f1e] border border-[#285A48] flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5 text-xs text-slate-300">
                        <div
                            class="w-10 h-10 rounded-xl bg-[#091413] border border-[#285A48] text-[#408A71] flex items-center justify-center text-lg shrink-0">
                            💬
                        </div>
                        <div>
                            <div class="font-bold text-white text-sm">Butuh analisis untuk pertandingan atau liga
                                lainnya?</div>
                            <p class="text-slate-400 text-xs">Tanyakan simulasi skor, tren kartu, prediksi corner,
                                hingga handicap langsung ke Chatbot AI.</p>
                        </div>
                    </div>
                    <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-xs font-bold text-white bg-[#408A71] hover:bg-[#34725d] transition shrink-0">
                        <span>Tanya Chatbot Sekarang</span>
                        <span class="font-mono text-sm">↗</span>
                    </a>
                </div>

            </div>
        </section>
@endsection