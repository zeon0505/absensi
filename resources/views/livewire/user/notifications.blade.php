@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Notifications\DatabaseNotification[] $notifications */
@endphp

<div class="max-w-2xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-6 duration-700">
    <div class="flex items-center justify-between">
        <h2 class="text-4xl font-black text-slate-800 tracking-tighter">Notifikasi</h2>
        @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
        <button wire:click="markAllAsRead" class="bg-indigo-50 text-indigo-600 px-6 py-2.5 rounded-2xl text-sm font-black hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
            Baca Semua
        </button>
        @endif
    </div>

    <div class="space-y-6">
        @if(isset($notifications) && count($notifications) > 0)
            @foreach($notifications as $notify)
            <div wire:click="markAsRead('{{ $notify->id }}')" class="group p-8 rounded-[2.5rem] border transition-all cursor-pointer relative overflow-hidden {{ $notify->read_at ? 'bg-white border-slate-100' : 'bg-white border-indigo-200 ring-4 ring-indigo-50/50 shadow-2xl shadow-indigo-100' }}">
                @if(!$notify->read_at)
                    <div class="absolute top-0 right-0 w-16 h-16 bg-indigo-600 transform rotate-45 translate-x-10 -translate-y-10 group-hover:bg-indigo-500 transition-colors"></div>
                @endif
                
                <div class="flex items-start space-x-6">
                    <div class="mt-1 w-14 h-14 rounded-3xl flex items-center justify-center shadow-lg transition-transform group-hover:scale-110 {{ $notify->read_at ? 'bg-slate-100 text-slate-400 shadow-slate-50' : 'bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-indigo-200' }}">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-slate-800 text-xl leading-snug tracking-tight group-hover:text-indigo-600 transition-colors">{{ $notify->data['message'] ?? 'Pesan Baru' }}</p>
                        <div class="flex items-center space-x-3 mt-3">
                            <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-widest">{{ $notify->created_at->diffForHumans() }}</span>
                            @if(!$notify->read_at)
                                <span class="text-indigo-600 text-[10px] font-black uppercase tracking-widest animate-pulse">Belum Dibaca</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="bg-white p-20 rounded-[3rem] border border-slate-100 text-center shadow-sm">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </div>
                <p class="text-slate-400 font-bold text-xl">Kotak masuk bersih!</p>
                <p class="text-slate-300 font-medium mt-1">Tidak ada notifikasi baru untuk saat ini.</p>
            </div>
        @endif
    </div>

    @if(isset($notifications) && method_exists($notifications, 'hasPages') && $notifications->hasPages())
    <div class="pt-8 pagination-premium">
        {{ $notifications->links() }}
    </div>
    @endif
</div>
