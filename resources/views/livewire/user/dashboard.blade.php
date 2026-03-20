<div class="space-y-8 animate-in fade-in duration-500">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-[26px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight">Halo, {{ auth()->user()->name }}!</h2>
            <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-1">Status kependudukan dan aktivitas akademik Anda hari ini.</p>
        </div>
        <div class="flex items-center space-x-4 bg-white dark:bg-slate-900 px-5 py-3 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
            <div class="w-11 h-11 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center font-semibold text-xl">
                {{ date('d') }}
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none">{{ date('l') }}</p>
                <p class="text-[15px] font-medium text-slate-700 dark:text-slate-200 mt-1.5">{{ date('F Y') }}</p>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 px-6 py-4 rounded-2xl text-[14px] font-medium flex items-center space-x-4 shadow-sm animate-in slide-in-from-top-4">
            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-100 dark:border-rose-800 text-rose-600 dark:text-rose-400 px-6 py-4 rounded-2xl text-[14px] font-medium flex items-center space-x-4 shadow-sm">
            <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm transition-colors">
            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Total Hadir</p>
            <h3 class="text-3xl font-semibold text-slate-800 dark:text-slate-100">{{ $stats['presence_count'] }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm transition-colors">
            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Terlambat</p>
            <h3 class="text-3xl font-semibold text-amber-500">{{ $stats['late_count'] }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm transition-colors">
            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Izin Disetujui</p>
            <h3 class="text-3xl font-semibold text-emerald-500">{{ $stats['leave_count'] }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm transition-colors">
            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Menunggu Izin</p>
            <h3 class="text-3xl font-semibold text-rose-500">{{ $stats['pending_leave'] }}</h3>
        </div>
    </div>

    <!-- User Action Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Classroom/Enrollment -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col transition-colors">
                <div class="p-8 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20">
                    <h3 class="text-[14px] font-semibold text-slate-800 dark:text-slate-100 uppercase tracking-widest">Enrollment Kelas</h3>
                </div>
                
                <div class="p-8 space-y-7">
                    <!-- Join Class Form -->
                    <form wire:submit.prevent="joinClass" class="space-y-3">
                        <label class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Gunakan Enrollment Code</label>
                        <div class="flex gap-2">
                            <input wire:model="joinCode" type="text" placeholder="Masukkan Kode..." class="flex-1 bg-slate-50 dark:bg-slate-800 border-2 border-transparent focus:border-indigo-500/20 rounded-xl px-5 py-3 text-[14px] font-mono font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-[0.2em] outline-none transition-all">
                            <button type="submit" class="bg-indigo-600 text-white p-3 rounded-xl hover:bg-indigo-700 transition-all shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </form>

                    <!-- My Classes List -->
                    <div class="space-y-4">
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Status Kelas Saya</p>
                        <div class="space-y-3 max-h-[300px] overflow-y-auto custom-scrollbar">
                            @forelse($myClassrooms as $class)
                                <div class="p-4 bg-slate-50/50 dark:bg-slate-800/50 rounded-2xl border border-transparent hover:border-indigo-100 dark:hover:border-indigo-900/40 transition-all group">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3 min-w-0">
                                            <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xs uppercase group-hover:bg-indigo-600 group-hover:text-white transition-colors">{{ substr($class->name, 0, 1) }}</div>
                                            <div class="flex flex-col min-w-0">
                                                <span class="text-[14px] font-semibold text-slate-700 dark:text-slate-200 truncate pr-2">{{ $class->name }}</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Pengelola: {{ $class->admin->name ?? 'System' }}</span>
                                            </div>
                                        </div>
                                        @php
                                            $cStatus = $class->pivot->status;
                                            $sStyle = [
                                                'approved' => 'bg-emerald-500 text-white',
                                                'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400',
                                                'rejected' => 'bg-rose-100 text-rose-700',
                                            ][$cStatus] ?? 'bg-slate-100 text-slate-400';
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase tracking-widest {{ $sStyle }}">
                                            {{ $cStatus }}
                                        </span>
                                    </div>
                                    @if($cStatus == 'approved')
                                        <button wire:click="openSubmitModal({{ $class->id }})" class="w-full mt-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all">Kirim Tugas Kelas</button>
                                    @endif
                                </div>
                            @empty
                                <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-8 text-center border-2 border-dashed border-slate-100 dark:border-slate-800">
                                    <p class="text-[13px] text-slate-400 font-medium italic">Anda belum terdaftar di kelas manapun.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submission History & Attendance -->
        <div class="lg:col-span-2 space-y-8">
             <!-- Submission Card -->
             <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden transition-colors">
                <div class="p-8 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex justify-between items-center">
                    <h3 class="text-[14px] font-semibold text-slate-800 dark:text-slate-100 uppercase tracking-widest">Tugas & Pengiriman</h3>
                </div>
                <div class="p-0 overflow-x-auto min-h-[250px]">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/20 dark:bg-slate-800/10 text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                            <tr>
                                <th class="px-8 py-4">Judul Tugas</th>
                                <th class="px-8 py-4">Kelas</th>
                                <th class="px-8 py-4 text-right pr-12">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/50 dark:divide-slate-800/50">
                            @forelse($myTasks ?? [] as $task)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/20 transition-all">
                                    <td class="px-8 py-5">
                                        <div class="flex flex-col">
                                            <span class="text-[14px] font-semibold text-slate-700 dark:text-slate-200">{{ $task->title }}</span>
                                            <span class="text-[10px] text-slate-400 font-medium uppercase mt-1">{{ date('d M Y, H:i', strtotime($task->created_at)) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-[13px] text-slate-500 font-medium">{{ $task->classroom->name }}</td>
                                    <td class="px-8 py-5 text-right pr-12">
                                        <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-lg text-[10px] font-bold uppercase tracking-widest">{{ $task->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="p-12 text-center text-slate-400 text-[13px] italic">Belum ada tugas yang dikirim.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
             </div>

             <!-- Attendance History Card -->
             <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden transition-colors">
                <div class="p-8 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex justify-between items-center">
                    <h3 class="text-[14px] font-semibold text-slate-800 dark:text-slate-100 uppercase tracking-widest">Absensi Terakhir</h3>
                    <a href="{{ route('attendance.history') }}" wire:navigate class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider hover:underline">Lihat Detail</a>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-100/50 dark:divide-slate-800/50">
                            @forelse($recentHistory as $log)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">
                                <td class="px-8 py-5 border-l-4 {{ $log->status == 'hadir' ? 'border-emerald-500' : 'border-amber-500' }}">
                                    <span class="text-[14px] font-semibold text-slate-700 dark:text-slate-200 tracking-tight">{{ date('d M Y', strtotime($log->date)) }}</span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="text-[14px] font-mono font-bold text-slate-600 dark:text-slate-300">{{ date('H:i', strtotime($log->check_in)) }}</span>
                                </td>
                                <td class="px-8 py-5 text-right pr-12">
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-slate-200 dark:border-slate-800 text-slate-400">{{ $log->status }}</span>
                                </td>
                            </tr>
                            @empty
                                <tr><td colspan="3" class="p-12 text-center text-slate-400 text-[13px] italic">Riwayat kosong.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
             </div>
        </div>
    </div>

    <!-- Submit Task Modal -->
    @if($showSubmitModal)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/60 dark:bg-slate-950/90 backdrop-blur-sm animate-in fade-in duration-300">
        <div wire:click="$set('showSubmitModal', false)" class="absolute inset-0"></div>
        
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] w-full max-w-lg relative z-[110] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden animate-in zoom-in-95 duration-200">
            <div class="px-10 py-8 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-[20px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight leading-none">Kirim Tugas</h3>
                    <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-2">Upload berkas tugas Anda</p>
                </div>
                <button wire:click="$set('showSubmitModal', false)" class="p-2 text-slate-400 hover:text-rose-500 transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <form wire:submit.prevent="submitTask" class="p-10 space-y-6">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Judul Tugas</label>
                    <input wire:model="taskTitle" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl px-5 py-4 text-[15px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 transition-all font-medium text-slate-700 dark:text-slate-200" placeholder="e.g. Laporan Mingguan">
                    @error('taskTitle') <span class="text-rose-500 text-[11px] font-semibold mt-1 block ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Keterangan (Opsional)</label>
                    <textarea wire:model="taskDescription" rows="3" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl px-5 py-4 text-[15px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 transition-all resize-none font-medium text-slate-700 dark:text-slate-200" placeholder="Tambahkan catatan jika ada..."></textarea>
                </div>

                <div class="space-y-3">
                    <label class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Unggah Berkas</label>
                    <div class="relative group">
                        <input type="file" wire:model="taskFile" class="hidden" id="taskFile">
                        <label for="taskFile" class="flex flex-col items-center justify-center w-full h-32 bg-slate-50 dark:bg-slate-800 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-750 transition-all">
                            <svg class="w-8 h-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <span class="text-[13px] font-medium text-slate-500 dark:text-slate-400">Klik untuk memilih file</span>
                            @if($taskFile) <p class="text-[11px] text-indigo-500 font-bold mt-2">{{ $taskFile->getClientOriginalName() }}</p> @endif
                        </label>
                    </div>
                    @error('taskFile') <span class="text-rose-500 text-[11px] font-semibold mt-1 block ml-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" wire:loading.attr="disabled" class="w-full bg-indigo-600 text-white font-bold py-5 rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 dark:shadow-none uppercase tracking-widest text-[13px] disabled:opacity-50">
                        <span wire:loading.remove>Kirim Tugas Sekarang</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
