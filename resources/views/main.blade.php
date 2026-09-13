<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NataAI — Platform Prediksi Skor & Jadwal Bola Akurat Berbasis AI</title>
    <meta name="description"
        content="Platform prediksi bola akurat dan jadwal pertandingan sepak bola terlengkap. Analisis data mendalam berbasis xG, simulasi Monte Carlo, dan update tim terkini." />

    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Inter"', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        // Palet Warna Kustom Pengguna (#091413, #285A48, #408A71)
                        palette: {
                            darkest: '#091413', // rgb(9, 20, 19)
                            dark: '#285A48', // rgb(40, 90, 72)
                            primary: '#408A71', // rgb(64, 138, 113)
                            light: '#5fb898', // rgb(95, 184, 152)
                        },
                        slate: {
                            50: '#f4f8f6',
                            100: '#e5f1ec',
                            200: '#cce3da',
                            300: '#a3cdc0',
                            400: '#5fb898', // light jade accent
                            500: '#408A71',
                            600: '#34725d',
                            700: '#2c6351',
                            800: '#285A48', // forest green border / surface
                            850: '#1b3f32',
                            900: '#0e1f1e', // elevated dark surface
                            950: '#091413', // darkest base background
                        },
                        emerald: {
                            50: '#f4f8f6',
                            100: '#e5f1ec',
                            200: '#cce3da',
                            300: '#a3cdc0',
                            400: '#5fb898', // light jade accent
                            500: '#408A71', // vibrant primary jade accent
                            600: '#34725d',
                            700: '#2c6351',
                            800: '#285A48', // forest green
                            900: '#153229',
                            950: '#091413', // darkest base
                        },
                        cyan: {
                            400: '#5fb898',
                            500: '#408A71',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #091413;
            color: #e5f1ec;
            overflow-x: hidden;
            max-width: 100vw;
        }

        .bg-tech-grid {
            background-image: linear-gradient(to right, rgba(40, 90, 72, 0.3) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(40, 90, 72, 0.3) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .match-card {
            background: #0e1f1e;
            border: 1px solid #285A48;
            transition: all 0.2s ease;
        }

        .match-card:hover {
            border-color: #408A71;
            transform: translateY(-2px);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInScale 0.2s ease-out forwards;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #091413;
        }

        ::-webkit-scrollbar-thumb {
            background: #285A48;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #408A71;
        }

        /* Navbar Right Links: Default White, Active & Hover Green */
        .nav-link {
            color: #ffffff;
            transition: color 0.15s ease-in-out;
        }

        .nav-link:hover {
            color: #408A71;
        }

        .nav-link.active {
            color: #408A71 !important;
            font-weight: 600;
        }

        /* Floating Balls in Header */
        @keyframes floatBall1 {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-8px) rotate(16deg);
            }
        }

        @keyframes floatBall2 {

            0%,
            100% {
                transform: translateY(-4px) rotate(0deg) scale(0.96);
            }

            50% {
                transform: translateY(6px) rotate(-18deg) scale(1.04);
            }
        }

        @keyframes floatBall3 {

            0%,
            100% {
                transform: translateY(2px) rotate(0deg);
            }

            50% {
                transform: translateY(-7px) rotate(22deg);
            }
        }

        @keyframes floatOrb {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.2;
            }

            50% {
                transform: translate(5px, -6px) scale(1.2);
                opacity: 0.45;
            }
        }

        .floating-ball-1 {
            animation: floatBall1 6s ease-in-out infinite;
        }

        .floating-ball-2 {
            animation: floatBall2 8s ease-in-out infinite;
        }

        .floating-ball-3 {
            animation: floatBall3 7s ease-in-out infinite;
        }

        .floating-orb {
            animation: floatOrb 5s ease-in-out infinite;
        }
    </style>
</head>

<body
    class="font-sans antialiased text-slate-200 selection:bg-[#408A71] selection:text-white min-h-screen flex flex-col justify-between bg-[#091413]">

    <!-- Background Clean Structural Pattern (Matte, No Glossy Glow) -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-tech-grid opacity-25"></div>
    </div>

    <!-- 1. NAVBAR (Matte Flat Clean with Floating Balls Background) -->
    <header class="sticky top-0 z-50 w-full bg-[#091413] border-b border-[#285A48] relative overflow-hidden">
        <!-- Floating Soccer Balls & Orbs Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0 select-none" aria-hidden="true">
            <!-- Floating Ball 1 -->
            <div class="absolute -top-1 left-[3%] floating-ball-1 opacity-25">
                <svg class="w-10 h-10 text-[#408A71]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.2">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.2" />
                    <polygon points="12 7, 8.5 9.5, 9.8 13.5, 14.2 13.5, 15.5 9.5" fill="currentColor"
                        fill-opacity="0.35" stroke="currentColor" stroke-width="1" />
                    <line x1="12" y1="7" x2="12" y2="2" stroke="currentColor" />
                    <line x1="8.5" y1="9.5" x2="3.5" y2="8" stroke="currentColor" />
                    <line x1="9.8" y1="13.5" x2="6" y2="18.5" stroke="currentColor" />
                    <line x1="14.2" y1="13.5" x2="18" y2="18.5" stroke="currentColor" />
                    <line x1="15.5" y1="9.5" x2="20.5" y2="8" stroke="currentColor" />
                </svg>
            </div>

            <!-- Glowing Orb 1 -->
            <div class="absolute top-6 left-[16%] w-5 h-5 rounded-full bg-[#408A71]/25 blur-sm floating-orb"></div>

            <!-- Floating Ball 2 -->
            <div class="absolute top-3 left-[28%] floating-ball-2 opacity-20">
                <svg class="w-7 h-7 text-[#5fb898]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.2">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.2" />
                    <polygon points="12 7, 8.5 9.5, 9.8 13.5, 14.2 13.5, 15.5 9.5" fill="currentColor"
                        fill-opacity="0.35" stroke="currentColor" stroke-width="1" />
                    <line x1="12" y1="7" x2="12" y2="2" stroke="currentColor" />
                    <line x1="8.5" y1="9.5" x2="3.5" y2="8" stroke="currentColor" />
                    <line x1="9.8" y1="13.5" x2="6" y2="18.5" stroke="currentColor" />
                    <line x1="14.2" y1="13.5" x2="18" y2="18.5" stroke="currentColor" />
                    <line x1="15.5" y1="9.5" x2="20.5" y2="8" stroke="currentColor" />
                </svg>
            </div>

            <!-- Floating Ball 3 (Center) -->
            <div class="absolute -bottom-1 left-[48%] floating-ball-3 opacity-15">
                <svg class="w-11 h-11 text-[#285A48]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.2">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.2" />
                    <polygon points="12 7, 8.5 9.5, 9.8 13.5, 14.2 13.5, 15.5 9.5" fill="currentColor"
                        fill-opacity="0.35" stroke="currentColor" stroke-width="1" />
                    <line x1="12" y1="7" x2="12" y2="2" stroke="currentColor" />
                    <line x1="8.5" y1="9.5" x2="3.5" y2="8" stroke="currentColor" />
                    <line x1="9.8" y1="13.5" x2="6" y2="18.5" stroke="currentColor" />
                    <line x1="14.2" y1="13.5" x2="18" y2="18.5" stroke="currentColor" />
                    <line x1="15.5" y1="9.5" x2="20.5" y2="8" stroke="currentColor" />
                </svg>
            </div>

            <!-- Glowing Orb 2 -->
            <div class="absolute top-3 left-[63%] w-7 h-7 rounded-full bg-[#408A71]/20 blur-sm floating-orb"
                style="animation-delay: -2.5s;"></div>

            <!-- Floating Ball 4 -->
            <div class="absolute top-2 left-[76%] floating-ball-1 opacity-20" style="animation-delay: -3s;">
                <svg class="w-8 h-8 text-[#408A71]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.2">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.2" />
                    <polygon points="12 7, 8.5 9.5, 9.8 13.5, 14.2 13.5, 15.5 9.5" fill="currentColor"
                        fill-opacity="0.35" stroke="currentColor" stroke-width="1" />
                    <line x1="12" y1="7" x2="12" y2="2" stroke="currentColor" />
                    <line x1="8.5" y1="9.5" x2="3.5" y2="8" stroke="currentColor" />
                    <line x1="9.8" y1="13.5" x2="6" y2="18.5" stroke="currentColor" />
                    <line x1="14.2" y1="13.5" x2="18" y2="18.5" stroke="currentColor" />
                    <line x1="15.5" y1="9.5" x2="20.5" y2="8" stroke="currentColor" />
                </svg>
            </div>

            <!-- Floating Ball 5 -->
            <div class="absolute -top-1 right-[2%] floating-ball-2 opacity-25" style="animation-delay: -1.5s;">
                <svg class="w-9 h-9 text-[#5fb898]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.2">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.2" />
                    <polygon points="12 7, 8.5 9.5, 9.8 13.5, 14.2 13.5, 15.5 9.5" fill="currentColor"
                        fill-opacity="0.35" stroke="currentColor" stroke-width="1" />
                    <line x1="12" y1="7" x2="12" y2="2" stroke="currentColor" />
                    <line x1="8.5" y1="9.5" x2="3.5" y2="8" stroke="currentColor" />
                    <line x1="9.8" y1="13.5" x2="6" y2="18.5" stroke="currentColor" />
                    <line x1="14.2" y1="13.5" x2="18" y2="18.5" stroke="currentColor" />
                    <line x1="15.5" y1="9.5" x2="20.5" y2="8" stroke="currentColor" />
                </svg>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex items-center justify-between h-20">

                <!-- Brand & Slogan -->
                <a href="#" class="flex items-center gap-3.5 group">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-lg tracking-tight text-white">
                                Nata<span class="text-[#408A71]">AI</span>
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium tracking-tight">
                            Platform Prediksi & Jadwal Bola Akurat
                        </p>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <a href="#jadwal" class="nav-link flex items-center gap-1.5">
                        <span>Jadwal Laga</span>
                    </a>
                    <a href="#highlights" class="nav-link flex items-center gap-1.5">
                        <span>Highlights</span>
                    </a>
                    <a href="#prediksi" class="nav-link flex items-center gap-1.5">
                        <span>Prediksi AI</span>
                    </a>
                    <a href="#akurasi" class="nav-link flex items-center gap-1.5">
                        <span>Akurasi & Data</span>
                    </a>
                </nav>

                <!-- Right Action Button (Chatbot ADK CTA) -->

                <!-- Mobile Hamburger Toggle -->
                <button id="mobile-toggle" aria-label="Toggle Menu"
                    class="p-2.5 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-white md:hidden">
                    <svg id="icon-bars" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

        </div>
        </div>

        <!-- Mobile Drawer (Matte Solid) -->
        <div id="mobile-menu"
            class="hidden md:hidden border-b border-[#285A48] bg-[#091413] px-4 pt-3 pb-6 space-y-3 relative z-10">
            <a href="#jadwal" class="nav-link mobile-link block px-2 py-2 text-sm">Jadwal Laga Hari Ini</a>
            <a href="#highlights" class="nav-link mobile-link block px-2 py-2 text-sm">Highlights</a>
            <a href="#prediksi" class="nav-link mobile-link block px-2 py-2 text-sm">Prediksi AI</a>
            <a href="#akurasi" class="nav-link mobile-link block px-2 py-2 text-sm">Akurasi Data</a>

        </div>
    </header>

    <main class="relative z-10 flex-1">

        <!-- 2. HERO SECTION (Full Screen on Desktop) -->
        <section
            class="relative min-h-[calc(100vh-5rem)] flex flex-col justify-center items-center py-16 md:py-0 overflow-hidden border-b border-[#285A48]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full my-auto">

                <div class="max-w-3xl mx-auto text-center space-y-6 md:space-y-8">

                    <!-- Headline H1 -->
                    <h1
                        class="font-extrabold text-3xl sm:text-5xl lg:text-6xl tracking-tight text-white leading-[1.15]">
                        Prediksi Bola & Analisis Pertandingan Berbasis <span class="text-[#408A71]">AI</span>
                    </h1>

                    <!-- Deskripsi Pendukung -->
                    <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed">
                        Dapatkan kepastian analisis sebelum laga dimulai. Algoritma kami secara otomatis menyintesis
                        statistik performa tim, tren kualitas peluang (xG), rekor head-to-head historis, hingga update
                        kondisi skuad pemain terkini untuk menghasilkan estimasi hasil laga yang objektif dan terukur.
                    </p>

                    <!-- Dual CTAs (Matte Clean) -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 pt-2">
                        <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-4 rounded-xl text-sm font-semibold text-white bg-[#408A71] hover:bg-[#34725d] transition-all shadow-sm">
                            <span>Tanya Prediksi ke AI (Buka Chatbot)</span>
                            <span class="font-mono font-bold">↗</span>
                        </a>

                    </div>

                </div>

            </div>

            <!-- Bottom Scroll Cue for Desktop -->
            <div class="hidden md:flex justify-center pb-8 pt-4">
                <a href="#jadwal"
                    class="inline-flex flex-col items-center gap-2 text-xs font-mono text-slate-400 hover:text-[#408A71] transition-colors">
                    <span>Scroll untuk Jadwal Pertandingan</span>
                    <svg class="w-4 h-4 animate-bounce text-[#408A71]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>
        </section>

        <!-- 3. DEDICATED SECTION: JADWAL PERTANDINGAN & PREDIKSI HARIAN -->
        <section id="jadwal" class="py-16 md:py-24 border-b border-[#285A48] bg-[#091413]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                    <div class="space-y-2">
                        <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                            Jadwal Pertandingan & Estimasi Probabilitas
                        </h2>
                        <p class="text-sm sm:text-base text-slate-400 max-w-2xl">
                            Pilih kategori kompetisi favorit Anda untuk meninjau jadwal laga dan estimasi peluang hasil
                            pertandingan berdasarkan kalkulasi model AI.
                        </p>
                    </div>

                    <div class="text-xs font-mono text-slate-400 shrink-0">
                        Zona Waktu: <strong class="text-white">WIB (GMT+7)</strong>
                    </div>
                </div>

                <!-- Filter Bar & Search Controls (Matte Clean) -->
                <div class="mb-8 space-y-4">
                    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">

                        <!-- Category Pills (Horizontal Scroll on Mobile) -->
                        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-2 lg:pb-0 scroll-smooth"
                            id="category-tabs">
                            <button type="button" data-category="all"
                                class="category-btn active px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-200 flex items-center gap-2 border bg-[#408A71] border-[#408A71] text-white">
                                <span>🌍 Semua Laga</span>
                                <span
                                    class="category-badge px-1.5 py-0.5 rounded-full text-[10px] bg-[#285A48] text-white">12</span>
                            </button>

                            <button type="button" data-category="premier-league"
                                class="category-btn px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-200 flex items-center gap-2 border border-[#285A48] bg-[#0e1f1e] text-slate-300 hover:text-white hover:border-[#408A71]">
                                <span>🏴󠁧󠁢󠁥󠁮󠁧󠁿 Premier League</span>
                                <span
                                    class="category-badge px-1.5 py-0.5 rounded-full text-[10px] bg-[#091413] text-slate-400">2</span>
                            </button>

                            <button type="button" data-category="laliga"
                                class="category-btn px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-200 flex items-center gap-2 border border-[#285A48] bg-[#0e1f1e] text-slate-300 hover:text-white hover:border-[#408A71]">
                                <span>🇪🇸 La Liga</span>
                                <span
                                    class="category-badge px-1.5 py-0.5 rounded-full text-[10px] bg-[#091413] text-slate-400">2</span>
                            </button>

                            <button type="button" data-category="serie-a"
                                class="category-btn px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-200 flex items-center gap-2 border border-[#285A48] bg-[#0e1f1e] text-slate-300 hover:text-white hover:border-[#408A71]">
                                <span>🇮🇹 Serie A</span>
                                <span
                                    class="category-badge px-1.5 py-0.5 rounded-full text-[10px] bg-[#091413] text-slate-400">2</span>
                            </button>

                            <button type="button" data-category="bundesliga"
                                class="category-btn px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-200 flex items-center gap-2 border border-[#285A48] bg-[#0e1f1e] text-slate-300 hover:text-white hover:border-[#408A71]">
                                <span>🇩🇪 Bundesliga</span>
                                <span
                                    class="category-badge px-1.5 py-0.5 rounded-full text-[10px] bg-[#091413] text-slate-400">2</span>
                            </button>

                            <button type="button" data-category="champions-league"
                                class="category-btn px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-200 flex items-center gap-2 border border-[#285A48] bg-[#0e1f1e] text-slate-300 hover:text-white hover:border-[#408A71]">
                                <span>⭐ Champions League</span>
                                <span
                                    class="category-badge px-1.5 py-0.5 rounded-full text-[10px] bg-[#091413] text-slate-400">2</span>
                            </button>

                            <button type="button" data-category="liga-1"
                                class="category-btn px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-200 flex items-center gap-2 border border-[#285A48] bg-[#0e1f1e] text-slate-300 hover:text-white hover:border-[#408A71]">
                                <span>🇮🇩 BRI Liga 1</span>
                                <span
                                    class="category-badge px-1.5 py-0.5 rounded-full text-[10px] bg-[#091413] text-slate-400">2</span>
                            </button>
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
                        <div>
                            Menampilkan <span id="visible-match-count" class="text-[#408A71] font-bold">12</span>
                            pertandingan untuk: <span id="active-category-title"
                                class="text-white font-semibold">Semua Laga</span>
                        </div>
                        <div class="hidden sm:block text-[11px] text-slate-400">
                            Klik kartu untuk bertanya taktik spesifik ke Chatbot
                        </div>
                    </div>
                </div>

                <!-- Match Cards Grid -->
                <div id="match-cards-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Match 1: Premier League - Arsenal vs Man City -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between"
                        data-category="premier-league"
                        data-teams="arsenal manchester city liga inggris premier league big match">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-sky-400 bg-sky-500/10 px-2 py-0.5 rounded border border-sky-500/20">🏴󠁧󠁢󠁥󠁮󠁧󠁿
                                        Premier League</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">Pekan ke-32</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Sabtu, 23:30 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🔴</span>
                                        <span class="font-bold text-white text-base">Arsenal</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        2.15</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🔵</span>
                                        <span class="font-bold text-white text-base">Manchester City</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.88</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-emerald-400 font-bold">Arsenal 48%</span>
                                        <span class="text-slate-400">Seri 26%</span>
                                        <span class="text-sky-400 font-bold">City 26%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-emerald-400 h-full" style="width: 48%"
                                            title="Arsenal Win: 48%"></div>
                                        <div class="bg-slate-500 h-full" style="width: 26%" title="Seri: 26%"></div>
                                        <div class="bg-sky-400 h-full" style="width: 26%" title="City Win: 26%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Tren xG Arsenal lebih tajam
                                    dalam 5 laga kandang terakhir. Probabilitas skor Over 2.5 mencapai
                                    <strong>65%</strong>.
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Match 2: Premier League - Liverpool vs Chelsea -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between"
                        data-category="premier-league"
                        data-teams="liverpool chelsea liga inggris premier league big match super sunday">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-sky-400 bg-sky-500/10 px-2 py-0.5 rounded border border-sky-500/20">🏴󠁧󠁢󠁥󠁮󠁧󠁿
                                        Premier League</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">Pekan ke-32</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Minggu, 22:30 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🔴</span>
                                        <span class="font-bold text-white text-base">Liverpool</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        2.30</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🔵</span>
                                        <span class="font-bold text-white text-base">Chelsea</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.45</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-emerald-400 font-bold">Liverpool 52%</span>
                                        <span class="text-slate-400">Seri 26%</span>
                                        <span class="text-sky-400 font-bold">Chelsea 22%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-emerald-400 h-full" style="width: 52%"
                                            title="Liverpool Win: 52%"></div>
                                        <div class="bg-slate-500 h-full" style="width: 26%" title="Seri: 26%"></div>
                                        <div class="bg-sky-400 h-full" style="width: 22%" title="Chelsea Win: 22%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Transisi cepat Liverpool di
                                    Anfield menghasilkan rasio konversi 19.4%. Rekomendasi probabilitas: Liverpool Draw
                                    No Bet.
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Match 3: La Liga - Real Madrid vs Barcelona -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between" data-category="laliga"
                        data-teams="real madrid barcelona el clasico liga spanyol laliga">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">🇪🇸
                                        La Liga</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">El Clásico</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Minggu, 02:00 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">👑</span>
                                        <span class="font-bold text-white text-base">Real Madrid</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.94</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🛡️</span>
                                        <span class="font-bold text-white text-base">FC Barcelona</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.72</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-amber-400 font-bold">Madrid 44%</span>
                                        <span class="text-slate-400">Seri 28%</span>
                                        <span class="text-cyan-400 font-bold">Barca 28%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-amber-400 h-full" style="width: 44%"
                                            title="Real Madrid Win: 44%"></div>
                                        <div class="bg-slate-500 h-full" style="width: 28%" title="Seri: 28%"></div>
                                        <div class="bg-cyan-400 h-full" style="width: 28%"
                                            title="Barcelona Win: 28%"></div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Efisiensi serangan balik Madrid
                                    di Bernabéu memegang keunggulan tipis. Kedua tim diproyeksikan mencetak gol (BTTS
                                    Yes 72%).
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Match 4: La Liga - Atletico Madrid vs Sevilla -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between" data-category="laliga"
                        data-teams="atletico madrid sevilla liga spanyol laliga metropolitano">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">🇪🇸
                                        La Liga</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">Pekan ke-31</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Senin, 02:00 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🔴⚪</span>
                                        <span class="font-bold text-white text-base">Atletico Madrid</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.85</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">⚪🔴</span>
                                        <span class="font-bold text-white text-base">Sevilla FC</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        0.95</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-emerald-400 font-bold">Atletico 55%</span>
                                        <span class="text-slate-400">Seri 25%</span>
                                        <span class="text-rose-400 font-bold">Sevilla 20%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-emerald-400 h-full" style="width: 55%"
                                            title="Atletico Win: 55%"></div>
                                        <div class="bg-slate-500 h-full" style="width: 25%" title="Seri: 25%"></div>
                                        <div class="bg-rose-400 h-full" style="width: 20%" title="Sevilla Win: 20%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Pertahanan rapat Atletico
                                    menghasilkan clean sheet probability 48%. Simulasi mengarah ke kemenangan tipis
                                    (Under 2.5 gol: 62%).
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Match 5: Serie A - Inter Milan vs AS Roma -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between" data-category="serie-a"
                        data-teams="inter milan as roma liga italia serie a san siro">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">🇮🇹
                                        Serie A</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">Big Match</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Minggu, 20:00 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🐍</span>
                                        <span class="font-bold text-white text-base">Inter Milan</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        2.20</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🐺</span>
                                        <span class="font-bold text-white text-base">AS Roma</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.10</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-emerald-400 font-bold">Inter 56%</span>
                                        <span class="text-slate-400">Seri 24%</span>
                                        <span class="text-rose-400 font-bold">Roma 20%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-emerald-400 h-full" style="width: 56%" title="Inter Win: 56%">
                                        </div>
                                        <div class="bg-slate-500 h-full" style="width: 24%" title="Seri: 24%"></div>
                                        <div class="bg-rose-400 h-full" style="width: 20%" title="Roma Win: 20%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Soliditas pertahanan Inter di
                                    kandang menghasilkan clean sheet probability 44%. Pilihan paling stabil: Inter Win.
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Match 6: Serie A - Juventus vs AC Milan -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between" data-category="serie-a"
                        data-teams="juventus ac milan liga italia serie a allianz stadium">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">🇮🇹
                                        Serie A</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">Pekan ke-32</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Senin, 01:45 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">⚪⚫</span>
                                        <span class="font-bold text-white text-base">Juventus</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.60</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🔴⚫</span>
                                        <span class="font-bold text-white text-base">AC Milan</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.55</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-amber-400 font-bold">Juve 41%</span>
                                        <span class="text-slate-400">Seri 31%</span>
                                        <span class="text-rose-400 font-bold">Milan 28%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-amber-400 h-full" style="width: 41%"
                                            title="Juventus Win: 41%"></div>
                                        <div class="bg-slate-500 h-full" style="width: 31%" title="Seri: 31%"></div>
                                        <div class="bg-rose-400 h-full" style="width: 28%" title="Milan Win: 28%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Duel ketat dengan dominasi
                                    pertarungan lini tengah. Rasio seri historis kedua tim mencapai 38% saat bertemu di
                                    Turin.
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Match 7: Bundesliga - Bayern Munich vs Borussia Dortmund -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between" data-category="bundesliga"
                        data-teams="bayern munchen munich borussia dortmund bundesliga jerman der klassiker">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-red-400 bg-red-500/10 px-2 py-0.5 rounded border border-red-500/20">🇩🇪
                                        Bundesliga</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">Der Klassiker</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Sabtu, 20:30 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🔴</span>
                                        <span class="font-bold text-white text-base">Bayern München</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        2.65</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🟡</span>
                                        <span class="font-bold text-white text-base">Borussia Dortmund</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.75</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-emerald-400 font-bold">Bayern 58%</span>
                                        <span class="text-slate-400">Seri 21%</span>
                                        <span class="text-amber-400 font-bold">Dortmund 21%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-emerald-400 h-full" style="width: 58%"
                                            title="Bayern Win: 58%"></div>
                                        <div class="bg-slate-500 h-full" style="width: 21%" title="Seri: 21%"></div>
                                        <div class="bg-amber-400 h-full" style="width: 21%"
                                            title="Dortmund Win: 21%"></div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Laga dengan tempo sangat tinggi.
                                    Total expected goals gabungan 4.40 xG memproyeksikan peluang Over 3.5 gol mencapai
                                    <strong>68%</strong>.
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Match 8: Bundesliga - Bayer Leverkusen vs RB Leipzig -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between" data-category="bundesliga"
                        data-teams="bayer leverkusen rb leipzig bundesliga jerman top clash bayarena">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-red-400 bg-red-500/10 px-2 py-0.5 rounded border border-red-500/20">🇩🇪
                                        Bundesliga</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">Pekan ke-29</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Sabtu, 20:30 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🦁</span>
                                        <span class="font-bold text-white text-base">Bayer Leverkusen</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        2.10</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">⚪🔴</span>
                                        <span class="font-bold text-white text-base">RB Leipzig</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.65</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-emerald-400 font-bold">Leverkusen 50%</span>
                                        <span class="text-slate-400">Seri 26%</span>
                                        <span class="text-cyan-400 font-bold">Leipzig 24%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-emerald-400 h-full" style="width: 50%"
                                            title="Leverkusen Win: 50%"></div>
                                        <div class="bg-slate-500 h-full" style="width: 26%" title="Seri: 26%"></div>
                                        <div class="bg-cyan-400 h-full" style="width: 24%" title="Leipzig Win: 24%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Alur distribusi bola Leverkusen
                                    di BayArena mencatatkan rata-rata possession 63.8%. Peluang Leverkusen mencetak gol
                                    pertama: 61%.
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Match 9: Champions League - Manchester City vs Real Madrid -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between"
                        data-category="champions-league"
                        data-teams="manchester city real madrid uefa champions league eropa semifinal ucl">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20">⭐
                                        Champions League</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">Semifinal Leg 1</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Rabu, 02:00 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🔵</span>
                                        <span class="font-bold text-white text-base">Manchester City</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        2.05</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">👑</span>
                                        <span class="font-bold text-white text-base">Real Madrid</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.80</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-sky-400 font-bold">City 42%</span>
                                        <span class="text-slate-400">Seri 27%</span>
                                        <span class="text-amber-400 font-bold">Madrid 31%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-sky-400 h-full" style="width: 42%" title="Man City Win: 42%">
                                        </div>
                                        <div class="bg-slate-500 h-full" style="width: 27%" title="Seri: 27%"></div>
                                        <div class="bg-amber-400 h-full" style="width: 31%"
                                            title="Real Madrid Win: 31%"></div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Pertarungan papan atas Eropa.
                                    Man City dominan positional play, sementara counter-attack Madrid memiliki konversi
                                    xG 1.80. BTTS Yes: 76%.
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Match 10: Champions League - PSG vs Bayern Munich -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between"
                        data-category="champions-league"
                        data-teams="psg paris saint germain bayern munchen uefa champions league ucl perempat final">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20">⭐
                                        Champions League</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">Perempat Final</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Kamis, 02:00 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🔵🔴</span>
                                        <span class="font-bold text-white text-base">Paris Saint-Germain</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.80</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🔴</span>
                                        <span class="font-bold text-white text-base">Bayern München</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.95</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-blue-400 font-bold">PSG 37%</span>
                                        <span class="text-slate-400">Seri 26%</span>
                                        <span class="text-red-400 font-bold">Bayern 37%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-blue-400 h-full" style="width: 37%" title="PSG Win: 37%">
                                        </div>
                                        <div class="bg-slate-500 h-full" style="width: 26%" title="Seri: 26%"></div>
                                        <div class="bg-red-400 h-full" style="width: 37%" title="Bayern Win: 37%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Laga paling berimbang pekan ini
                                    dengan split peluang 37-26-37. Kecepatan wingers kedua kubu berpotensi memicu jumlah
                                    corner kick tinggi (>9.5 corner).
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Match 11: BRI Liga 1 - Persib vs Persija -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between" data-category="liga-1"
                        data-teams="persib bandung persija jakarta bri liga 1 indonesia el clasico indonesia gbla">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-teal-400 bg-teal-500/10 px-2 py-0.5 rounded border border-teal-500/20">🇮🇩
                                        BRI Liga 1</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">El Clásico Indonesia</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Sabtu, 15:30 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🐯</span>
                                        <span class="font-bold text-white text-base">Persib Bandung</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.88</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🐅</span>
                                        <span class="font-bold text-white text-base">Persija Jakarta</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.42</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-teal-400 font-bold">Persib 46%</span>
                                        <span class="text-slate-400">Seri 29%</span>
                                        <span class="text-amber-400 font-bold">Persija 25%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-teal-400 h-full" style="width: 46%" title="Persib Win: 46%">
                                        </div>
                                        <div class="bg-slate-500 h-full" style="width: 29%" title="Seri: 29%"></div>
                                        <div class="bg-amber-400 h-full" style="width: 25%" title="Persija Win: 25%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Atmosfer intensitas tinggi di
                                    Bandung memberikan keunggulan moral tuan rumah. Estimasi kartu kuning tinggi (>5.5
                                    kartu).
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Match 12: BRI Liga 1 - Persebaya vs Arema FC -->
                    <div class="match-card rounded-2xl p-6 flex flex-col justify-between" data-category="liga-1"
                        data-teams="persebaya surabaya arema fc derbi jawa timur bri liga 1 indonesia gbt">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-800/80 text-xs">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-bold text-teal-400 bg-teal-500/10 px-2 py-0.5 rounded border border-teal-500/20">🇮🇩
                                        BRI Liga 1</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400">Derbi Jawa Timur</span>
                                </div>
                                <div
                                    class="px-2.5 py-1 rounded-md bg-slate-900 border border-slate-800 font-mono font-semibold text-emerald-400">
                                    Minggu, 15:30 WIB
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="py-5 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🐊</span>
                                        <span class="font-bold text-white text-base">Persebaya Surabaya</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.75</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">🦁</span>
                                        <span class="font-bold text-white text-base">Arema FC</span>
                                    </div>
                                    <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-900 text-slate-300">xG:
                                        1.30</span>
                                </div>

                                <!-- Probability Bar -->
                                <div class="pt-3">
                                    <div class="flex justify-between text-xs font-mono mb-1.5">
                                        <span class="text-emerald-400 font-bold">Persebaya 48%</span>
                                        <span class="text-slate-400">Seri 28%</span>
                                        <span class="text-blue-400 font-bold">Arema 24%</span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-2.5 rounded-full flex overflow-hidden">
                                        <div class="bg-emerald-400 h-full" style="width: 48%"
                                            title="Persebaya Win: 48%"></div>
                                        <div class="bg-slate-500 h-full" style="width: 28%" title="Seri: 28%"></div>
                                        <div class="bg-blue-400 h-full" style="width: 24%" title="Arema Win: 24%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Insight Box -->
                                <div
                                    class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 leading-relaxed mt-4">
                                    💡 <strong class="text-white">AI Insight:</strong> Pressing garis tinggi di Gelora
                                    Bung Tomo memberi efektivitas 74% turnover bola di area lawan. Peluang Home Win 48%.
                                </div>
                            </div>
                        </div>

                        <!-- Mini CTA to Chatbot -->
                        <div class="pt-4 border-t border-slate-800/80">
                            <a href="http://localhost:8000" target="_blank" rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:text-slate-950 bg-emerald-500/10 hover:bg-emerald-400 border border-emerald-500/30 transition-all duration-200">
                                <span>Minta Rincian Taktis di Chatbot</span>
                                <span class="font-mono">→</span>
                            </a>
                        </div>
                    </div>

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
                        <!-- Fallback cards tetap tampil jika tidak ada highlight YouTube sama sekali -->
                        ... (Fallback Cards Anda) ...
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
                    <span>✓ Langsung Terhubung ke Port 8000</span>
                    <span>✓ Bebas Tanya Seputar Semua Liga</span>
                    <span>✓ Respon Cepat & Objektif</span>
                </div>

            </div>
        </section>

    </main>

    <!-- 6. FOOTER (MANDATORY FORMAT) -->
    <footer class="border-t border-[#285A48] bg-[#091413] py-8 text-center text-slate-400 text-sm">
        <div class="container mx-auto px-4">
            <p class="mb-1 text-slate-400 text-xs tracking-wider uppercase">Layanan Analitik & Prediksi Pertandingan
                Sepakbola</p>
            <p class="font-medium text-slate-300">Crafted with precision by <span
                    class="text-[#408A71] font-semibold">rafi pranata</span></p>
        </div>
    </footer>

    <!-- SCROLL TO TOP BUTTON -->
    <button id="scroll-to-top" aria-label="Scroll ke atas" title="Kembali ke atas"
        class="fixed bottom-6 right-6 z-40 p-3.5 rounded-xl bg-[#0e1f1e] text-white border border-[#285A48] hover:border-[#408A71] hover:bg-[#153229] hover:text-[#408A71] shadow-lg hover:shadow-[#408A71]/20 transition-all duration-300 opacity-0 pointer-events-none translate-y-4 flex items-center justify-center group focus:outline-none focus:ring-2 focus:ring-[#408A71]">
        <svg class="w-5 h-5 transition-transform duration-200 group-hover:-translate-y-0.5" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18">
            </path>
        </svg>
    </button>

    <!-- SCROLL TO TOP SCRIPT -->
    <script>
        (function() {
            const scrollBtn = document.getElementById('scroll-to-top');
            if (!scrollBtn) return;

            const toggleScrollBtn = () => {
                if (window.scrollY > 300) {
                    scrollBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
                    scrollBtn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
                } else {
                    scrollBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
                    scrollBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
                }
            };

            window.addEventListener('scroll', toggleScrollBtn, {
                passive: true
            });
            toggleScrollBtn();

            scrollBtn.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        })();
    </script>

    <!-- MOBILE MENU TOGGLE SCRIPT -->
    <script>
        const mobileToggle = document.getElementById('mobile-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconBars = document.getElementById('icon-bars');
        const iconClose = document.getElementById('icon-close');

        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', () => {
                const isHidden = mobileMenu.classList.contains('hidden');
                if (isHidden) {
                    mobileMenu.classList.remove('hidden');
                    iconBars.classList.add('hidden');
                    iconClose.classList.remove('hidden');
                } else {
                    mobileMenu.classList.add('hidden');
                    iconBars.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                }
            });

            document.querySelectorAll('.mobile-link').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    iconBars.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                });
            });
        }
    </script>

    <!-- NAVBAR ACTIVE LINK SCRIPT -->
    <script>
        (function() {
            const navLinks = document.querySelectorAll('.nav-link');

            function setActiveNav(targetHref) {
                navLinks.forEach(link => {
                    if (link.getAttribute('href') === targetHref) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const href = this.getAttribute('href');
                    if (href && href.startsWith('#')) {
                        setActiveNav(href);
                    }
                });
            });

            // Reset active link when brand logo is clicked
            const brandLogo = document.querySelector('header a[href="#"]');
            if (brandLogo) {
                brandLogo.addEventListener('click', () => {
                    setActiveNav(null);
                });
            }

            // Sync active link with URL hash
            window.addEventListener('hashchange', () => {
                if (window.location.hash) {
                    setActiveNav(window.location.hash);
                }
            });

            if (window.location.hash) {
                setActiveNav(window.location.hash);
            }
        })();
    </script>

    <!-- MATCH FILTERING & SEARCH SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const categoryBtns = document.querySelectorAll('.category-btn');
            const matchCards = document.querySelectorAll('#match-cards-container .match-card');
            const searchInput = document.getElementById('match-search');
            const searchClearBtn = document.getElementById('match-search-clear');
            const visibleCountElem = document.getElementById('visible-match-count');
            const activeCategoryTitle = document.getElementById('active-category-title');
            const noMatchesFound = document.getElementById('no-matches-found');
            const resetFilterBtn = document.getElementById('reset-filter-btn');

            let currentCategory = 'all';
            let currentQuery = '';

            const categoryLabels = {
                'all': 'Semua Laga',
                'premier-league': 'Premier League (Inggris)',
                'laliga': 'La Liga (Spanyol)',
                'serie-a': 'Serie A (Italia)',
                'bundesliga': 'Bundesliga (Jerman)',
                'champions-league': 'UEFA Champions League',
                'liga-1': 'BRI Liga 1 (Indonesia)'
            };

            function filterMatches() {
                let visibleCount = 0;

                matchCards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category');
                    const cardTeams = (card.getAttribute('data-teams') || '').toLowerCase();
                    const cardText = card.textContent.toLowerCase();

                    const matchesCategory = (currentCategory === 'all' || cardCategory === currentCategory);
                    const matchesSearch = (!currentQuery || cardTeams.includes(currentQuery) || cardText
                        .includes(currentQuery));

                    if (matchesCategory && matchesSearch) {
                        card.classList.remove('hidden');
                        card.classList.add('flex', 'animate-fade-in');
                        visibleCount++;
                    } else {
                        card.classList.add('hidden');
                        card.classList.remove('flex', 'animate-fade-in');
                    }
                });

                // Update counts and status label
                if (visibleCountElem) {
                    visibleCountElem.textContent = visibleCount;
                }
                if (activeCategoryTitle) {
                    activeCategoryTitle.textContent = categoryLabels[currentCategory] || currentCategory;
                }

                // Show/hide empty state
                if (noMatchesFound) {
                    if (visibleCount === 0) {
                        noMatchesFound.classList.remove('hidden');
                    } else {
                        noMatchesFound.classList.add('hidden');
                    }
                }
            }

            // Handle Category Buttons
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const cat = btn.getAttribute('data-category');
                    currentCategory = cat;

                    // Update active styles
                    categoryBtns.forEach(b => {
                        b.classList.remove(
                            'active',
                            'bg-[#408A71]',
                            'border-[#408A71]',
                            'text-white'
                        );
                        b.classList.add('border-[#285A48]', 'bg-[#0e1f1e]',
                            'text-slate-300');

                        const badge = b.querySelector('.category-badge');
                        if (badge) {
                            badge.classList.remove('bg-[#285A48]', 'text-white');
                            badge.classList.add('bg-[#091413]', 'text-slate-400');
                        }
                    });

                    btn.classList.add(
                        'active',
                        'bg-[#408A71]',
                        'border-[#408A71]',
                        'text-white'
                    );
                    btn.classList.remove('border-[#285A48]', 'bg-[#0e1f1e]', 'text-slate-300');

                    const activeBadge = btn.querySelector('.category-badge');
                    if (activeBadge) {
                        activeBadge.classList.remove('bg-[#091413]', 'text-slate-400');
                        activeBadge.classList.add('bg-[#285A48]', 'text-white');
                    }

                    filterMatches();
                });
            });

            // Handle Search Input
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    currentQuery = e.target.value.trim().toLowerCase();
                    if (searchClearBtn) {
                        if (currentQuery.length > 0) {
                            searchClearBtn.classList.remove('hidden');
                        } else {
                            searchClearBtn.classList.add('hidden');
                        }
                    }
                    filterMatches();
                });
            }

            // Handle Clear Button
            if (searchClearBtn && searchInput) {
                searchClearBtn.addEventListener('click', () => {
                    searchInput.value = '';
                    currentQuery = '';
                    searchClearBtn.classList.add('hidden');
                    filterMatches();
                    searchInput.focus();
                });
            }

            // Handle Reset from Empty State
            if (resetFilterBtn) {
                resetFilterBtn.addEventListener('click', () => {
                    currentCategory = 'all';
                    currentQuery = '';
                    if (searchInput) {
                        searchInput.value = '';
                    }
                    if (searchClearBtn) {
                        searchClearBtn.classList.add('hidden');
                    }

                    const allBtn = document.querySelector('.category-btn[data-category="all"]');
                    if (allBtn) {
                        allBtn.click();
                    } else {
                        filterMatches();
                    }
                });
            }
        });
    </script>

</body>

</html>
