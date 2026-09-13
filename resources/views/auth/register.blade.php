<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Eventix THEATRE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        theater: {
                            dark: '#1a1818',
                            brown: '#8b5a3e',
                            light: '#fbfaf8',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-theater-light font-sans text-gray-800 antialiased min-h-screen flex flex-col"> 
    @include('partials.toast')

    @include('partials.navbar')

    <!-- Main Content -->
    <div class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="bg-white p-10 rounded-sm border border-gray-200 shadow-sm w-full max-w-md">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-serif font-bold text-gray-900 mb-2">Daftar Akun</h2>
                <p class="text-gray-500 text-sm">Bergabunglah untuk memesan tiket pertunjukan.</p>
            </div>
            
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-sm mb-6 text-sm">{{ $errors->first() }}</div>
            @endif

            <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center bg-white border border-gray-300 text-gray-700 font-medium p-3 rounded-sm hover:bg-gray-50 mb-6 transition-colors shadow-sm">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    <path fill="none" d="M1 1h22v22H1z"/>
                </svg>
                Daftar dengan Google
            </a>

            <div class="flex items-center mb-6">
                <hr class="flex-grow border-gray-200">
                <span class="px-3 text-xs text-gray-400 font-medium uppercase tracking-widest">ATAU EMAIL</span>
                <hr class="flex-grow border-gray-200">
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full border border-gray-300 rounded-sm p-3 focus:outline-none focus:border-theater-brown focus:ring-1 focus:ring-theater-brown transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">Email</label>
                    <input type="email" name="email" required class="w-full border border-gray-300 rounded-sm p-3 focus:outline-none focus:border-theater-brown focus:ring-1 focus:ring-theater-brown transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">Sandi</label>
                    <input type="password" name="password" required class="w-full border border-gray-300 rounded-sm p-3 focus:outline-none focus:border-theater-brown focus:ring-1 focus:ring-theater-brown transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" required class="w-full border border-gray-300 rounded-sm p-3 focus:outline-none focus:border-theater-brown focus:ring-1 focus:ring-theater-brown transition-colors">
                </div>
                <button type="submit" class="w-full bg-theater-brown text-white font-bold tracking-wider py-3 px-4 rounded-sm hover:bg-[#7a4e35] transition-colors mt-2">DAFTAR</button>
            </form>
            <p class="text-center mt-6 text-sm text-gray-600">Sudah punya akun? <a href="{{ route('login') }}" class="text-theater-brown font-semibold hover:underline">Masuk</a></p>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>
