<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in duration-500">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center space-x-5">
            <div class="w-14 h-14 bg-indigo-600 text-white rounded-[1.25rem] flex items-center justify-center shadow-lg shadow-indigo-100 dark:shadow-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <h2 class="text-[24px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight leading-none">Presensi Lokasi</h2>
                <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-2 font-medium">Lakukan absensi menggunakan koordinat GPS Anda.</p>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-10 border border-slate-100 dark:border-slate-800 shadow-sm transition-colors text-center overflow-hidden relative">
        <div class="max-w-md mx-auto space-y-8">
            
            @if($step == 1)
            <!-- Step 1: Select Classroom -->
            <div class="w-24 h-24 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-[2.5rem] flex items-center justify-center mx-auto shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            
            <div class="space-y-4">
                <h3 class="text-[20px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight">Pilih Ruang Kelas</h3>
                <p class="text-[14px] text-slate-500 font-medium">Klik pada kelas yang ingin Anda laporkan kehadirannya hari ini.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                @forelse($classrooms as $class)
                <button wire:click="selectClass({{ $class->id }})" class="w-full flex items-center justify-between p-5 bg-slate-50 dark:bg-slate-800 rounded-2xl border-2 border-transparent hover:border-indigo-500/30 hover:bg-white dark:hover:bg-slate-750 transition-all group overflow-hidden relative">
                    <div class="flex items-center space-x-4 relative z-10">
                        <div class="w-11 h-11 bg-white dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center font-bold text-sm shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            {{ strtoupper(substr($class->name, 0, 1)) }}
                        </div>
                        <div class="text-left">
                            <span class="block font-semibold text-slate-700 dark:text-slate-200 text-[15px] group-hover:translate-x-1 transition-transform">{{ $class->name }}</span>
                            <span class="block text-[10px] text-slate-400 uppercase tracking-widest mt-0.5">Approved Member</span>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 dark:text-slate-600 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </button>
                @empty
                    <div class="py-12 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border-2 border-dashed border-slate-100 dark:border-slate-800">
                        <p class="text-slate-400 text-[14px] font-medium leading-relaxed px-6">Anda belum terdaftar atau disetujui di kelas manapun.</p>
                        <a href="{{ route('dashboard') }}" wire:navigate class="mt-6 px-6 py-3 bg-indigo-600 text-white rounded-xl text-[12px] font-bold uppercase tracking-widest inline-block hover:bg-indigo-700 shadow-lg shadow-indigo-100 dark:shadow-none transition-all">Gabung Kelas</a>
                    </div>
                @endforelse
            </div>

            @else
            <!-- Step 2: GPS Check-in -->
            <button wire:click="$set('step', 1)" class="absolute top-6 left-6 p-3 text-slate-400 hover:text-indigo-600 transition-colors bg-slate-50 dark:bg-slate-800 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <div class="w-24 h-24 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-[2.5rem] flex items-center justify-center mx-auto shadow-inner animate-pulse">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>

            <div class="space-y-4">
                <h3 class="text-[20px] font-semibold text-slate-800 dark:text-slate-100">Presensi Lokasi Siap</h3>
                <p class="text-[14px] text-slate-500 font-medium">Klik tombol di bawah untuk mengirim koordinat lokasi Anda.</p>
            </div>

            <div class="p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl flex flex-col items-center">
                 <div id="location-display" class="text-[12px] font-mono text-slate-400">Menunggu koordinat GPS...</div>
            </div>

            <button onclick="getLocation()" id="btn-gps" class="w-full bg-indigo-600 text-white font-bold py-5 rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 dark:shadow-none uppercase tracking-widest text-[13px] flex items-center justify-center space-x-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Kirim Presensi GPS</span>
            </button>
            @endif
        </div>
    </div>

    <!-- Location Script -->
    <script>
        function getLocation() {
            const btn = document.getElementById('btn-gps');
            const display = document.getElementById('location-display');
            
            btn.innerHTML = '<span class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></span><span>Mengambil Lokasi...</span>';
            btn.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        display.innerText = "Lat: " + lat.toFixed(6) + " | Lng: " + lng.toFixed(6);
                        Livewire.dispatch('updateLocation', { lat: lat, lng: lng });
                        
                        setTimeout(() => {
                            @this.checkIn();
                        }, 500);
                    },
                    function(error) {
                        alert("Gagal mengambil lokasi: " + error.message);
                        btn.innerHTML = '<span>Kirim Presensi GPS</span>';
                        btn.disabled = false;
                    }
                );
            } else {
                alert("Geolocation tidak didukung oleh browser Anda.");
                btn.disabled = false;
            }
        }
    </script>
</div>
