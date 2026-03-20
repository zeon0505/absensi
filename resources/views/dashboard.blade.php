<x-app-layout>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Welcome Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 col-span-1 md:col-span-2 lg:col-span-3">
            <h2 class="text-2xl font-bold text-slate-800">Selamat Datang di Dashboard!</h2>
            <p class="text-slate-500 mt-2">Pilih menu di bawah ini untuk mengelola aktivitas absensi Anda.</p>
        </div>

        <!-- Check In -->
        <a href="{{ route('attendance.check-in') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:border-indigo-300 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Check In GPS</h3>
            <p class="text-slate-500 text-sm mt-1">Lakukan absensi menggunakan lokasi GPS saat ini.</p>
        </a>

        <!-- Scan QR -->
        <a href="{{ route('attendance.scan') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:border-violet-300 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-violet-50 text-violet-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01m-4-7h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Scan QR Code</h3>
            <p class="text-slate-500 text-sm mt-1">Absensi dengan melakukan scan QR Code harian.</p>
        </a>

        <!-- Histori Absensi -->
        <a href="{{ route('attendance.history') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:border-emerald-300 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Histori Absensi</h3>
            <p class="text-slate-500 text-sm mt-1">Lihat riwayat kehadiran Anda di sini.</p>
        </a>

        <!-- Ajukan Cuti/Izin -->
        <a href="{{ route('leave.request') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:border-amber-300 hover:shadow-md transition-all group">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Ajukan Cuti/Izin</h3>
            <p class="text-slate-500 text-sm mt-1">Ajukan permohonan ketidakhadiran dengan alasan.</p>
        </a>

    </div>
</x-app-layout>
