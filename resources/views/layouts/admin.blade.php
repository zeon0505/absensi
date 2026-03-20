<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Jalupab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Immediate dark mode application to prevent flash
        if (localStorage.getItem('dark_mode') === 'true') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .sidebar-active { 
            background-color: #f1f5f9;
            color: #4f46e5 !important;
            border-right: 3px solid #4f46e5;
        }
        .dark .sidebar-active {
            background-color: #1e293b;
            color: #818cf8 !important;
            border-right: 3px solid #818cf8;
        }
        .sidebar-active svg { color: #4f46e5 !important; }
        .dark .sidebar-active svg { color: #818cf8 !important; }
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
    </style>
    @livewireStyles
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-700 dark:text-slate-300 font-sans antialiased overflow-hidden" 
      x-data="{ 
        darkMode: localStorage.getItem('dark_mode') === 'true',
        sidebarOpen: localStorage.getItem('sidebar_open') === 'true',
        showLogoutModal: false,
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('dark_mode', this.darkMode);
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        },
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
            localStorage.setItem('sidebar_open', this.sidebarOpen);
        },
        refreshTheme() {
            if (localStorage.getItem('dark_mode') === 'true') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
      }"
      x-init="
        if(localStorage.getItem('sidebar_open') === null) { sidebarOpen = true; localStorage.setItem('sidebar_open', true); }
        $watch('darkMode', val => refreshTheme());
      "
>
    <!-- Dark Mode Syncing with Livewire Navigated -->
    <script>
        function applyPersistentTheme() {
            const isDark = localStorage.getItem('dark_mode') === 'true';
            document.documentElement.classList.toggle('dark', isDark);
        }

        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updating', ({ el, toEl }) => {
                if (el.tagName === 'HTML') {
                    const isDark = localStorage.getItem('dark_mode') === 'true';
                    if (isDark) toEl.classList.add('dark');
                    else toEl.classList.remove('dark');
                }
            });
        });

        document.addEventListener('livewire:navigated', applyPersistentTheme);
        // Execute immediately on script load just in case
        applyPersistentTheme();
    </script>

    @php /** @var string $slot */ @endphp
    
    <div class="flex h-screen w-full bg-slate-50 dark:bg-slate-950">
        <!-- Sidebar Navigation -->
        <aside 
            :class="sidebarOpen ? 'w-64' : 'w-20'" 
            class="bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 flex flex-col transition-all duration-300 ease-in-out relative z-40 shrink-0 shadow-sm"
        >
            <!-- Logo Section -->
            <div class="h-24 flex items-center px-6 border-b border-slate-100 dark:border-slate-800 overflow-hidden shrink-0">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div x-show="sidebarOpen" x-transition.opacity class="ml-4 whitespace-nowrap">
                    <span class="text-[19px] font-semibold tracking-tight text-slate-900 dark:text-white">JALUPAB</span>
                    <p class="text-[10px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-0.5">Control Center</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-grow py-8 px-4 flex flex-col space-y-1.5 overflow-y-auto custom-scrollbar">
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        ['route' => 'admin.users', 'label' => 'Pengguna', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        ['route' => 'admin.classrooms', 'label' => 'Ruang Kelas', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                        ['route' => 'admin.leaves', 'label' => 'Konfirmasi Cuti', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['route' => 'admin.reports', 'label' => 'Laporan Absen', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['route' => 'admin.qr.generate', 'label' => 'Generate QR', 'icon' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01m-4-7h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a 
                        href="{{ route($item['route']) }}" 
                        wire:navigate
                        class="flex items-center px-5 py-4 rounded-2xl duration-200 group {{ request()->routeIs($item['route']) ? 'sidebar-active shadow-sm' : 'hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border-r-4 border-transparent' }}"
                    >
                        <div class="flex items-center justify-center w-7 shrink-0">
                            <svg class="w-6 h-6 {{ request()->routeIs($item['route']) ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                            </svg>
                        </div>
                        <span x-show="sidebarOpen" x-transition.opacity class="ml-4 text-[14px] font-medium tracking-tight whitespace-nowrap">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <!-- Bottom Toggle & Dark Mode Switch -->
            <div class="p-5 border-t border-slate-100 dark:border-slate-800 space-y-3">
                <button 
                    @click="toggleDarkMode()" 
                    class="w-full h-12 flex items-center justify-center rounded-2xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all border border-slate-200 dark:border-slate-700 shadow-sm"
                >
                    <svg x-show="!darkMode" class="w-5 h-5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg x-show="darkMode" class="w-5 h-5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>
                <button 
                    @click="toggleSidebar()" 
                    class="w-full h-12 flex items-center justify-center rounded-2xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-all border border-slate-200 dark:border-slate-700 shadow-sm"
                >
                    <svg :class="!sidebarOpen ? 'rotate-180' : ''" class="w-5 h-5 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col h-screen overflow-hidden bg-slate-50 dark:bg-slate-950 relative">
            <header class="h-20 bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800 px-10 flex justify-between items-center shrink-0 z-40">
                <div class="flex items-center space-x-4">
                    <button @click="toggleSidebar()" class="p-2.5 bg-slate-50 dark:bg-slate-900 rounded-xl lg:hidden transition-colors"><svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg></button>
                    <div>
                        <h1 class="text-[17px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight capitalize leading-none">{{ str_replace(['admin.', '.'], [' ', ' '], request()->route()->getName()) }}</h1>
                    </div>
                </div>

                <!-- Real-time Clock -->
                <div class="hidden xl:flex flex-col items-end px-8 border-r border-slate-100 dark:border-slate-800">
                    <div id="real-time-clock" class="text-[20px] font-bold text-slate-900 dark:text-white leading-none tracking-tight">00:00:00</div>
                    <div id="real-time-date" class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-2">Memuat...</div>
                </div>

                <!-- User Dropdown -->
                <div x-data="{ open: false }" class="relative pl-8">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-4 pr-4 transition-all group focus:outline-none">
                        <img src="{{ auth()->user()->profile_photo_url }}" class="w-10 h-10 rounded-xl object-cover shadow-md border border-slate-200 dark:border-slate-700 group-hover:scale-105 transition-transform" alt="Avatar">
                        <div class="text-left hidden lg:block">
                            <p class="text-[14px] font-medium text-slate-900 dark:text-slate-100 leading-none">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-emerald-500 font-semibold uppercase tracking-widest mt-1.5 flex items-center">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></span>Online
                            </p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div 
                        x-show="open" 
                        x-cloak 
                        x-transition:enter="transition duration-150 ease-out"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                        class="absolute right-0 mt-4 w-52 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 p-2 z-[100] ring-1 ring-slate-200/50 dark:ring-slate-700/50"
                    >
                        <a href="{{ route('profile') }}" wire:navigate class="flex items-center space-x-3 px-4 py-3 text-[14px] text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-colors font-medium">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Profil Saya</span>
                        </a>
                        <div class="border-t border-slate-50 dark:border-slate-800 my-2"></div>
                        <button @click="showLogoutModal = true" class="w-full flex items-center space-x-3 px-4 py-3 text-[14px] text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-colors font-medium text-left">
                            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Keluar Sistem</span>
                        </button>
                    </div>
                </div>
            </header>

            <div class="flex-grow overflow-y-auto p-10 relative custom-scrollbar bg-slate-50/10 dark:bg-slate-950/20">
                <div class="max-w-7xl mx-auto pb-10">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <!-- Logout Modal -->
        <div x-show="showLogoutModal" x-cloak style="display:none" class="fixed inset-0 z-[1000] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm transition-opacity">
            <div @click.away="showLogoutModal = false" class="bg-white dark:bg-slate-900 rounded-3xl p-10 max-w-sm w-full shadow-2xl relative text-center">
                <div class="w-16 h-16 bg-rose-50 dark:bg-rose-900/20 text-rose-500 rounded-2xl flex items-center justify-center mx-auto mb-6"><svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg></div>
                <h3 class="text-[18px] font-semibold text-slate-800 dark:text-slate-100 mb-2">Konfirmasi Keluar?</h3>
                <p class="text-slate-400 dark:text-slate-500 text-[14px] mb-8 leading-relaxed">Sesi portal administrasi Anda akan segera diakhiri secara aman.</p>
                <div class="flex space-x-4">
                    <button @click="showLogoutModal = false" class="flex-1 py-3 text-[14px] bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-medium rounded-xl transition-colors">Batal</button>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">@csrf<button type="submit" class="w-full py-3 text-[13px] bg-rose-600 text-white font-bold rounded-xl shadow-md hover:bg-rose-700 transition-colors uppercase tracking-widest">Ya, Keluar</button></form>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
    <script>
        function updateClock() {
            const now = new Date();
            const clockEl = document.getElementById('real-time-clock');
            const dateEl = document.getElementById('real-time-date');
            
            if (clockEl) {
                clockEl.innerText = now.toLocaleTimeString('id-ID', { hour12: false });
            }
            if (dateEl) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                dateEl.innerText = now.toLocaleDateString('id-ID', options);
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
        document.addEventListener('livewire:navigated', updateClock);
    </script>
</body>
</html>
