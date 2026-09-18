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
    @include('header')
    @yield('header')

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
                    <span>Scroll untuk Hasil & Jadwal Laga</span>
                    <svg class="w-4 h-4 animate-bounce text-[#408A71]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>
        </section>

        <!-- 3. DEDICATED SECTION: JADWAL PERTANDINGAN & PREDIKSI HARIAN -->
        @include('jadwal')
        @yield('jadwal')

        <!-- 3.5, 4, 5. SECTION HIGHLIGHTS, PREDIKSI, & CTA (MODULAR SECTION) -->
        @include('highlight')
        @yield('highlight')

    </main>

    <!-- 6. FOOTER (MANDATORY FORMAT) -->
    @include('footer')
    @yield('footer')


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
                'serie-a': 'Serie A (Italia)',
                'bundesliga': 'Bundesliga (Jerman)',
                'ligue-1': 'Ligue 1 (Prancis)',
                'eredivisie': 'Eredivisie (Belanda)',
                'champions-league': 'UEFA Champions League',
                'laliga': 'La Liga (Spanyol)',
                'copa-libertadores': 'Copa Libertadores',
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
                    const activeBtn = document.querySelector(`.category-btn[data-category="${currentCategory}"]`);
                    const btnSpan = activeBtn ? (activeBtn.querySelector('.category-name') || activeBtn.querySelector('span')) : null;
                    activeCategoryTitle.textContent = btnSpan ? btnSpan.textContent.trim() : (categoryLabels[currentCategory] || currentCategory);
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
