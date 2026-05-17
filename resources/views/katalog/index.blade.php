@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')

{{-- Page Header --}}
<div class="bg-blue-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2">Katalog Produk</h1>
        <p class="text-blue-300 text-sm">Temukan buku pelajaran berkualitas untuk semua jenjang pendidikan</p>
        <div class="flex items-center gap-2 text-xs text-blue-400 mt-3">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a>
            <span>/</span>
            <span class="text-white">Katalog</span>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Sidebar Filter --}}
        <aside class="lg:w-64 shrink-0">
            <form method="GET" action="{{ route('katalog.index') }}" id="filter-form">
                {{-- Search --}}
                <div class="bg-white rounded-xl shadow p-5 mb-4">
                    <h3 class="font-bold text-gray-800 mb-3 text-sm uppercase tracking-wide">Cari Buku</h3>
                    <div class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Judul buku..."
                               class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <button type="submit" class="bg-blue-900 text-white px-3 py-2 rounded-lg hover:bg-blue-800 transition">
                            <i class="fas fa-search text-sm"></i>
                        </button>
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="bg-white rounded-xl shadow p-5 mb-4">
                    <h3 class="font-bold text-gray-800 mb-3 text-sm uppercase tracking-wide">Kategori</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="kategori" value="" {{ !request('kategori') ? 'checked' : '' }} class="text-blue-900" onchange="this.form.submit()">
                            <span class="text-sm text-gray-700">Semua Kategori</span>
                        </label>
                        @foreach($categories as $cat)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="kategori" value="{{ $cat->slug }}"
                                   {{ request('kategori') === $cat->slug ? 'checked' : '' }}
                                   class="text-blue-900" onchange="this.form.submit()">
                            <span class="text-sm text-gray-700">{{ $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Jenjang --}}
                <div class="bg-white rounded-xl shadow p-5">
                    <h3 class="font-bold text-gray-800 mb-3 text-sm uppercase tracking-wide">Jenjang</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenjang" value="" {{ !request('jenjang') ? 'checked' : '' }} onchange="this.form.submit()">
                            <span class="text-sm text-gray-700">Semua Jenjang</span>
                        </label>
                        @foreach(['SD', 'SMP', 'SMA', 'SMK', 'Umum'] as $j)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenjang" value="{{ $j }}"
                                   {{ request('jenjang') === $j ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <span class="text-sm text-gray-700">{{ $j }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                @if(request()->hasAny(['search', 'kategori', 'jenjang']))
                <a href="{{ route('katalog.index') }}" class="block text-center mt-4 text-sm text-orange-500 hover:underline">
                    <i class="fas fa-times-circle"></i> Reset Filter
                </a>
                @endif
            </form>
        </aside>

        {{-- Product Grid --}}
        <div class="flex-1">
            <div class="flex items-center justify-between mb-5">
                <p class="text-sm text-gray-500">
                    Menampilkan <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong>
                    dari <strong>{{ $products->total() }}</strong> produk
                </p>
            </div>

            @if($products->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
                @foreach($products as $product)
                <a href="{{ route('katalog.show', $product->id) }}"
                   class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden transition hover:-translate-y-1 group">
                    <div class="aspect-[3/4] bg-gray-100 overflow-hidden">
                        <img src="{{ $product->cover_url }}" alt="{{ $product->judul }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-3">
                        <div class="text-xs text-orange-500 font-semibold mb-1">
                            {{ $product->category?->name ?? 'Umum' }}
                            @if($product->jenjang) · {{ $product->jenjang }}@endif
                            @if($product->kelas) Kelas {{ $product->kelas }}@endif
                        </div>
                        <div class="font-semibold text-gray-800 text-sm leading-tight line-clamp-2 mb-1">{{ $product->judul }}</div>
                        @if($product->penulis)
                        <div class="text-xs text-gray-400">{{ $product->penulis }}</div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $products->links() }}
            </div>

            @else
            <div class="text-center py-20">
                <i class="fas fa-search text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 font-medium">Tidak ada produk yang ditemukan.</p>
                <a href="{{ route('katalog.index') }}" class="text-sm text-orange-500 hover:underline mt-2 inline-block">Lihat semua produk</a>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
