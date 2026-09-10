<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Eventix</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Masuk ke Eventix</h2>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" required class="w-full border rounded p-2 focus:ring focus:border-indigo-300">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Sandi</label>
                <input type="password" name="password" required class="w-full border rounded p-2 focus:ring focus:border-indigo-300">
            </div>
            <div class="flex justify-between items-center text-sm">
                <a href="{{ route('forgot-password') }}" class="text-indigo-600 hover:underline">Lupa Sandi?</a>
            </div>
            <button type="submit" class="w-full bg-[#8b5a3e] text-white p-2 rounded hover:bg-[#7a4e35]">Masuk</button>
        </form>
        <p class="text-center mt-4 text-sm text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar</a></p>
    </div>
</body>
</html>
