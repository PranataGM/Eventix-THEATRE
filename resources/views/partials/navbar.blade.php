@inject('categories', 'App\Models\Category')
@php
    $cats = $categories->all();
    $mainCats = $cats->take(3);
    $moreCats = $cats->skip(3);
@endphp
<nav class="bg-theater-dark/95 backdrop-blur-md text-white shadow-lg sticky top-0 z-50 border-b border-white/10 transition-all duration-300">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center gap-4">
        <!-- Logo (Kiri) -->
        <a href="/" class="text-2xl font-serif font-bold tracking-tight hover:scale-105 active:scale-95 transition-transform duration-200 shrink-0 w-1/4">
            Eventix<span class="text-[10px] block tracking-[0.3em] font-sans font-normal uppercase text-gray-400 mt-1">&bull; THEATRE &bull;</span>
        </a>
        
        <!-- Menu (Tengah) -->
        <div class="hidden md:flex flex-grow justify-center items-center space-x-6 lg:space-x-8 text-sm font-medium text-gray-300 w-2/4">
            <a href="/" class="relative hover:text-white active:scale-95 transition-all duration-200 after:content-[''] after:absolute after:w-0 after:h-0.5 after:bg-theater-brown after:left-0 after:-bottom-1 hover:after:w-full after:transition-all after:duration-300">Beranda</a>
            
            @foreach($mainCats as $cat)
                <a href="/?category={{ $cat->slug }}" class="relative hover:text-white active:scale-95 transition-all duration-200 after:content-[''] after:absolute after:w-0 after:h-0.5 after:bg-theater-brown after:left-0 after:-bottom-1 hover:after:w-full after:transition-all after:duration-300">{{ $cat->name }}</a>
            @endforeach
            
            @if($moreCats->count() > 0)
            <!-- Category Dropdown -->
            <div class="relative group">
                <button class="relative hover:text-white transition-all duration-200 flex items-center gap-1 focus:outline-none">
                    Lainnya
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div class="absolute top-full left-1/2 -translate-x-1/2 mt-4 w-48 bg-theater-dark border border-white/10 rounded-lg shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:mt-2 transition-all duration-300">
                    <a href="/" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white">Semua Kategori</a>
                    @foreach($moreCats as $cat)
                        <a href="/?category={{ $cat->slug }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            @auth
                @if(auth()->user()->hasRole(['super_admin', 'organizer', 'scanner']))
                    <a href="/admin" class="text-theater-brown font-semibold hover:text-[#7a4e35] active:scale-95 transition-all duration-200 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>
                        Admin Dasbor
                    </a>
                @else
                    <a href="{{ route('user.tickets') }}" class="relative hover:text-white active:scale-95 transition-all duration-200 after:content-[''] after:absolute after:w-0 after:h-0.5 after:bg-theater-brown after:left-0 after:-bottom-1 hover:after:w-full after:transition-all after:duration-300">Tiket Saya</a>
                @endif
            @endauth
        </div>

        <!-- Search & Auth (Kanan) -->
        <div class="hidden md:flex items-center justify-end space-x-4 shrink-0 w-1/4">
            <!-- Search Bar -->
            <form action="/" method="GET" class="relative group">
                <div class="flex items-center bg-white/10 rounded-full px-4 py-2 border border-white/10 focus-within:border-theater-brown transition-all duration-300 w-48 focus-within:w-64">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="bg-transparent border-none outline-none text-white text-sm w-full placeholder-gray-400 focus:ring-0 p-0">
                </div>
            </form>

            @auth
                <a href="{{ route('profile.edit') }}" class="bg-theater-brown text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-[#7a4e35] hover:shadow-lg active:scale-90 transition-all duration-200 border border-transparent hover:border-white/20">Profil</a>
            @else
                <a href="{{ route('register') }}" class="bg-theater-brown text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-[#7a4e35] hover:shadow-lg active:scale-90 transition-all duration-200 border border-transparent hover:border-white/20">Daftar</a>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden flex items-center justify-end flex-grow">
            <!-- Mobile Search Icon (Opsional) -->
            <form action="/" method="GET" class="mr-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="bg-white/10 rounded-full px-3 py-1 text-xs text-white border border-white/10 w-24">
            </form>
            @auth
                <a href="{{ route('profile.edit') }}" class="text-theater-brown font-bold text-sm">Profil</a>
            @else
                <a href="{{ route('register') }}" class="text-theater-brown font-bold text-sm">Daftar</a>
            @endauth
        </div>
    </div>
</nav>
