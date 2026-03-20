@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Models\Leave[] $leaves */
@endphp

<div class="space-y-8 animate-in fade-in duration-500">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-5">
            <div class="w-14 h-14 bg-indigo-600 text-white rounded-[1.25rem] flex items-center justify-center shadow-lg shadow-indigo-100 dark:shadow-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h2 class="text-[24px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight leading-none">Status Pengajuan</h2>
                <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-2 font-medium">Pantau status permintaan izin dan cuti Anda.</p>
            </div>
        </div>
        
        <a href="{{ route('leave.request') }}" wire:navigate class="bg-indigo-600 text-white px-6 py-4 rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-md flex items-center space-x-3 text-[13px] uppercase tracking-wider">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            <span>Buat Baru</span>
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden transition-colors">
        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 dark:bg-slate-800/30 text-slate-400 dark:text-slate-500 text-[11px] font-bold uppercase tracking-[0.15em]">
                    <tr>
                        <th class="px-10 py-5">Jenis Izin</th>
                        <th class="px-8 py-5">Rentang Waktu</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right pr-12">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 dark:divide-slate-800/50">
                    @if(isset($leaves) && count($leaves) > 0)
                        @foreach($leaves as $leave)
                        <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-all">
                            <td class="px-10 py-7">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($leave->type, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-slate-800 dark:text-slate-100 text-[16px] tracking-tight capitalize">{{ $leave->type }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-7">
                                <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-4 py-1.5 rounded-xl font-semibold text-[13px]">
                                    {{ date('d M', strtotime($leave->start_date)) }} — {{ date('d M Y', strtotime($leave->end_date)) }}
                                </span>
                            </td>
                            <td class="px-8 py-7 text-center">
                                @php
                                    $statusStyle = [
                                        'approved' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border-emerald-100/50 dark:border-emerald-800/50',
                                        'pending' => 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border-amber-100/50 dark:border-amber-800/50',
                                        'rejected' => 'bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 border-rose-100/50 dark:border-rose-800/50',
                                    ][$leave->status] ?? 'bg-slate-50 dark:bg-slate-800 text-slate-500 border-slate-100';
                                @endphp
                                <span class="px-4 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-widest border {{ $statusStyle }}">
                                    {{ $leave->status }}
                                </span>
                            </td>
                            <td class="px-8 py-7 text-right pr-12">
                                <p class="text-slate-400 dark:text-slate-500 text-[13px] font-medium italic line-clamp-1 max-w-[200px] ml-auto" title="{{ $leave->reason }}">
                                    "{{ $leave->reason }}"
                                </p>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-8 py-32 text-center text-slate-300 dark:text-slate-700">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-[2.5rem] flex items-center justify-center mb-6">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="font-bold uppercase tracking-[0.15em] text-[15px]">Belum Ada Pengajuan</p>
                                    <p class="text-slate-400 dark:text-slate-600 text-[13px] mt-2 font-medium">Daftar permohonan Anda akan tampil di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if(isset($leaves) && method_exists($leaves, 'hasPages') && $leaves->hasPages())
        <div class="px-10 py-6 border-t border-slate-50 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-800/10">
            {{ $leaves->links() }}
        </div>
        @endif
    </div>
</div>
