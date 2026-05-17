<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CV. Pustaka Grafika') - Mitra Mencerdaskan Anak Bangsa</title>
    <meta name="description" content="@yield('meta_description', 'CV. Pustaka Grafika - Produsen percetakan offset dan penyedia buku pelajaran berkualitas sejak 2007.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo/logopg.png') }}" type="image/png">
    @stack('styles')
</head>
<body class="bg-white text-gray-800 font-sans">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo/logopg.png') }}" alt="Pustaka Grafika" class="h-14 w-auto">
                    <div class="hidden sm:block">
                        <div class="font-bold text-blue-900 text-lg leading-tight">CV. Pustaka Grafika</div>
                        <div class="text-xs text-gray-500">Mitra Mencerdaskan Anak Bangsa</div>
                    </div>
                </a>

                {{-- Desktop menu --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="font-semibold text-sm uppercase tracking-wide {{ request()->routeIs('home') ? 'text-orange-500 border-b-2 border-orange-500 pb-1' : 'text-gray-700 hover:text-orange-500 transition-colors' }}">Home</a>
                    <a href="{{ route('katalog.index') }}" class="font-semibold text-sm uppercase tracking-wide {{ request()->routeIs('katalog.*') ? 'text-orange-500 border-b-2 border-orange-500 pb-1' : 'text-gray-700 hover:text-orange-500 transition-colors' }}">Katalog</a>
                    <a href="{{ route('tentang') }}" class="font-semibold text-sm uppercase tracking-wide {{ request()->routeIs('tentang') ? 'text-orange-500 border-b-2 border-orange-500 pb-1' : 'text-gray-700 hover:text-orange-500 transition-colors' }}">Tentang Kami</a>
                    <a href="{{ route('kontak') }}" class="font-semibold text-sm uppercase tracking-wide {{ request()->routeIs('kontak') ? 'text-orange-500 border-b-2 border-orange-500 pb-1' : 'text-gray-700 hover:text-orange-500 transition-colors' }}">Kontak</a>
                </div>

                {{-- Mobile menu button --}}
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md text-gray-700 hover:text-orange-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('home') }}" class="block py-2 font-semibold text-sm uppercase {{ request()->routeIs('home') ? 'text-orange-500' : 'text-gray-700' }}">Home</a>
                <a href="{{ route('katalog.index') }}" class="block py-2 font-semibold text-sm uppercase {{ request()->routeIs('katalog.*') ? 'text-orange-500' : 'text-gray-700' }}">Katalog</a>
                <a href="{{ route('tentang') }}" class="block py-2 font-semibold text-sm uppercase {{ request()->routeIs('tentang') ? 'text-orange-500' : 'text-gray-700' }}">Tentang Kami</a>
                <a href="{{ route('kontak') }}" class="block py-2 font-semibold text-sm uppercase {{ request()->routeIs('kontak') ? 'text-orange-500' : 'text-gray-700' }}">Kontak</a>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 pt-12 pb-6 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-8">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo/logopg.png') }}" alt="Logo" class="h-16 w-auto">
                        <div>
                            <div class="font-bold text-white text-lg">CV. Pustaka Grafika</div>
                            <div class="text-xs text-gray-400 italic">Mitra Mencerdaskan Anak Bangsa</div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Produsen percetakan offset dan penyedia buku pelajaran berkualitas sejak 2007. Melayani instansi pemerintah dan swasta.
                    </p>
                </div>

                {{-- Menu --}}
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wide">Menu</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-orange-400 transition-colors">Home</a></li>
                        <li><a href="{{ route('katalog.index') }}" class="hover:text-orange-400 transition-colors">Katalog Produk</a></li>
                        <li><a href="{{ route('tentang') }}" class="hover:text-orange-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('kontak') }}" class="hover:text-orange-400 transition-colors">Kontak</a></li>
                    </ul>
                </div>

                {{-- Kontak --}}
                <div>
                    <h4 class="text-white font-bold mb-4 text-sm uppercase tracking-wide">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-map-marker-alt mt-1 text-orange-400 w-4 shrink-0"></i>
                            <span>Jl. Puter Utara No.23, Sukun, Kota Malang 65147</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-phone text-orange-400 w-4 shrink-0"></i>
                            <a href="tel:0341321853" class="hover:text-orange-400">(0341) 321853</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fab fa-whatsapp text-orange-400 w-4 shrink-0"></i>
                            <a href="https://wa.me/62811371171" target="_blank" class="hover:text-orange-400">+62 811-3711-171</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-envelope text-orange-400 w-4 shrink-0"></i>
                            <a href="mailto:pustakagrafika7@gmail.com" class="hover:text-orange-400">pustakagrafika7@gmail.com</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-6 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} CV. Pustaka Grafika. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
