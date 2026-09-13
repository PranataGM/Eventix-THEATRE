<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Eventix THEATRE</title>
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
    <div class="flex-grow container mx-auto py-12 px-4">
        <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] w-full max-w-6xl mx-auto overflow-hidden border border-gray-100 flex flex-col lg:flex-row">
            
            <!-- Left Side: Profile Form -->
            <div class="w-full lg:w-5/12 p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-gray-100 relative">
                
                <h2 class="text-3xl font-serif font-bold text-gray-900 mb-8">Pengaturan Akun</h2>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Avatar Selection -->
                    <div class="space-y-3">
                        <label class="block text-xs font-bold tracking-wider text-gray-700 uppercase">Foto Profil (Avatar)</label>
                        @php
                            $avatars = [
                                'https://api.dicebear.com/7.x/notionists/svg?seed=Felix&backgroundColor=f4ede6',
                                'https://api.dicebear.com/7.x/notionists/svg?seed=Aneka&backgroundColor=fbfaf8',
                                'https://api.dicebear.com/7.x/notionists/svg?seed=Mimi&backgroundColor=e2e8f0',
                                'https://api.dicebear.com/7.x/notionists/svg?seed=Jack&backgroundColor=fed7aa',
                            ];
                            $currentAvatar = $user->avatar ?: 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=8b5a3e&color=fff';
                        @endphp
                        
                        <div class="flex items-center gap-6 mb-4">
                            <img src="{{ $currentAvatar }}" alt="Current Avatar" class="w-20 h-20 rounded-full border-4 border-theater-light shadow-md object-cover">
                            <p class="text-xs text-gray-500 max-w-[200px]">Pilih salah satu avatar di bawah ini untuk memperbarui foto profil Anda.</p>
                        </div>

                        <div class="flex gap-4">
                            @foreach($avatars as $avatar)
                            <label class="cursor-pointer relative">
                                <input type="radio" name="avatar" value="{{ $avatar }}" class="peer sr-only" {{ $user->avatar == $avatar ? 'checked' : '' }}>
                                <img src="{{ $avatar }}" class="w-14 h-14 rounded-full border-2 border-transparent peer-checked:border-theater-brown peer-checked:ring-2 peer-checked:ring-theater-brown/30 transition-all hover:scale-105" alt="Avatar option">
                                <div class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Email (Read Only) -->
                    <div class="space-y-1">
                        <label class="block text-xs font-bold tracking-wider text-gray-500 uppercase">Alamat Email (Read-Only)</label>
                        <div class="flex items-center bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-500">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $user->email }}
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="space-y-1">
                        <label class="block text-xs font-bold tracking-wider text-gray-700 uppercase">Nama Tampilan</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-theater-brown focus:ring-2 focus:ring-theater-brown/20 transition-all">
                        <p class="text-[10px] text-gray-400 mt-1">* Anda hanya dapat mengubah nama 1 kali dalam 24 jam.</p>
                    </div>

                    <!-- Phone -->
                    <div class="space-y-1">
                        <label class="block text-xs font-bold tracking-wider text-gray-700 uppercase">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-theater-brown focus:ring-2 focus:ring-theater-brown/20 transition-all">
                    </div>

                    <!-- Bio -->
                    <div class="space-y-1">
                        <label class="block text-xs font-bold tracking-wider text-gray-700 uppercase">Bio Singkat</label>
                        <textarea name="bio" rows="3" maxlength="255" placeholder="Ceritakan sedikit tentang Anda..." class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-theater-brown focus:ring-2 focus:ring-theater-brown/20 transition-all">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-theater-brown text-white font-bold tracking-wider py-4 px-4 rounded-lg hover:bg-[#7a4e35] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        SIMPAN PROFIL
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center text-red-500 font-bold tracking-wider py-3 px-4 rounded-lg hover:bg-red-50 transition-colors uppercase text-sm group">
                            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar dari Akun
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side: Order History -->
            <div class="w-full lg:w-7/12 bg-gray-50/50 p-8 lg:p-10">
                <h3 class="text-2xl font-serif font-bold text-gray-900 mb-2">Riwayat Pesanan</h3>
                <p class="text-sm text-gray-500 mb-8">Pantau status tiket dan transaksi Anda di sini.</p>

                <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($registrations as $reg)
                        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <!-- Status Indicator Line -->
                            @php
                                $statusColor = match($reg->payment_status) {
                                    'paid' => 'bg-green-500',
                                    'pending' => 'bg-yellow-400',
                                    'failed', 'cancelled' => 'bg-red-500',
                                    default => 'bg-gray-400'
                                };
                                $statusText = match($reg->payment_status) {
                                    'paid' => 'Selesai',
                                    'pending' => 'Menunggu Pembayaran',
                                    'failed' => 'Gagal',
                                    'cancelled' => 'Dibatalkan',
                                    default => 'Menunggu'
                                };
                            @endphp
                            <div class="absolute top-0 left-0 bottom-0 w-1 {{ $statusColor }}"></div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div class="pl-2">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ $reg->order_number ?? 'ORD-'.$reg->id }}</span>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold text-white {{ $statusColor }} uppercase tracking-wider">{{ $statusText }}</span>
                                    </div>
                                    <h4 class="font-serif font-bold text-lg text-gray-900 leading-tight mb-1">{{ $reg->event->name }}</h4>
                                    <div class="text-sm text-gray-600 flex flex-wrap gap-x-4 gap-y-1">
                                        <span class="flex items-center gap-1"><svg class="w-4 h-4 text-theater-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ $reg->event->event_date->format('d M Y') }}</span>
                                        <span class="flex items-center gap-1"><svg class="w-4 h-4 text-theater-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg> {{ $reg->ticketType->name }} (x{{ $reg->quantity }})</span>
                                    </div>
                                </div>
                                <div class="text-left sm:text-right pl-2 sm:pl-0 w-full sm:w-auto">
                                    <p class="text-xs text-gray-500 mb-1">Total Pembayaran</p>
                                    <p class="font-bold text-theater-brown text-lg">Rp {{ number_format($reg->total_price, 0, ',', '.') }}</p>
                                    
                                    @if($reg->payment_status === 'paid')
                                        <a href="{{ route('ticket.download', $reg->id) }}" class="mt-2 inline-flex items-center text-xs font-bold text-gray-600 hover:text-theater-brown transition-colors group-hover:underline">
                                            Unduh E-Tiket <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-xl border border-gray-200 border-dashed">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            <p class="text-gray-500 font-medium">Belum ada pesanan tiket.</p>
                            <a href="/" class="mt-2 inline-block text-theater-brown text-sm font-bold hover:underline">Cari Acara Sekarang</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background-color: #d1d5db; }
    </style>

    @include('partials.footer')

</body>
</html>
