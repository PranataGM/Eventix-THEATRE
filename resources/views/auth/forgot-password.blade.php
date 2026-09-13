<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Sandi - Eventix</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen"> 
    @include('partials.toast')
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Lupa Sandi</h2>
        <p class="text-sm text-gray-600 text-center mb-4">Masukkan email Anda untuk menerima kode OTP.</p>
        
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('forgot-password') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" required class="w-full border rounded p-2 focus:ring focus:border-indigo-300">
            </div>
            <button type="submit" class="w-full bg-[#8b5a3e] text-white p-2 rounded hover:bg-[#7a4e35]">Kirim OTP</button>
        </form>
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:underline">Kembali ke halaman masuk</a>
        </div>
    </div>
</body>
</html>
