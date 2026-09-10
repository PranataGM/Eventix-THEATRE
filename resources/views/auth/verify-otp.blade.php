<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Eventix</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Verifikasi OTP</h2>
        
        @if(session('success'))
            <div class="bg-blue-100 text-blue-700 p-4 rounded mb-4 text-sm font-bold border-l-4 border-blue-500">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('verify-otp') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Kode OTP</label>
                <input type="text" name="otp" required class="w-full border rounded p-2 focus:ring focus:border-indigo-300 text-center tracking-widest text-lg font-bold" placeholder="123456">
            </div>
            <button type="submit" class="w-full bg-[#8b5a3e] text-white p-2 rounded hover:bg-[#7a4e35]">Verifikasi</button>
        </form>
    </div>
</body>
</html>
