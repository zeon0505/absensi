<div class="space-y-8 animate-in fade-in duration-500">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-5">
            <div class="w-14 h-14 bg-indigo-600 text-white rounded-[1.25rem] flex items-center justify-center shadow-lg shadow-indigo-200 dark:shadow-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <div>
                <h2 class="text-[24px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight leading-none">Pengajuan Izin / Cuti</h2>
                <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-2 font-medium">Lengkapi formulir di bawah untuk mengajukan ketidakhadiran.</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-10 border border-slate-100 dark:border-slate-800 shadow-sm transition-colors overflow-hidden">
        <form wire:submit.prevent="submit" class="space-y-8 max-w-3xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Tipe Izin -->
                <div class="space-y-3">
                    <label class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Jenis Pengajuan</label>
                    <div class="relative group">
                        <select wire:model="type" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border-2 border-transparent focus:border-indigo-500/20 rounded-2xl px-5 py-4 text-[15px] font-medium outline-none appearance-none cursor-pointer transition-all">
                            <option value="izin">Izin</option>
                            <option value="cuti">Cuti</option>
                            <option value="sakit">Sakit</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Kosong untuk balancing -->
                <div class="hidden md:block"></div>

                <!-- Tanggal Mulai -->
                <div class="space-y-3">
                    <label class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Mulai Tanggal</label>
                    <input wire:model="start_date" type="date" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border-2 border-transparent focus:border-indigo-500/20 rounded-2xl px-5 py-4 text-[15px] font-medium outline-none transition-all">
                </div>

                <!-- Tanggal Selesai -->
                <div class="space-y-3">
                    <label class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Sampai Tanggal</label>
                    <input wire:model="end_date" type="date" class="w-full bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border-2 border-transparent focus:border-indigo-500/20 rounded-2xl px-5 py-4 text-[15px] font-medium outline-none transition-all">
                </div>
            </div>

            <!-- Alasan -->
            <div class="space-y-3">
                <label class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Alasan / Keterangan</label>
                <textarea wire:model="reason" rows="4" placeholder="Berikan alasan yang jelas mengenai pengajuan Anda..." class="w-full bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border-2 border-transparent focus:border-indigo-500/20 rounded-2xl px-5 py-4 text-[15px] font-medium outline-none transition-all resize-none"></textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-5 rounded-2xl shadow-lg shadow-indigo-100 dark:shadow-none hover:bg-indigo-700 transition-all uppercase tracking-widest text-[13px]">
                    Kirim Pengajuan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
