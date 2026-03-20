@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Models\User[] $users */
@endphp

<div class="space-y-8 animate-in fade-in duration-500">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h2 class="text-[26px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight">Data Karyawan</h2>
            <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-1">Kelola data staff dan hak akses administratif sistem.</p>
        </div>
        <button wire:click="openModal" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-medium shadow-sm hover:bg-indigo-700 transition-all flex items-center justify-center space-x-3 text-[14px] uppercase tracking-wider">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            <span>Tambah User</span>
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 px-6 py-4 rounded-2xl text-[14px] font-medium flex items-center space-x-4 shadow-sm animate-in slide-in-from-top-4 duration-300">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11H9v2h2V7zm0 4H9v4h2v-4z"></path></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden transition-colors duration-300">
        <!-- Search & Filters -->
        <div class="p-8 border-b border-slate-50 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-slate-50/20 dark:bg-slate-800/10">
            <div class="relative flex-1 max-w-md">
                <input wire:model.live="search" type="text" placeholder="Cari nama atau email..." class="w-full bg-white dark:bg-slate-800 border-2 border-transparent focus:border-indigo-500/20 rounded-xl pl-12 pr-6 py-3.5 text-[14px] font-medium text-slate-700 dark:text-slate-200 outline-none transition-all placeholder-slate-400 dark:placeholder-slate-500">
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-2">Filter</span>
                <select wire:model.live="roleFilter" class="bg-slate-50 dark:bg-slate-800 border-2 border-transparent focus:border-indigo-500/20 rounded-xl px-5 py-3.5 text-[13px] font-semibold text-slate-600 dark:text-slate-300 cursor-pointer min-w-[180px] outline-none transition-all">
                    <option value="">Semua Peran</option>
                    <option value="user">📱 Karyawan</option>
                    <option value="admin">💻 Administrator</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 dark:bg-slate-800/30 text-slate-400 dark:text-slate-500 text-[11px] font-bold uppercase tracking-[0.15em]">
                    <tr>
                        <th class="px-8 py-5">Identitas Staff</th>
                        <th class="px-8 py-5 text-center">Status Akses</th>
                        <th class="px-8 py-5">Tanggal Bergabung</th>
                        <th class="px-8 py-5 text-right pr-12">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 dark:divide-slate-800/50">
                    @if(isset($users))
                        @forelse($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-all group">
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <img src="{{ $user->profile_photo_url }}" class="w-11 h-11 rounded-xl object-cover shadow-sm bg-slate-100 dark:bg-slate-800 transition-transform group-hover:scale-110 border border-slate-100 dark:border-slate-750" alt="Avatar">
                                        @if($user->isOnline())
                                            <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-500 border-2 border-white dark:border-slate-900 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div>
                                        @else
                                            <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-slate-300 dark:bg-slate-600 border-2 border-white dark:border-slate-900 rounded-full"></div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center space-x-2">
                                            <p class="font-medium text-slate-800 dark:text-slate-100 text-[15px] truncate tracking-tight leading-none">{{ $user->name }}</p>
                                            @if($user->isOnline())
                                                <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest leading-none">Online</span>
                                            @else
                                                <span class="text-[9px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-widest leading-none">Offline</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2 mt-2">
                                            <p class="text-slate-400 dark:text-slate-500 text-[12px] truncate font-normal leading-none">{{ $user->email }}</p>
                                            <span class="text-[10px] text-slate-300 dark:text-slate-700 font-bold">•</span>
                                            <span class="text-slate-400 dark:text-slate-500 text-[11px] font-medium leading-none">
                                                @if($user->last_active_at)
                                                    Aktif {{ $user->last_active_at->diffForHumans() }}
                                                @else
                                                    Belum pernah aktif
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($user->role === 'admin')
                                    <span class="px-3 py-1 bg-violet-50 dark:bg-violet-900/20 text-violet-600 dark:text-violet-400 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-violet-100/50 dark:border-violet-800/50">Admin</span>
                                @else
                                    <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-indigo-100/50 dark:border-indigo-800/50">Staff</span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-slate-500 dark:text-slate-400 text-[14px] font-medium">{{ $user->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-8 py-6 text-right pr-12 space-x-1">
                                <button wire:click="edit({{ $user->id }})" class="p-3 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button wire:click="delete({{ $user->id }})" wire:confirm="Hapus akun ini selamanya?" class="p-3 text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 transition-all rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-32 text-center text-slate-300 dark:text-slate-700">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center mb-6">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <p class="font-bold uppercase tracking-[0.2em] text-[15px]">Database Kosong</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>

        @if(isset($users) && method_exists($users, 'hasPages') && $users->hasPages())
        <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-800/10">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- Modal (Dark Mode Ready) -->
    @if($isOpen)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-sm animate-in fade-in duration-300">
        <div wire:click="closeModal" class="absolute inset-0"></div>
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] w-full max-w-lg relative z-[110] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden animate-in zoom-in-95 duration-200">
            <div class="px-10 py-8 border-b border-slate-50 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-800/20 flex items-center justify-between">
                <div>
                    <h3 class="text-[20px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight">{{ $userId ? 'Sunting Data Staff' : 'Registrasi Staff Baru' }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1.5 leading-none">Security & Access Profile</p>
                </div>
                <button wire:click="closeModal" class="p-2.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors bg-slate-50 dark:bg-slate-800 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <form wire:submit.prevent="store" class="p-10 space-y-7">
                <div class="space-y-2.5">
                    <label class="text-[12px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider ml-1">Nama Lengkap</label>
                    <input wire:model="name" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[14px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 transition-all font-medium text-slate-700 dark:text-slate-200" placeholder="e.g. Budi Raharjo">
                    @error('name') <span class="text-rose-500 text-[11px] font-medium mt-2 block ml-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="space-y-2.5">
                    <label class="text-[12px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider ml-1">Alamat Email</label>
                    <input wire:model="email" type="email" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[14px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 transition-all font-medium text-slate-700 dark:text-slate-200" placeholder="user@company.com">
                    @error('email') <span class="text-rose-500 text-[11px] font-medium mt-2 block ml-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="space-y-2.5">
                    <label class="text-[12px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider ml-1">Kata Sandi</label>
                    <input wire:model="password" type="password" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[14px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 transition-all font-medium text-slate-700 dark:text-slate-200" placeholder="Minimal 8 karakter">
                    @if($userId) <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-2 font-medium italic ml-1 leading-relaxed">*Kosongkan jika tidak ada perubahan.</p> @endif
                    @error('password') <span class="text-rose-500 text-[11px] font-medium mt-2 block ml-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="space-y-2.5">
                    <label class="text-[12px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider ml-1">Peran Pengguna</label>
                    <select wire:model="role" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[14px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 transition-all cursor-pointer font-semibold text-slate-700 dark:text-slate-200">
                        <option value="user">📱 USER (Mobile Access)</option>
                        <option value="admin">💻 ADMIN (Dashboard Full Control)</option>
                    </select>
                </div>
                
                <div class="pt-8">
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4.5 rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 dark:shadow-none active:scale-[0.98] text-[15px] tracking-tight uppercase tracking-wider">
                        {{ $userId ? 'Update Data Staff' : 'Daftarkan Staff' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
