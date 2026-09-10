<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Saya - Eventix THEATRE</title>
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

    <!-- Navbar -->
    <nav class="bg-theater-dark text-white">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-serif font-bold tracking-tight">Eventix<span class="text-[10px] block tracking-[0.3em] font-sans font-normal uppercase text-gray-400 mt-1">&bull; THEATRE &bull;</span></a>
            <div class="flex items-center space-x-6 text-sm font-medium text-gray-300">
                <a href="/" class="hover:text-white transition">Beranda</a>
                @if(auth()->user()->hasRole(['super_admin', 'organizer', 'scanner']))
                    <a href="/admin" class="hover:text-white transition">Admin Dasbor</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-red-400 transition">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-grow container mx-auto px-4 py-12 max-w-5xl">
        <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Tiket Saya</h1>
        <p class="text-gray-500 mb-10">Daftar semua tiket acara yang telah Anda pesan.</p>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($groupedTickets->isEmpty())
            <div class="text-center py-20 bg-white border border-gray-200 rounded-sm">
                <p class="text-gray-500 mb-4">Anda belum memiliki tiket.</p>
                <a href="/" class="text-theater-brown font-bold hover:underline">Cari Acara</a>
            </div>
        @else
            <div class="space-y-8">
                @foreach($groupedTickets as $orderNumber => $tickets)
                    @php
                        $firstTicket = $tickets->first();
                        $totalTickets = $tickets->count();
                        $status = $firstTicket->status;
                    @endphp
                    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden rounded-sm">
                        
                        <!-- Order Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Pesanan #{{ $orderNumber }}</p>
                                <h2 class="text-xl font-serif font-bold text-gray-900">{{ $firstTicket->event->name }}</h2>
                                <p class="text-sm text-gray-600">{{ $firstTicket->event->event_date->format('d M Y, H:i') }} WIB &bull; {{ $firstTicket->event->location }}</p>
                            </div>
                            <div class="text-right flex flex-col items-end">
                                @if($status === 'confirmed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Pembayaran Berhasil
                                    </span>
                                @elseif($status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Menunggu Pembayaran
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ ucfirst($status) }}
                                    </span>
                                @endif
                                <p class="text-sm mt-2 text-gray-600 font-medium">{{ $totalTickets }} Tiket</p>
                            </div>
                        </div>

                        <!-- Ticket List -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($tickets as $ticket)
                                    <div class="border border-gray-200 rounded p-4 flex flex-col relative">
                                        <!-- Decorative ticket holes -->
                                        <div class="absolute left-0 top-1/2 -translate-y-1/2 -ml-2 w-4 h-4 bg-white border-r border-gray-200 rounded-full"></div>
                                        <div class="absolute right-0 top-1/2 -translate-y-1/2 -mr-2 w-4 h-4 bg-white border-l border-gray-200 rounded-full"></div>
                                        
                                        <div class="border-b border-dashed border-gray-300 pb-3 mb-3 text-center">
                                            <p class="text-xs text-theater-brown font-bold uppercase tracking-widest">{{ $ticket->ticketType->name }}</p>
                                            <p class="text-lg font-bold font-serif text-gray-900 mt-1">{{ $ticket->ticket_code }}</p>
                                        </div>
                                        
                                        <div class="flex-grow flex items-center justify-center">
                                            @if($ticket->status === 'confirmed')
                                                <!-- Generate QR Code using Google Charts API for simplicity, or local base64 if preferred -->
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $ticket->ticket_code }}" alt="QR Code {{ $ticket->ticket_code }}" class="w-24 h-24">
                                            @else
                                                <div class="w-24 h-24 bg-gray-100 flex items-center justify-center text-center text-xs text-gray-400 p-2 rounded">
                                                    QR Code tersedia setelah lunas
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-4 pt-3 border-t border-gray-100 text-center">
                                            @if($ticket->status === 'confirmed')
                                                <a href="{{ route('ticket.download', $ticket->id) }}" class="text-sm text-theater-brown font-semibold hover:underline">Unduh PDF</a>
                                            @else
                                                <span class="text-sm text-gray-400">Menunggu</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-theater-dark text-gray-400 py-8 mt-auto">
        <div class="container mx-auto px-6 text-center">
            <p class="text-sm">&copy; 2026 Eventix Theatre. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>
