<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Attendance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
            <div class="text-center mb-10">
                <div class="bg-indigo-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-900">Selamat Datang</h1>
                <p class="text-slate-500 mt-2">Silakan masuk ke akun Anda</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                {{ $errors->first() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" required class="w-full px-5 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all outline-none text-slate-900" placeholder="nama@perusahaan.com">
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                        <a href="#" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Lupa sandi?</a>
                    </div>
                    <input type="password" name="password" required class="w-full px-5 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all outline-none text-slate-900" placeholder="••••••••">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="remember" class="w-5 h-5 rounded border-slate-300 transform transition-transform duration-200 checked:scale-110">
                    <label for="remember" class="ml-3 text-sm text-slate-600">Ingat saya</label>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-100 transform transition hover:-translate-y-0.5 active:translate-y-0">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-10 pt-10 border-t border-slate-100 text-center">
                <p class="text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline underline-offset-4">Daftar gratis</a></p>
            </div>
        </div>
        <p class="text-center text-slate-400 mt-8 text-sm">© 2026 Online Attendance System. Built with Passion.</p>
    </div>
</body>
</html>
