<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in duration-500">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center space-x-5">
            <div class="w-14 h-14 bg-indigo-600 text-white rounded-[1.25rem] flex items-center justify-center shadow-lg shadow-indigo-100 dark:shadow-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <h2 class="text-[24px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight leading-none">Presensi Lokasi</h2>
                <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-2 font-medium">Lakukan absensi menggunakan koordinat GPS Anda.</p>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-10 border border-slate-100 dark:border-slate-800 shadow-sm transition-colors text-center">
        <div class="max-w-sm mx-auto space-y-8">
            <div class="w-24 h-24 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-[2.5rem] flex items-center justify-center mx-auto shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            
            <div class="space-y-4">
                <h3 class="text-[20px] font-semibold text-slate-800 dark:text-slate-100">Pilih Ruang Tugas</h3>
                <p class="text-[14px] text-slate-500 dark:text-slate-500 font-medium">Klik pada kelas yang ingin Anda laporkan kehadirannya hari ini.</p>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @if(isset($classrooms))
                    @forelse($classrooms as $class)
                    <button wire:click="selectClass({{ $class->id }})" class="w-full flex items-center justify-between p-5 bg-slate-50 dark:bg-slate-800 rounded-2xl border-2 border-transparent hover:border-indigo-500/30 hover:bg-white dark:hover:bg-slate-750 transition-all group overflow-hidden relative">
                        <div class="flex items-center space-x-4 relative z-10">
                            <div class="w-10 h-10 bg-white dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center font-bold text-sm shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                {{ strtoupper(substr($class->name, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-slate-700 dark:text-slate-200 text-[15px] group-hover:translate-x-1 transition-transform">{{ $class->name }}</span>
                        </div>
                        <svg class="w-5 h-5 text-slate-300 dark:text-slate-600 group-hover:text-indigo-500 transition-colors relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    @empty
                        <div class="py-10 text-center">
                            <p class="text-slate-400 text-[14px] font-medium italic">Anda belum terdaftar di kelas manapun.</p>
                            <a href="{{ route('dashboard') }}" wire:navigate class="text-indigo-600 dark:text-indigo-400 text-[12px] font-bold uppercase tracking-widest mt-4 inline-block hover:underline">Gabung Kelas Sekarang</a>
                        </div>
                    @endforelse
                @endif
            </div>
        </div>
    </div>
</div>
