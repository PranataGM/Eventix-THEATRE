<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventix THEATRE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
                            beige: '#f4ede6',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .ticket-cutout { position: relative; }
        .ticket-cutout::before, .ticket-cutout::after {
            content: ''; position: absolute; top: 50%; transform: translateY(-50%); width: 24px; height: 24px; background-color: #fbfaf8; border-radius: 50%; z-index: 10;
        }
        .ticket-cutout::before { left: -12px; }
        .ticket-cutout::after { right: -12px; }
    </style>
</head>
<body class="bg-theater-light font-sans text-gray-800 antialiased overflow-x-hidden">
    
    <!-- Hero Section -->
    <div class="relative bg-theater-dark min-h-[85vh] flex flex-col">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1507676184212-d0330a156f88?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover opacity-30 mix-blend-overlay" alt="Theater background">
            <div class="absolute inset-0 bg-gradient-to-b from-theater-dark/80 via-transparent to-theater-dark"></div>
        </div>

        <!-- Navbar -->
        <nav class="relative z-10 container mx-auto px-6 py-6 flex justify-between items-center text-white">
            <a href="/" class="text-3xl font-serif font-bold tracking-tight">Eventix<span class="text-sm block tracking-[0.3em] font-sans font-normal uppercase text-gray-400 mt-1">&bull; THEATRE &bull;</span></a>
            <div class="hidden md:flex items-center space-x-6 text-sm font-medium text-gray-300">
                <a href="#events" class="hover:text-white transition">Acara & Tiket</a>
                
                @auth
                    <a href="{{ route('user.tickets') }}" class="hover:text-white transition">Tiket Saya</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-red-400 transition">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-white transition">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-theater-brown text-white px-4 py-2 rounded-sm hover:bg-[#7a4e35] transition">Daftar</a>
                @endauth
            </div>
        </nav>

        @php
            $featuredEvent = $events->first();
        @endphp

        <!-- Hero Content -->
        <div class="relative z-10 flex-grow flex flex-col items-center justify-center px-4" data-aos="fade-in" data-aos-duration="1500">
            <p class="text-gray-300 tracking-[0.2em] uppercase text-sm mb-2">&bull; Pertunjukan Spesial Bulan Ini &bull;</p>
            <h1 class="text-4xl md:text-6xl font-serif text-white mb-16 text-center">Sorotan Utama</h1>

            @if($featuredEvent)
            <div class="flex flex-col md:flex-row w-full max-w-4xl bg-white rounded-sm shadow-2xl relative">
                <div class="p-8 md:p-12 md:w-3/5 flex flex-col justify-center">
                    <p class="text-gray-500 uppercase tracking-widest text-xs font-bold mb-3">Unggulan</p>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 mb-2">{{ $featuredEvent->name }}</h2>
                    <p class="text-gray-600 text-sm mb-6">{{ Str::limit($featuredEvent->description, 60) }}</p>
                    
                    <div class="flex items-center text-sm font-medium text-gray-600 mb-8 gap-4">
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ $featuredEvent->event_date->format('d M') }}</span>
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $featuredEvent->event_date->format('H:i') }} WIB</span>
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('event.show', $featuredEvent->id) }}" class="bg-theater-brown text-white px-8 py-3 font-semibold text-sm hover:bg-[#7a4e35] transition-colors">Beli Tiket</a>
                        <a href="{{ route('event.show', $featuredEvent->id) }}" class="text-gray-600 text-sm font-medium hover:text-theater-brown transition-colors underline underline-offset-4">Lihat Detail</a>
                    </div>
                </div>
                
                <div class="hidden md:flex flex-col justify-center items-center relative w-8">
                    <div class="absolute inset-y-0 border-l-2 border-dashed border-gray-300 left-1/2 -ml-[1px]"></div>
                    <div class="w-8 h-8 rounded-full bg-theater-dark absolute top-1/2 -translate-y-1/2 shadow-[inset_0_0_10px_rgba(0,0,0,0.5)]"></div>
                </div>

                <div class="md:w-2/5 h-64 md:h-auto p-4 md:p-6 bg-white relative">
                    <img src="https://images.unsplash.com/photo-1585699324551-f6c309eedeca?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover rounded-sm grayscale-[30%] contrast-125" alt="Featured event">
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Events List Section -->
    <div id="events" class="container mx-auto px-4 py-20 max-w-6xl">
        <div class="text-center mb-10" data-aos="fade-up">
            <h2 class="text-4xl font-serif font-bold text-gray-900 mb-4">Acara Mendatang</h2>
            <p class="text-gray-500 max-w-xl mx-auto text-sm">Amankan kursi Anda sekarang dan jadilah bagian dari pertunjukan teater dan musik terbaik tahun ini.</p>
        </div>

        <div class="mb-12" data-aos="fade-up">
            <form action="#events" method="GET" class="flex flex-col md:flex-row gap-4 justify-center items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama acara atau lokasi..." class="w-full md:w-1/2 border border-gray-300 rounded px-6 py-4 focus:outline-none focus:border-theater-brown focus:ring-1 focus:ring-theater-brown transition-colors">
                <button type="submit" class="w-full md:w-auto bg-theater-brown text-white font-bold tracking-wider py-4 px-10 hover:bg-[#7a4e35] transition-colors uppercase text-sm">Cari</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($events as $index => $event)
                <div class="flex flex-col border border-gray-200 bg-white" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    
                    <div class="w-full h-48 bg-gray-200 relative ticket-cutout flex-shrink-0">
                        <img src="https://images.unsplash.com/photo-1585699324551-f6c309eedeca?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover grayscale-[20%]" alt="Event Image">
                        <div class="absolute bottom-0 left-0 right-0 border-b-2 border-dashed border-theater-light/50 hidden md:block" style="margin-bottom: 2px;"></div>
                    </div>

                    <div class="p-8 flex flex-row items-stretch relative">
                        @php
                            $isEventSoldOut = $event->ticketTypes->every(fn($t) => $t->remaining_quota <= 0);
                        @endphp
                        
                        @if($isEventSoldOut)
                            <div class="absolute top-0 right-0 bg-red-600 text-white text-[10px] font-bold px-3 py-1 uppercase tracking-widest -mt-4 mr-8 shadow-md">
                                Habis Terjual
                            </div>
                        @endif

                        <div class="w-24 flex flex-col items-center justify-start border-r border-gray-200 pr-6 mr-6">
                            <span class="text-gray-400 text-sm font-bold uppercase tracking-widest">{{ $event->event_date->translatedFormat('M') }}</span>
                            <span class="text-4xl font-serif font-bold text-gray-900 my-1">{{ $event->event_date->format('d') }}</span>
                            <span class="text-gray-400 text-xs">{{ $event->event_date->format('Y') }}</span>
                            <div class="bg-theater-dark text-white text-[10px] px-2 py-1 font-bold tracking-wider mt-3">
                                {{ $event->event_date->format('H:i') }}
                            </div>
                        </div>

                        <div class="flex-grow flex flex-col justify-between">
                            <div>
                                <p class="text-theater-brown uppercase tracking-widest text-[10px] font-bold mb-1">Pertunjukan</p>
                                <h3 class="text-xl font-serif font-bold text-gray-900 mb-2 leading-tight">{{ $event->name }}</h3>
                                <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $event->description }}</p>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                @if($isEventSoldOut)
                                    <span class="bg-gray-300 text-gray-500 px-5 py-2 font-semibold text-xs cursor-not-allowed">Habis</span>
                                @else
                                    <a href="{{ route('event.show', $event->id) }}" class="bg-theater-brown text-white px-5 py-2 font-semibold text-xs hover:bg-[#7a4e35] transition-colors">Beli Tiket</a>
                                @endif
                                <a href="{{ route('event.show', $event->id) }}" class="text-gray-500 text-xs font-medium hover:text-theater-brown transition-colors underline underline-offset-4">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-10 col-span-2">Belum ada acara yang dijadwalkan.</p>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-theater-dark text-gray-400 py-16">
        <div class="container mx-auto px-6 text-center md:text-left flex flex-col md:flex-row justify-between items-center">
            <div>
                <a href="/" class="text-2xl font-serif font-bold tracking-tight text-white mb-2 block">Eventix<span class="text-xs block tracking-[0.3em] font-sans font-normal uppercase text-gray-400 mt-1">&bull; THEATRE &bull;</span></a>
            </div>
            <p class="text-sm mt-4 md:mt-0">&copy; 2026 Eventix Theatre. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ once: true, offset: 30 });</script>
</body>
</html>
