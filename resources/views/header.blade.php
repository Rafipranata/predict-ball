@section('header')
    <header class="sticky top-0 z-50 w-full bg-[#091413] border-b border-[#285A48] relative overflow-hidden">
        <!-- Floating Soccer Balls & Orbs Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0 select-none" aria-hidden="true">
            <!-- Floating Ball 1 -->
            <div class="absolute -top-1 left-[3%] floating-ball-1 opacity-25">
                <svg class="w-10 h-10 text-[#408A71]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.2">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.2" />
                    <polygon points="12 7, 8.5 9.5, 9.8 13.5, 14.2 13.5, 15.5 9.5" fill="currentColor" fill-opacity="0.35"
                        stroke="currentColor" stroke-width="1" />
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
                    <polygon points="12 7, 8.5 9.5, 9.8 13.5, 14.2 13.5, 15.5 9.5" fill="currentColor" fill-opacity="0.35"
                        stroke="currentColor" stroke-width="1" />
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
                    <polygon points="12 7, 8.5 9.5, 9.8 13.5, 14.2 13.5, 15.5 9.5" fill="currentColor" fill-opacity="0.35"
                        stroke="currentColor" stroke-width="1" />
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

        @include('navbar')
        @yield('navbar')
        </div>

        <!-- Mobile Drawer (Matte Solid) -->
        <div id="mobile-menu"
            class="hidden md:hidden border-b border-[#285A48] bg-[#091413] px-4 pt-3 pb-6 space-y-3 relative z-10">
            <a href="#jadwal" class="nav-link mobile-link block px-2 py-2 text-sm">Hasil & Jadwal Laga</a>
            <a href="#highlights" class="nav-link mobile-link block px-2 py-2 text-sm">Highlights</a>
            <a href="#prediksi" class="nav-link mobile-link block px-2 py-2 text-sm">Prediksi AI</a>
            <a href="#akurasi" class="nav-link mobile-link block px-2 py-2 text-sm">Akurasi Data</a>

        </div>
    </header>
@endsection
