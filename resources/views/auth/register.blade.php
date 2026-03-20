<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Online Attendance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-indigo-50 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10 border border-indigo-100">
            <div class="text-center mb-8">
                <div class="bg-indigo-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-900">Buat Akun Baru</h1>
                <p class="text-slate-500 mt-2">Mulai kelola absensi Anda hari ini</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-5 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all outline-none text-slate-900 @error('name') border-red-500 @enderror" placeholder="John Doe">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                    <input type="email" name="email" required class="w-full px-5 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all outline-none text-slate-900 @error('email') border-red-500 @enderror" placeholder="john@example.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full px-5 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all outline-none text-slate-900 @error('password') border-red-500 @enderror" placeholder="••••••••">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" required class="w-full px-5 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all outline-none text-slate-900" placeholder="••••••••">
                </div>
                
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-100 transform transition hover:-translate-y-0.5 active:translate-y-0 mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-slate-100 text-center">
                <p class="text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline underline-offset-4">Masuk</a></p>
            </div>
        </div>
    </div>
</body>
</html>
