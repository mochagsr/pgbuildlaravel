<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Pustaka Grafika</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo/logopg.png') }}" type="image/png">
</head>
<body class="bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-64 bg-blue-900 text-white flex flex-col shrink-0" id="sidebar">
        <div class="flex items-center gap-3 px-5 py-5 border-b border-blue-800">
            <img src="{{ asset('images/logo/logopg.png') }}" alt="Logo" class="h-10 w-auto">
            <div>
                <div class="font-bold text-sm leading-tight">Pustaka Grafika</div>
                <div class="text-xs text-blue-300">Admin Panel</div>
            </div>
        </div>

        <nav class="flex-1 py-6 px-4 overflow-y-auto">
            <div class="text-xs text-blue-400 uppercase tracking-wide mb-3 px-2">Menu Utama</div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt w-4"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.produk.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs('admin.produk.*') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800 hover:text-white' }}">
                        <i class="fas fa-book w-4"></i> Kelola Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.tentang.edit') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs('admin.tentang.*') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800 hover:text-white' }}">
                        <i class="fas fa-info-circle w-4"></i> Halaman Tentang
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.kategori.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800 hover:text-white' }}">
                        <i class="fas fa-tags w-4"></i> Kelola Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.jenjang.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs('admin.jenjang.*') ? 'bg-blue-800 text-white' : 'text-blue-200 hover:bg-blue-800 hover:text-white' }}">
                        <i class="fas fa-layer-group w-4"></i> Kelola Jenjang
                    </a>
                </li>
            </ul>

            <div class="text-xs text-blue-400 uppercase tracking-wide mb-3 px-2 mt-6">Website</div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('home') }}" target="_blank"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-blue-200 hover:bg-blue-800 hover:text-white transition">
                        <i class="fas fa-external-link-alt w-4"></i> Lihat Website
                    </a>
                </li>
            </ul>
        </nav>

        <div class="px-4 py-4 border-t border-blue-800">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-sm font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-blue-400">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 text-xs text-blue-300 hover:text-white transition px-2 py-1">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shrink-0">
            <div>
                <h1 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs text-gray-400">@yield('page-subtitle', '')</p>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->format('d F Y') }}
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="fas fa-check-circle text-green-500"></i>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
