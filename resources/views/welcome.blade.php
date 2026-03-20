<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jalupab - Sistem Absensi Online Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .hero-gradient { background: radial-gradient(circle at top right, #4f46e5 0%, #7c3aed 30%, #f8fafc 100%); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 overflow-x-hidden">

    <!-- Header -->
    <header class="fixed top-0 w-full z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto glass border border-white/40 rounded-[2rem] px-8 py-4 flex items-center justify-between shadow-xl shadow-indigo-100/20">
            <div class="flex items-center space-x-3">
                <div class="bg-indigo-600 p-2 rounded-xl shadow-lg shadow-indigo-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600">Jalupab</span>
            </div>
            
            <nav class="hidden md:flex items-center space-x-8 font-semibold text-slate-600">
                <a href="#fitur" class="hover:text-indigo-600 transition-colors">Fitur</a>
                <a href="#cara-kerja" class="hover:text-indigo-600 transition-colors">Cara Kerja</a>
                <a href="#kontak" class="hover:text-indigo-600 transition-colors">Kontak</a>
            </nav>

            <div class="flex items-center space-x-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all transform hover:scale-105 active:scale-95 text-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-indigo-600 font-bold px-4 py-3 hover:text-indigo-700 transition-colors text-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all transform hover:scale-105 active:scale-95 text-sm">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-40 pb-20 px-6 overflow-hidden">
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-indigo-100/50 rounded-full blur-[120px] -mr-96 -mt-96 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-violet-100/30 rounded-full blur-[100px] -ml-64 -mb-64"></div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
            <div class="space-y-8 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 bg-indigo-50 border border-indigo-100 px-4 py-2 rounded-full">
                    <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-ping"></span>
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Sistem Absensi Online Terbaik 2026</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight tracking-tight">
                    Kelola <span class="text-indigo-600">Kehadiran</span> Tim Anda Lebih Pintar & Efisien.
                </h1>
                <p class="text-lg text-slate-500 font-medium max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    Sistem absensi berbasis cloud dengan fitur GPS, QR Code, dan pelaporan otomatis yang didesain untuk meningkatkan produktivitas perusahaan Anda.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-indigo-600 text-white font-bold px-10 py-5 rounded-[2rem] shadow-2xl shadow-indigo-200 hover:bg-indigo-700 transition-all transform hover:-translate-y-1">
                        Coba Gratis Sekarang
                    </a>
                    <a href="#cara-kerja" class="flex items-center space-x-3 font-bold text-slate-700 hover:text-indigo-600 transition-colors group">
                        <div class="p-3 bg-white rounded-full shadow-lg group-hover:bg-indigo-50 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
                        </div>
                        <span>Lihat Demo Video</span>
                    </a>
                </div>
                <div class="pt-8 flex items-center justify-center lg:justify-start space-x-8 opacity-50 grayscale hover:grayscale-0 transition-all">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google" class="h-6">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft" class="h-6">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg" alt="Netflix" class="h-6">
                </div>
            </div>

            <div class="relative max-w-2xl mx-auto lg:max-w-none">
                <div class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-[3rem] p-4 shadow-2xl shadow-indigo-200 transform rotate-3 relative z-10">
                    <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-inner">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Dashboard Preview" class="w-full opacity-90">
                    </div>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-amber-400 rounded-full blur-[80px] opacity-30"></div>
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-indigo-400 rounded-full blur-3xl opacity-20"></div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="fitur" class="py-32 px-6 bg-white relative">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
                <h2 class="text-indigo-600 font-bold uppercase tracking-widest text-sm">Fitur Unggulan</h2>
                <h3 class="text-4xl lg:text-5xl font-bold leading-tight">Solusi Lengkap untuk Manajemen Kehadiran Modern</h3>
                <p class="text-slate-500 font-medium leading-relaxed">Dirancang untuk memenuhi kebutuhan perusahaan dari skala kecil hingga enterprise dengan teknologi terkini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- GPS Tracking -->
                <div class="p-10 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:border-indigo-200 transition-all hover:shadow-2xl hover:shadow-indigo-100 group">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center text-indigo-600 mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Pelacakan GPS Akurat</h4>
                    <p class="text-slate-500 font-medium leading-relaxed">Verifikasi kehadiran berdasarkan lokasi koordinat karyawan secara real-time saat melakukan absensi.</p>
                </div>

                <!-- QR Code -->
                <div class="p-10 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:border-violet-200 transition-all hover:shadow-2xl hover:shadow-violet-100 group">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center text-violet-600 mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01m-4-7h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Absensi QR Code</h4>
                    <p class="text-slate-500 font-medium leading-relaxed">Proses absensi lebih cepat dan higienis dengan sistem scan QR Code unik yang digenerate oleh admin.</p>
                </div>

                <!-- Automated Reports -->
                <div class="p-10 rounded-[2.5rem] bg-slate-50 border border-slate-100 hover:border-emerald-200 transition-all hover:shadow-2xl hover:shadow-emerald-100 group">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center text-emerald-600 mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Laporan PDF & Excel</h4>
                    <p class="text-slate-500 font-medium leading-relaxed">Dapatkan rekap kehadiran bulanan secara otomatis. Export laporan hanya dengan satu klik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="cara-kerja" class="py-32 px-6 bg-slate-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
                <h2 class="text-indigo-600 font-bold uppercase tracking-widest text-sm">Cara Kerja</h2>
                <h3 class="text-4xl lg:text-5xl font-bold leading-tight">Mulai Absensi Digital <br>Hanya dalam 3 Langkah</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                <!-- Step 1 -->
                <div class="relative z-10 text-center space-y-6 group">
                    <div class="w-20 h-20 bg-white rounded-3xl shadow-xl flex items-center justify-center text-3xl font-black text-indigo-600 mx-auto group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                        1
                    </div>
                    <div class="space-y-2">
                        <h4 class="text-xl font-bold text-slate-800">Daftarkan Perusahaan</h4>
                        <p class="text-slate-500 font-medium">Buat akun admin dan tambahkan data karyawan dengan mudah melalui dashboard panel.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 text-center space-y-6 group">
                    <div class="w-20 h-20 bg-white rounded-3xl shadow-xl flex items-center justify-center text-3xl font-black text-indigo-600 mx-auto group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                        2
                    </div>
                    <div class="space-y-2">
                        <h4 class="text-xl font-bold text-slate-800">Generate QR Code</h4>
                        <p class="text-slate-500 font-medium">Admin membuat QR Code unik harian yang dapat dipajang atau dibagikan kepada karyawan.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 text-center space-y-6 group">
                    <div class="w-20 h-20 bg-white rounded-3xl shadow-xl flex items-center justify-center text-3xl font-black text-indigo-600 mx-auto group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                        3
                    </div>
                    <div class="space-y-2">
                        <h4 class="text-xl font-bold text-slate-800">Scan & Selesai</h4>
                        <p class="text-slate-500 font-medium">Karyawan melakukan scan melalui smartphone mereka. Data lokasi & waktu tersimpan otomatis.</p>
                    </div>
                </div>

                <!-- Connector Line (Desktop Only) -->
                <div class="absolute top-10 left-0 w-full h-1 bg-indigo-100 -z-0 hidden md:block rounded-full"></div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-32 px-6 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="bg-slate-900 rounded-[3.5rem] overflow-hidden shadow-3xl flex flex-col lg:flex-row relative">
                <!-- Contact Info -->
                <div class="lg:w-1/3 p-12 lg:p-20 bg-indigo-600 text-white space-y-12 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
                    <div class="relative z-10 space-y-6">
                        <h3 class="text-3xl font-bold">Hubungi Kami</h3>
                        <p class="text-indigo-100 font-medium">Punya pertanyaan atau butuh bantuan integrasi? Tim support kami siap membantu Anda 24/7.</p>
                    </div>

                    <div class="relative z-10 space-y-8">
                        <div class="flex items-center space-x-5">
                            <div class="bg-white/20 p-3 rounded-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-indigo-200 uppercase tracking-widest">Email</p>
                                <p class="font-bold">yogaodiy3334@gmail.com</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-5">
                            <div class="bg-white/20 p-3 rounded-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-indigo-200 uppercase tracking-widest">Telepon</p>
                                <p class="font-bold">082325364176</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:w-2/3 p-12 lg:p-20 text-white space-y-10">
                    <form action="#" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-bold text-slate-400 mb-2 uppercase tracking-widest">Nama Lengkap</label>
                            <input type="text" class="w-full bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder-slate-600" placeholder="Yoga">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-400 mb-2 uppercase tracking-widest">Alamat Email</label>
                            <input type="email" class="w-full bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder-slate-600" placeholder="email@perusahaan.com">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-400 mb-2 uppercase tracking-widest">Pesan Anda</label>
                            <textarea rows="4" class="w-full bg-slate-800 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder-slate-600" placeholder="Tuliskan kebutuhan Anda di sini..."></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="w-full bg-white text-slate-900 font-bold py-5 rounded-2xl hover:bg-slate-100 transition-all shadow-xl">
                                Kirim Pesan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 px-6 bg-slate-50">
        <div class="max-w-7xl mx-auto bg-indigo-600 rounded-[3rem] p-12 lg:p-24 text-center text-white relative overflow-hidden shadow-2xl shadow-indigo-200">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-white/10 rounded-full blur-[80px] -mr-48 -mt-48"></div>
            <div class="relative z-10 space-y-8">
                <h2 class="text-4xl lg:text-6xl font-bold leading-tight">Siap Transformasi Cara<br>Tim Anda Mengelola Absensi?</h2>
                <p class="text-indigo-100 text-lg max-w-xl mx-auto">Bergabunglah dengan ribuan perusahaan yang telah menggunakan Jalupab untuk efisiensi kerja yang lebih baik.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-white text-indigo-600 font-bold px-12 py-5 rounded-[2rem] hover:bg-slate-50 transition-all shadow-xl">Daftar Sekarang</a>
                    <a href="#kontak" class="w-full sm:w-auto border-2 border-white/40 text-white font-bold px-12 py-5 rounded-[2rem] hover:bg-white/10 transition-all">Hubungi Sales</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-6 border-t border-slate-200">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0 text-slate-400 text-sm font-medium">
            <div class="flex items-center space-x-3 grayscale opacity-70">
                <div class="bg-slate-400 p-1 rounded-lg">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <span class="text-lg font-bold text-slate-800">Jalupab</span>
            </div>
            <p>&copy; 2026 Jalupab. Seluruh Hak Cipta Dilindungi.</p>
            <div class="flex items-center space-x-6">
                <a href="#" class="hover:text-indigo-600">Kebijakan Privasi</a>
                <a href="#" class="hover:text-indigo-600">Syarat & Ketentuan</a>
            </div>
        </div>
    </footer>

</body>
</html>
