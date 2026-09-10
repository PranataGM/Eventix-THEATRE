<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }} - Eventix THEATRE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['Playfair Display', 'serif'] },
                    colors: { theater: { dark: '#1a1818', brown: '#8b5a3e', light: '#fbfaf8' } }
                }
            }
        }
    </script>
</head>
<body class="bg-theater-light font-sans text-gray-800 antialiased">
    
    <nav class="bg-theater-dark container-fluid px-6 py-4 flex justify-between items-center text-white">
        <a href="/" class="text-xl font-serif font-bold tracking-tight">Eventix<span class="text-[10px] ml-2 tracking-[0.2em] font-sans font-normal uppercase text-gray-400">&bull; THEATRE &bull;</span></a>
        <a href="/" class="text-sm font-medium text-gray-300 hover:text-white transition">&larr; Kembali ke Daftar Acara</a>
    </nav>

    <div class="bg-theater-dark text-white pt-16 pb-24 border-t border-gray-800" data-aos="fade-in">
        <div class="container mx-auto px-4 max-w-4xl text-center">
            <p class="text-theater-brown tracking-[0.2em] uppercase text-xs font-bold mb-4">Pertunjukan</p>
            <h1 class="text-4xl md:text-5xl font-serif font-bold mb-6 leading-tight">{{ $event->name }}</h1>
            
            <div class="flex flex-wrap justify-center gap-8 text-gray-300 text-sm font-medium">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-theater-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $event->event_date->translatedFormat('l, d F Y - H:i') }} WIB
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-theater-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $event->location }}
                </span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 -mt-12 relative z-10 pb-20">
        <div class="flex flex-col lg:flex-row gap-10 max-w-5xl mx-auto">
            
            <div class="lg:w-7/12" data-aos="fade-up">
                <div class="bg-white rounded-sm shadow-xl p-8 md:p-10">
                    <h3 class="text-2xl font-serif font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Deskripsi Acara</h3>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                    
                    <div class="mt-10 border-t border-gray-100 pt-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 font-serif font-bold text-xl">
                            {{ substr($event->organizer->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">Diselenggarakan Oleh</p>
                            <p class="text-base font-bold text-gray-900">{{ $event->organizer->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-5/12" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-sm shadow-xl p-8 md:p-10 sticky top-8">
                    <h3 class="text-2xl font-serif font-bold text-gray-900 mb-6">Pesan Tiket</h3>
                    
                    @if(session('success'))
                        <div class="bg-green-50 text-green-700 p-4 rounded text-sm mb-6 border-l-4 border-green-500">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 text-red-700 p-4 rounded text-sm mb-6 border-l-4 border-red-500">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('event.register', $event->id) }}" method="POST" class="space-y-5">
                        @csrf
                        
                        @guest
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full border border-gray-200 bg-gray-50 px-4 py-3 focus:outline-none focus:border-theater-brown focus:ring-1 focus:ring-theater-brown transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Email</label>
                            <input type="email" name="email" required class="w-full border border-gray-200 bg-gray-50 px-4 py-3 focus:outline-none focus:border-theater-brown focus:ring-1 focus:ring-theater-brown transition-colors">
                        </div>
                        @else
                        <div class="bg-gray-50 p-4 border border-gray-200 mb-4 rounded-sm">
                            <p class="text-sm text-gray-500">Mendaftar sebagai:</p>
                            <p class="font-bold text-gray-900">{{ auth()->user()->name }} ({{ auth()->user()->email }})</p>
                            <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                        </div>
                        @endguest

                        <div class="pt-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Pilih Jenis Tiket</label>
                            <div class="space-y-3">
                                @foreach($event->ticketTypes as $index => $ticket)
                                    @php 
                                        $remaining = $ticket->remaining_quota;
                                        $isSoldOut = $remaining <= 0;
                                    @endphp
                                    <label class="flex items-center justify-between p-4 border transition-colors <?php echo $isSoldOut ? 'bg-gray-100 border-gray-200 cursor-not-allowed opacity-60' : ($index === 0 && !$isSoldOut ? 'bg-orange-50/50 border-theater-brown cursor-pointer' : 'bg-white border-gray-200 cursor-pointer hover:bg-orange-50/50'); ?>" 
                                           @if(!$isSoldOut)
                                           onclick="document.querySelectorAll('.ticket-label').forEach(el => { if(!el.classList.contains('cursor-not-allowed')) el.className='flex items-center justify-between p-4 border cursor-pointer hover:bg-orange-50/50 transition-colors bg-white border-gray-200 ticket-label' }); this.className='flex items-center justify-between p-4 border cursor-pointer hover:bg-orange-50/50 transition-colors bg-orange-50/50 border-theater-brown ticket-label';"
                                           @endif
                                    >
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="ticket_type_id" value="{{ $ticket->id }}" class="w-4 h-4 text-theater-brown focus:ring-theater-brown" {{ ($index === 0 && !$isSoldOut) ? 'checked' : '' }} {{ $isSoldOut ? 'disabled' : '' }}>
                                            <div>
                                                <span class="font-bold text-gray-900 block">{{ $ticket->name }}</span>
                                                @if($isSoldOut)
                                                    <span class="text-xs text-red-500 font-bold uppercase tracking-wider">Habis Terjual</span>
                                                @else
                                                    <span class="text-xs text-gray-500">Tersisa: {{ $remaining }} tiket</span>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="text-theater-brown font-bold text-sm">
                                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jumlah Tiket</label>
                            <input type="number" name="quantity" min="1" max="10" value="1" required class="w-full border border-gray-200 bg-gray-50 px-4 py-3 focus:outline-none focus:border-theater-brown focus:ring-1 focus:ring-theater-brown transition-colors">
                            <p class="text-xs text-gray-400 mt-2">Maksimal 10 tiket per transaksi.</p>
                        </div>

                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mt-4">
                            <p class="text-xs font-bold text-red-700 uppercase tracking-wider mb-1">Perhatian</p>
                            <p class="text-xs text-red-600">Tiket yang sudah dibeli dan dibayar tidak dapat dibatalkan atau di-refund dengan alasan apa pun.</p>
                        </div>

                        @php
                            $allSoldOut = $event->ticketTypes->every(fn($t) => $t->remaining_quota <= 0);
                        @endphp

                        <button type="submit" class="w-full font-bold tracking-wider py-4 px-4 transition-colors mt-6 uppercase text-sm {{ $allSoldOut ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-theater-brown text-white hover:bg-[#7a4e35]' }}" {{ $allSoldOut ? 'disabled' : '' }}>
                            {{ $allSoldOut ? 'Semua Tiket Habis' : 'Bayar dengan Midtrans' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ once: true, offset: 50 });</script>
</body>
</html>
