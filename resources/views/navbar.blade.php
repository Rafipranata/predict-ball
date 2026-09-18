@section('navbar')
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
                        <span>Hasil & Jadwal</span>
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
@endsection