<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Sandi - Eventix</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen"> 
    @include('partials.toast')
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Buat Sandi Baru</h2>
        
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('reset-password') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Sandi Baru</label>
                <input type="password" name="password" required class="w-full border rounded p-2 focus:ring focus:border-indigo-300">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Konfirmasi Sandi Baru</label>
                <input type="password" name="password_confirmation" required class="w-full border rounded p-2 focus:ring focus:border-indigo-300">
            </div>
            <button type="submit" class="w-full bg-[#8b5a3e] text-white p-2 rounded hover:bg-[#7a4e35]">Simpan Sandi Baru</button>
        </form>
    </div>
</body>
</html>
