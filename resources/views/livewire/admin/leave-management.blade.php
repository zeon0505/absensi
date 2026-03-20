@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Models\Leave[] $leaves */
@endphp

<div class="space-y-8 animate-in fade-in duration-500">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h2 class="text-[26px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight">Persetujuan Cuti & Izin</h2>
            <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-1">Kelola dan tinjau permintaan izin absensi staff secara real-time.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 px-6 py-4 rounded-2xl text-[14px] font-medium flex items-center space-x-4 shadow-sm animate-in slide-in-from-top-4 duration-300">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11H9v2h2V7zm0 4H9v4h2v-4z"></path></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 dark:bg-slate-800/30 text-slate-400 dark:text-slate-500 text-[11px] font-bold uppercase tracking-[0.15em]">
                    <tr>
                        <th class="px-8 py-5">Nama Staff</th>
                        <th class="px-8 py-5">Tipe Izin</th>
                        <th class="px-8 py-5">Periode Waktu</th>
                        <th class="px-8 py-5">Alasan/Keterangan</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right pr-12">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 dark:divide-slate-800/50">
                    @if(isset($leaves))
                        @forelse($leaves as $leave)
                        <tr wire:key="leave-{{ $leave->id }}" class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-all group">
                            <td class="px-8 py-7">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $leave->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=User' }}" class="w-10 h-10 rounded-xl object-cover shadow-sm border border-slate-100 dark:border-slate-750 group-hover:scale-110 transition-transform" alt="Avatar">
                                    <span class="font-medium text-slate-800 dark:text-slate-100 text-[15px] tracking-tight leading-none">{{ $leave->user->name ?? 'User' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-7">
                                <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-indigo-100/50 dark:border-indigo-800/50">
                                    {{ $leave->type }}
                                </span>
                            </td>
                            <td class="px-8 py-7 text-slate-500 dark:text-slate-400 text-[14px] font-medium">
                                {{ date('d M', strtotime($leave->start_date)) }} — {{ date('d M Y', strtotime($leave->end_date)) }}
                            </td>
                            <td class="px-8 py-7 text-slate-500 dark:text-slate-400 text-[14px] max-w-[200px] truncate" title="{{ $leave->reason }}">
                                {{ $leave->reason }}
                            </td>
                            <td class="px-8 py-7 text-center">
                                @php
                                    $statusClass = [
                                        'approved' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border-emerald-100/50 dark:border-emerald-800/50',
                                        'pending' => 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border-amber-100/50 dark:border-amber-800/50',
                                        'rejected' => 'bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 border-rose-100/50 dark:border-rose-800/50',
                                    ][$leave->status] ?? 'bg-slate-50 dark:bg-slate-800 text-slate-500';
                                @endphp
                                <span class="px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-widest border {{ $statusClass }}">
                                    {{ $leave->status }}
                                </span>
                            </td>
                            <td class="px-8 py-7 text-right pr-12 space-x-1">
                                @if($leave->status == 'pending')
                                <button wire:click="approve({{ $leave->id }})" class="p-2.5 text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-xl transition-all border border-transparent hover:border-emerald-100 dark:hover:border-emerald-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                                <button wire:click="reject({{ $leave->id }})" class="p-2.5 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-all border border-transparent hover:border-rose-100 dark:hover:border-rose-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                                @else
                                <span class="text-slate-300 dark:text-slate-700 text-[11px] font-bold uppercase tracking-widest px-4">Closed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-32 text-center text-slate-300 dark:text-slate-700">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-[1.5rem] flex items-center justify-center mb-6">
                                        <svg class="w-8 h-8 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-[15px] font-bold uppercase tracking-[0.2em]">Belum Ada Pengajuan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
        @if(isset($leaves) && method_exists($leaves, 'hasPages') && $leaves->hasPages())
        <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-800/10">
            {{ $leaves->links() }}
        </div>
        @endif
    </div>
</div>
