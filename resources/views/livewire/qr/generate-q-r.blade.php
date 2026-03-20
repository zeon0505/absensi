<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in duration-500">
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors">
        <!-- Header Section -->
        <div class="p-8 border-b border-slate-100 dark:border-slate-800 bg-gradient-to-r from-violet-600 to-indigo-600 dark:from-violet-900 dark:to-indigo-900 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div class="flex items-center space-x-5">
                <div class="w-14 h-14 bg-white/20 text-white rounded-[1.25rem] flex items-center justify-center backdrop-blur-md shadow-inner">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01m-4-7h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
                <div>
                    <h2 class="text-[24px] font-semibold text-white tracking-tight">QR Absensi Digital</h2>
                    <p class="text-indigo-100/80 text-[14px] font-medium">Buka akses absensi untuk kelas yang Anda kelola.</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                <div class="relative min-w-[200px]">
                    <select wire:model.live="selectedClassId" class="w-full bg-white/10 border border-white/20 rounded-xl px-5 py-3 text-[14px] font-semibold text-white focus:ring-2 focus:ring-white/30 outline-none transition-all appearance-none cursor-pointer">
                        @forelse($classrooms as $cls)
                            <option value="{{ $cls->id }}" class="text-slate-800">{{ $cls->name }}</option>
                        @empty
                            <option value="" class="text-slate-800">Tidak ada kelas dikelola</option>
                        @endforelse
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-white/60">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <button wire:click="generateNewQr" wire:loading.attr="disabled" class="bg-white text-indigo-700 hover:bg-slate-50 font-bold py-3.5 px-8 rounded-xl shadow-lg active:scale-95 transition-all flex items-center justify-center shrink-0 text-[12px] uppercase tracking-wider">
                    <svg wire:loading.remove wire:target="generateNewQr" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <svg wire:loading wire:target="generateNewQr" class="w-4 h-4 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span wire:loading.remove wire:target="generateNewQr">Generate QR</span>
                    <span wire:loading wire:target="generateNewQr">Memproses...</span>
                </button>
            </div>
        </div>

        <div class="p-10 flex flex-col items-center min-h-[520px] justify-center relative bg-slate-50/10 dark:bg-slate-950/20">
            @if (session()->has('message'))
                <div class="absolute top-6 w-full max-w-lg left-1/2 -translate-x-1/2 px-6 py-4 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-2xl border border-emerald-100 dark:border-emerald-800 shadow-sm flex items-center justify-center animate-in slide-in-from-top duration-300">
                    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-semibold text-[14px]">{{ session('message') }}</span>
                </div>
            @endif

            @if($qrCode && $qrSvg)
                <div class="mt-8 mb-10 p-10 bg-white dark:bg-slate-800 rounded-[3rem] shadow-2xl shadow-indigo-100 dark:shadow-none border border-slate-100 dark:border-slate-700 flex items-center justify-center flex-col shrink-0 group transition-all">
                    <div class="w-64 h-64 sm:w-80 sm:h-80 transition-transform group-hover:scale-110 duration-500">
                        <!-- Standard White background for QR visibility -->
                        <div class="bg-white p-4 rounded-3xl shadow-inner">
                            {!! $qrSvg !!}
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-100/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-[2.5rem] p-8 text-center max-w-md w-full relative overflow-hidden group">
                    <div class="relative z-10 flex justify-between items-center mb-5">
                        <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">KODE TOKEN AKTIF</span>
                        <div class="bg-emerald-100/30 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 px-3 py-1 rounded-lg text-[10px] font-bold tracking-widest uppercase flex items-center border border-emerald-100 dark:border-emerald-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                            Verified
                        </div>
                    </div>
                    <p class="font-mono text-2xl lg:text-3xl text-indigo-600 dark:text-indigo-400 font-bold mb-6 tracking-wider break-all relative z-10">{{ $qrCode }}</p>
                    
                    <div class="grid grid-cols-2 gap-4 relative z-10">
                        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm text-left">
                            <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Dibuat</p>
                            <p class="text-[13px] font-semibold text-slate-700 dark:text-slate-300">{{ $qrCreatedAt }}</p>
                        </div>
                        <div class="bg-rose-50 dark:bg-rose-900/10 p-4 rounded-2xl border border-rose-100 dark:border-rose-900/40 shadow-sm text-left">
                            <p class="text-[10px] font-bold text-rose-400 uppercase mb-1">Expired</p>
                            <p class="text-[13px] font-bold text-rose-600 dark:text-rose-400">{{ $qrExpiredAt }}</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center text-center max-w-sm animate-in zoom-in duration-500">
                    <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 text-slate-300 dark:text-slate-700 rounded-[2rem] flex items-center justify-center mb-8 rotate-12 transition-transform hover:rotate-0">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01m-4-7h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h3 class="text-[20px] font-semibold text-slate-800 dark:text-slate-100 mb-3 tracking-tight">Menunggu Token Baru</h3>
                    <p class="text-slate-400 dark:text-slate-500 text-[14px] leading-relaxed font-medium">Klik tombol di atas untuk sinkronisasi generator QR Absensi hari ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
