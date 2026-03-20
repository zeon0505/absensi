<div class="space-y-8 animate-in fade-in duration-500">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-[26px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight">Pengaturan Profil</h2>
            <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-1">Kelola informasi akun dan identitas visual Anda secara aman.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 px-6 py-4 rounded-2xl text-[14px] font-medium flex items-center space-x-4 shadow-sm">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11H9v2h2V7zm0 4H9v4h2v-4z"></path></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Photo Management (Dark Mode Compatible) -->
        <div class="bg-white dark:bg-slate-900 p-10 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col items-center text-center">
            <div class="relative group">
                <div class="w-36 h-36 rounded-[3rem] overflow-hidden bg-slate-100 dark:bg-slate-800 border-4 border-white dark:border-slate-950 shadow-2xl ring-1 ring-slate-100 dark:ring-slate-800 relative">
                    @if ($photo)
                        <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                    @else
                        <img src="{{ auth()->user()->profile_photo_url }}" class="w-full h-full object-cover">
                    @endif
                    
                    <div wire:loading wire:target="photo" class="absolute inset-0 bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm flex items-center justify-center">
                        <svg class="animate-spin h-8 w-8 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>
                </div>
                
                <label class="absolute -bottom-2 -right-2 w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center cursor-pointer shadow-xl hover:bg-indigo-700 transition-all border-4 border-white dark:border-slate-950 hover:scale-110 active:scale-95">
                    <input type="file" wire:model="photo" class="hidden" accept="image/*">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </label>
            </div>
            
            <div class="mt-8">
                <h3 class="text-[20px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight">{{ auth()->user()->name }}</h3>
                <div class="inline-flex items-center px-3 py-1 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-lg text-[10px] font-bold uppercase tracking-widest mt-2 bg-opacity-50 border border-emerald-100 dark:border-emerald-800">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></span>
                    {{ auth()->user()->role }}
                </div>
            </div>
            
            <p class="text-[12px] text-slate-400 dark:text-slate-500 mt-10 italic leading-relaxed px-6">Gunakan foto beresolusi tinggi dengan aspek rasio 1:1 untuk hasil visual terbaik di dashboard.</p>
        </div>

        <!-- Identity Form (Dark Mode Compatible) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="px-10 py-8 border-b border-slate-50 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-800/20">
                <h3 class="text-[14px] font-bold text-slate-800 dark:text-slate-100 uppercase tracking-widest">Detail Autentikasi</h3>
            </div>
            
            <form wire:submit.prevent="updateProfile" class="p-10 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2.5">
                        <label class="text-[12px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider ml-1">Nama Lengkap</label>
                        <input wire:model="name" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[14px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/30 transition-all font-medium text-slate-700 dark:text-slate-200" placeholder="Display Name">
                        @error('name') <span class="text-rose-500 text-[11px] font-medium mt-1.5 block ml-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="space-y-2.5">
                        <label class="text-[12px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider ml-1">Alamat Email</label>
                        <input wire:model="email" type="email" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[14px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/30 transition-all font-medium text-slate-700 dark:text-slate-200" placeholder="Active Email">
                        @error('email') <span class="text-rose-500 text-[11px] font-medium mt-1.5 block ml-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-50 dark:border-slate-800">
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="w-1 h-4 bg-indigo-600 rounded-full"></div>
                        <h3 class="text-[12px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Keamanan Akun</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2.5">
                            <label class="text-[12px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider ml-1">Sandi Baru</label>
                            <input wire:model="password" type="password" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[14px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/30 transition-all font-medium text-slate-700 dark:text-slate-200" placeholder="Minimal 8 karakter">
                            @error('password') <span class="text-rose-500 text-[11px] font-medium mt-1.5 block ml-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="space-y-2.5">
                            <label class="text-[12px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider ml-1">Ulangi Sandi</label>
                            <input wire:model="password_confirmation" type="password" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[14px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/30 transition-all font-medium text-slate-700 dark:text-slate-200" placeholder="Verify password">
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-6 leading-relaxed">*Biarkan kosong jika Anda tidak berencana untuk memperbarui kata sandi saat ini.</p>
                </div>

                <div class="pt-10 flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white font-semibold px-10 py-4 rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 dark:shadow-none active:scale-[0.98] text-[15px] flex items-center space-x-3">
                        <svg wire:loading.remove wire:target="updateProfile" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <svg wire:loading wire:target="updateProfile" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Update Informasi Profil</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
