@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Models\Classroom[] $classrooms */
@endphp

<div class="space-y-8 animate-in fade-in duration-500">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h2 class="text-[26px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight">Data Ruang Kelas</h2>
            <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-1">Daftar kelas aktif, kode enroll, dan manajemen persetujuan anggota.</p>
        </div>
        @if($isGlobalAdmin)
        <button wire:click="openModal" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-medium shadow-sm hover:bg-indigo-700 transition-all flex items-center justify-center space-x-3 text-[14px]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Kelas</span>
        </button>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 px-6 py-4 rounded-2xl text-[14px] font-medium flex items-center space-x-4 shadow-sm">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11H9v2h2V7zm0 4H9v4h2v-4z"></path></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden transition-colors">
        <!-- Search Area -->
        <div class="p-8 border-b border-slate-50 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-800/20 text-right">
            <div class="inline-block relative w-full max-w-md">
                <input wire:model.live="search" type="text" placeholder="Cari nama kelas..." class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl pl-12 pr-6 py-3 text-[14px] focus:ring-2 focus:ring-indigo-500/10 dark:focus:ring-indigo-900/20 focus:border-indigo-500 outline-none transition-all placeholder-slate-400 dark:placeholder-slate-500 text-slate-700 dark:text-slate-100 font-medium tracking-tight">
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 dark:bg-slate-800/30 text-slate-400 dark:text-slate-500 text-[11px] font-bold uppercase tracking-[0.15em]">
                    <tr>
                        <th class="px-8 py-5">Nama Kelas</th>
                        <th class="px-8 py-5">Admin Pengelola</th>
                        <th class="px-8 py-5">Enroll Code</th>
                        <th class="px-8 py-5 text-center">Anggota</th>
                        <th class="px-8 py-5 text-right pr-12">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 dark:divide-slate-800/50">
                    @if(isset($classrooms))
                        @forelse($classrooms as $class)
                        <tr wire:key="class-{{ $class->id }}" class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all group">
                            <td class="px-8 py-7">
                                <div class="flex items-center space-x-4">
                                    <div class="w-11 h-11 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center font-bold text-base border border-indigo-200 dark:border-indigo-800 shadow-sm">
                                        {{ strtoupper(substr($class->name, 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-slate-800 dark:text-slate-100 text-[15px] tracking-tight">{{ $class->name }}</span>
                                        <span class="text-slate-400 text-[11px] truncate max-w-[200px]">{{ $class->description ?: 'Tanpa deskripsi' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-7">
                                @if($class->admin)
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 rounded-md bg-violet-100 dark:bg-violet-900/40 text-violet-600 dark:text-violet-400 flex items-center justify-center text-[10px] font-bold">
                                            {{ strtoupper(substr($class->admin->name, 0, 1)) }}
                                        </div>
                                        <span class="text-[13px] font-medium text-slate-600 dark:text-slate-300">{{ $class->admin->name }}</span>
                                    </div>
                                @else
                                    <span class="text-[11px] text-slate-400 italic">Belum diset</span>
                                @endif
                            </td>
                            <td class="px-8 py-7">
                                <code class="bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg text-indigo-600 dark:text-indigo-400 font-mono font-bold text-[14px] border border-slate-200 dark:border-slate-700">
                                    {{ $class->enroll_code ?: 'N/A' }}
                                </code>
                            </td>
                            <td class="px-8 py-7 text-center">
                                <button wire:click="manageMembers({{ $class->id }})" class="px-3.5 py-1.5 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-lg text-[11px] font-bold uppercase tracking-wider border border-indigo-100 dark:border-indigo-800 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-colors">
                                    {{ $class->users_count ?? 0 }} Terdaftar
                                </button>
                            </td>
                            <td class="px-8 py-7 text-right pr-12 space-x-1.5">
                                <button wire:click="edit({{ $class->id }})" class="p-2.5 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all rounded-xl hover:bg-white dark:hover:bg-slate-800 border border-transparent hover:border-slate-100 dark:hover:border-slate-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                @if($isGlobalAdmin)
                                <button wire:click="delete({{ $class->id }})" wire:confirm="Hapus data kelas ini?" class="p-2.5 text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 transition-all rounded-xl hover:bg-white dark:hover:bg-slate-800 border border-transparent hover:border-slate-100 dark:hover:border-slate-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-32 text-center text-slate-300 dark:text-slate-700">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-[1.5rem] flex items-center justify-center mb-4 transition-colors">
                                        <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <p class="text-[14px] font-bold uppercase tracking-[0.2em]">Data Kelas Kosong</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>

        @if(isset($classrooms) && method_exists($classrooms, 'links') && $classrooms->hasPages())
        <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-800/20">
            {{ $classrooms->links() }}
        </div>
        @endif
    </div>

    <!-- Modal (Dark Mode Optimized) -->
    @if($isOpen)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/60 dark:bg-slate-950/90 backdrop-blur-sm animate-in fade-in duration-300">
        <div wire:click="closeModal" class="absolute inset-0"></div>
        
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] w-full max-w-2xl relative z-[110] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden animate-in zoom-in-95 duration-200">
            @if($manageMembersMode)
                <!-- Member Management View -->
                <div class="px-10 py-8 border-b border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30 flex items-center justify-between">
                    <div>
                        <h3 class="text-[20px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight leading-none">Anggota: {{ $selectedClass->name }}</h3>
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-2">Persetujuan Pendaftaran</p>
                    </div>
                    <button wire:click="closeModal" class="p-2 text-slate-400 hover:text-rose-500 transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <div class="p-0 max-h-[500px] overflow-y-auto custom-scrollbar">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/30 dark:bg-slate-800/20 text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                            <tr>
                                <th class="px-10 py-5">Nama Anggota</th>
                                <th class="px-8 py-5">Status</th>
                                <th class="px-8 py-5 text-right pr-12">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/50 dark:divide-slate-800/50">
                            @forelse($selectedClass->users as $member)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">
                                <td class="px-10 py-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center font-bold text-slate-500 text-xs">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                                        <span class="text-[15px] font-medium text-slate-700 dark:text-slate-200 tracking-tight">{{ $member->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $sStyle = [
                                            'approved' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border-emerald-100',
                                            'pending' => 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border-amber-100',
                                            'rejected' => 'bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 border-rose-100',
                                        ][$member->pivot->status] ?? 'bg-slate-100 text-slate-400';
                                    @endphp
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-bold border uppercase tracking-widest {{ $sStyle }}">
                                        {{ $member->pivot->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right pr-12 space-x-2">
                                    @if($member->pivot->status == 'pending')
                                        <button wire:click="updateMemberStatus({{ $member->id }}, 'approved')" class="p-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 rounded-xl hover:bg-emerald-600 hover:text-white transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></button>
                                        <button wire:click="updateMemberStatus({{ $member->id }}, 'rejected')" class="p-2 bg-rose-50 dark:bg-rose-900/20 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                    @else
                                        <button wire:click="updateMemberStatus({{ $member->id }}, 'pending')" class="text-[11px] font-bold text-slate-400 hover:text-indigo-600 uppercase tracking-widest transition-colors underline">Reset</button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-10 py-20 text-center text-slate-400 italic">Belum ada anggota yang mendaftar.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Classroom Form View -->
                <div class="px-10 py-8 border-b border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30 flex items-center justify-between">
                    <div>
                        <h3 class="text-[20px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight leading-none">{{ $classroomId ? 'Sunting Kelas' : 'Tambah Ruang Baru' }}</h3>
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-2 leading-none">Classroom Identity</p>
                    </div>
                    <button wire:click="closeModal" class="p-2 text-slate-400 hover:text-rose-500 transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <form wire:submit.prevent="store" class="p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Nama Kelas</label>
                            <input wire:model="name" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[15px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 transition-all font-medium text-slate-700 dark:text-slate-200" placeholder="e.g. IT Support">
                            @error('name') <span class="text-rose-500 text-[11px] font-semibold mt-1.5 block ml-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="space-y-3">
                            <label class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Enrollment Code</label>
                            <div class="relative">
                                <input wire:model="enroll_code" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[15px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 transition-all font-mono font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest" placeholder="CODE">
                                <button type="button" @click="$wire.enroll_code = Math.random().toString(36).substr(2, 6).toUpperCase()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg></button>
                            </div>
                            @error('enroll_code') <span class="text-rose-500 text-[11px] font-semibold mt-1.5 block ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <label class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Deskripsi Ruangan</label>
                        <textarea wire:model="description" rows="4" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[15px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 transition-all resize-none font-medium text-slate-700 dark:text-slate-200" placeholder="Catatan opsional mengenai fungsi kelas..."></textarea>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">Admin Pengelola</label>
                        <select wire:model="admin_id" class="w-full bg-slate-50 dark:bg-slate-800 border-2 border-transparent rounded-2xl px-6 py-4 text-[15px] outline-none focus:bg-white dark:focus:bg-slate-750 focus:border-indigo-500/20 transition-all font-semibold text-slate-700 dark:text-slate-200 cursor-pointer">
                            <option value="">Pilih Admin Pengelola...</option>
                            @foreach($admins as $adm)
                                <option value="{{ $adm->id }}">{{ $adm->name }} ({{ $adm->email }})</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 mt-2 px-1">Admin ini akan bertanggung jawab mengelola absensi dan QR code untuk kelas ini.</p>
                    </div>
                    
                    <div class="pt-6">
                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-5 rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 dark:shadow-none uppercase tracking-widest text-[13px]">
                            Simpan Data Kelas
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
    @endif
</div>
