@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Models\Attendance[] $attendances */
@endphp

<div class="space-y-8 animate-in fade-in duration-500">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h2 class="text-[26px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight">Laporan Absensi Karyawan</h2>
            <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-1">Monitoring dan unduh riwayat kehadiran seluruh staff.</p>
        </div>
        <div class="flex items-center space-x-4">
            <button wire:click="exportPdf" class="bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 font-medium py-3 px-6 rounded-2xl border border-rose-100 dark:border-rose-800 hover:bg-rose-600 dark:hover:bg-rose-600 hover:text-white transition-all text-[14px] flex items-center space-x-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                <span>Cetak PDF</span>
            </button>
            <button wire:click="exportExcel" class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 font-medium py-3 px-6 rounded-2xl border border-emerald-100 dark:border-emerald-800 hover:bg-emerald-600 dark:hover:bg-emerald-600 hover:text-white transition-all text-[14px] flex items-center space-x-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Excel</span>
            </button>
        </div>
    </div>

    <!-- Enhanced Filters (Dark Mode Compatible) -->
    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm grid grid-cols-1 md:grid-cols-4 gap-6 transition-colors">
        <div class="space-y-2">
            <label class="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Karyawan</label>
            <div class="relative">
                <input wire:model.live="search" type="text" class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 text-[14px] font-medium text-slate-700 dark:text-slate-200 outline-none transition-all placeholder-slate-400 dark:placeholder-slate-500" placeholder="Nama staff...">
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        <div class="space-y-2">
            <label class="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Dari Tanggal</label>
            <input wire:model.live="dateFrom" type="date" class="w-full px-5 py-3 bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 text-[14px] font-medium text-slate-700 dark:text-slate-200 outline-none transition-all">
        </div>
        <div class="space-y-2">
            <label class="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Hingga Tanggal</label>
            <input wire:model.live="dateTo" type="date" class="w-full px-5 py-3 bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 text-[14px] font-medium text-slate-700 dark:text-slate-200 outline-none transition-all">
        </div>
        <div class="space-y-2">
            <label class="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Status Kehadiran</label>
            <select wire:model.live="status" class="w-full px-5 py-3 bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 text-[14px] font-medium text-slate-700 dark:text-slate-200 outline-none transition-all cursor-pointer">
                <option value="">Semua Status</option>
                <option value="hadir">✅ Tepat Waktu</option>
                <option value="terlambat">⚠️ Terlambat</option>
                <option value="tidak hadir">❌ Tidak Hadir</option>
            </select>
        </div>
        <div class="space-y-2">
            <label class="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Ruang Kelas</label>
            <select wire:model.live="selectedClassId" class="w-full px-5 py-3 bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-xl focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 text-[14px] font-medium text-slate-700 dark:text-slate-200 outline-none transition-all cursor-pointer">
                <option value="">Semua Kelas</option>
                @foreach($classrooms as $cls)
                    <option value="{{ $cls->id }}">{{ $cls->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Data Table (Dark Mode Compatible) -->
    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden transition-colors">
        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 dark:bg-slate-800/30 text-slate-400 dark:text-slate-500 text-[12px] font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-8 py-5">Informasi Staff</th>
                        <th class="px-8 py-5">Ruang Kelas</th>
                        <th class="px-8 py-5">Waktu Absensi</th>
                        <th class="px-8 py-5">Logs</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right pr-12">Lokasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 dark:divide-slate-800/50">
                    @if(isset($attendances))
                        @forelse($attendances as $attendance)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all group">
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $attendance->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=User' }}" class="w-10 h-10 rounded-xl object-cover shadow-sm border border-slate-100 dark:border-slate-750 transition-transform group-hover:scale-105" alt="Avatar">
                                    <span class="font-medium text-slate-800 dark:text-slate-100 text-[15px] tracking-tight">{{ $attendance->user->name ?? 'User' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-lg text-[12px] font-semibold border border-slate-200 dark:border-slate-700">
                                        {{ $attendance->classroom->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-slate-500 dark:text-slate-400 text-[14px] font-medium">
                                {{ date('d M Y', strtotime($attendance->date)) }}
                            </td>
                            <td class="px-8 py-6 space-x-2">
                                <span class="bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase tracking-wider border border-indigo-100 dark:border-indigo-800">IN: {{ $attendance->check_in }}</span>
                                @if($attendance->check_out)
                                <span class="bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase tracking-wider border border-slate-200 dark:border-slate-700">OUT: {{ $attendance->check_out }}</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-center">
                                @php
                                    $statusClass = $attendance->status == 'hadir' 
                                        ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800' 
                                        : 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border-amber-100 dark:border-amber-800';
                                @endphp
                                <span class="px-4 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-widest border transition-colors {{ $statusClass }}">
                                    {{ $attendance->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right pr-12">
                                @if($attendance->latitude)
                                <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}" target="_blank" class="p-3 bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 hover:bg-indigo-600 hover:text-white transition-all inline-block">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </a>
                                @else
                                <span class="text-slate-300 dark:text-slate-700 italic text-[11px] font-medium pr-2">No GPS</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center text-slate-300 dark:text-slate-700">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="text-[15px] font-bold uppercase tracking-[0.2em]">Data Tidak Ditemukan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
        @if(isset($attendances) && method_exists($attendances, 'hasPages') && $attendances->hasPages())
        <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-800/20">
            {{ $attendances->links() }}
        </div>
        @endif
    </div>
</div>
