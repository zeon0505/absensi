@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Models\Attendance[] $attendances */
@endphp

<div class="space-y-8 animate-in fade-in duration-500">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center space-x-5">
            <div class="w-14 h-14 bg-indigo-600 text-white rounded-[1.25rem] flex items-center justify-center shadow-lg shadow-indigo-200 dark:shadow-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <div>
                <h2 class="text-[24px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight leading-none">Histori Absensi</h2>
                <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-2 font-medium">Rekaman waktu kehadiran Anda selama bekerja.</p>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 px-6 py-3.5 rounded-2xl flex items-center space-x-3 shadow-sm">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-[14px] font-bold text-slate-700 dark:text-slate-200 capitalize tracking-tight">{{ date('F Y') }}</span>
        </div>
    </div>

    <!-- Data Card -->
    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 dark:bg-slate-800/30 text-slate-400 dark:text-slate-500 text-[11px] font-bold uppercase tracking-[0.15em]">
                    <tr>
                        <th class="px-10 py-5">Hari & Tanggal</th>
                        <th class="px-8 py-5">Ruang Kelas</th>
                        <th class="px-8 py-5">Aktivitas</th>
                        <th class="px-8 py-5 text-center">Waktu Log</th>
                        <th class="px-8 py-5 text-right pr-12">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 dark:divide-slate-800/50">
                    @if(isset($attendances) && count($attendances) > 0)
                        @foreach ($attendances as $record)
                            <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-all">
                                <td class="px-10 py-7">
                                    <div class="flex flex-col">
                                        <span class="text-slate-800 dark:text-slate-100 font-semibold text-[16px] tracking-tight">{{ date('d M Y', strtotime($record->date)) }}</span>
                                        <span class="text-slate-400 dark:text-slate-500 text-[11px] font-medium uppercase tracking-widest mt-1">{{ date('l', strtotime($record->date)) }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-7">
                                    <span class="text-[13px] font-semibold text-slate-600 dark:text-slate-400">
                                        {{ $record->classroom->name ?? 'System' }}
                                    </span>
                                </td>
                                <td class="px-8 py-7">
                                    <div class="flex items-center space-x-3">
                                        @if($record->check_in && !$record->check_out)
                                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                                            <span class="text-slate-600 dark:text-slate-300 font-bold text-[11px] uppercase tracking-wider">Check In</span>
                                        @elseif($record->check_out)
                                            <div class="w-2.5 h-2.5 rounded-full bg-indigo-500"></div>
                                            <span class="text-slate-600 dark:text-slate-300 font-bold text-[11px] uppercase tracking-wider">Shift Selesai</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-7 text-center">
                                    @php
                                        $displayTime = $record->check_out ?: $record->check_in;
                                    @endphp
                                    <span class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-100 px-5 py-2 rounded-xl font-mono text-[15px] font-bold border border-slate-200 dark:border-slate-700">
                                        {{ date('H:i', strtotime($displayTime)) }}
                                    </span>
                                </td>
                                <td class="px-8 py-7 text-right pr-12">
                                    @php
                                        $statusStyles = $record->status == 'hadir' 
                                            ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border-emerald-100/50 dark:border-emerald-800/50' 
                                            : 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border-amber-100/50 dark:border-amber-800/50';
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-widest border {{ $statusStyles }}">
                                        {{ $record->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-8 py-32 text-center text-slate-300 dark:text-slate-700">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-[2.5rem] flex items-center justify-center mb-6">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="font-bold uppercase tracking-[0.15em] text-[15px]">Belum Ada Rekaman</p>
                                    <p class="text-slate-400 dark:text-slate-600 text-[13px] mt-2 font-medium">Data akan muncul setelah Anda mulai Check In.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        @if(isset($attendances) && method_exists($attendances, 'links') && $attendances->hasPages())
        <div class="px-10 py-6 border-t border-slate-50 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-800/10">
            {{ $attendances->links() }}
        </div>
        @endif
    </div>
</div>
