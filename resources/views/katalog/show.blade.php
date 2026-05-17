@extends('layouts.app')

@section('title', $product->judul)

@section('content')

<div class="bg-blue-900 text-white py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-2 text-xs text-blue-400">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a>
            <span>/</span>
            <a href="{{ route('katalog.index') }}" class="hover:text-white">Katalog</a>
            <span>/</span>
            <span class="text-white line-clamp-1">{{ $product->judul }}</span>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

        {{-- Cover --}}
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <img src="{{ $product->cover_url }}" alt="{{ $product->judul }}"
                     class="w-full object-contain max-h-96">
            </div>
        </div>

        {{-- Detail --}}
        <div class="md:col-span-2">
            <div class="flex items-center gap-2 mb-2">
                @if($product->category)
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">{{ $product->category->name }}</span>
                @endif
                @if($product->jenjang)
                <span class="bg-orange-100 text-orange-700 text-xs font-semibold px-2 py-1 rounded">{{ $product->jenjang }}</span>
                @endif
                @if($product->kelas)
                <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded">Kelas {{ $product->kelas }}</span>
                @endif
            </div>

            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">{{ $product->judul }}</h1>

            <table class="text-sm mb-6 w-full max-w-md">
                @if($product->penulis)
                <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-500 w-32">Penulis</td>
                    <td class="py-2 font-medium text-gray-800">{{ $product->penulis }}</td>
                </tr>
                @endif
                @if($product->isbn)
                <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-500">ISBN</td>
                    <td class="py-2 font-medium text-gray-800">{{ $product->isbn }}</td>
                </tr>
                @endif
                @if($product->tahun)
                <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-500">Tahun Terbit</td>
                    <td class="py-2 font-medium text-gray-800">{{ $product->tahun }}</td>
                </tr>
                @endif
                @if($product->jenjang)
                <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-500">Jenjang</td>
                    <td class="py-2 font-medium text-gray-800">{{ $product->jenjang }}</td>
                </tr>
                @endif
                @if($product->kelas)
                <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-500">Kelas</td>
                    <td class="py-2 font-medium text-gray-800">{{ $product->kelas }}</td>
                </tr>
                @endif
                <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-500">Penerbit</td>
                    <td class="py-2 font-medium text-gray-800">CV. Pustaka Grafika</td>
                </tr>
            </table>

            @if($product->deskripsi)
            <div class="mb-6">
                <h3 class="font-bold text-gray-800 mb-2">Deskripsi</h3>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $product->deskripsi }}</p>
            </div>
            @endif

            <div class="flex gap-3 flex-wrap">
                <a href="https://wa.me/62811371171?text=Halo, saya ingin menanyakan tentang buku: {{ urlencode($product->judul) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-5 py-3 rounded-lg transition">
                    <i class="fab fa-whatsapp text-xl"></i> Tanya via WhatsApp
                </a>
                <a href="{{ route('katalog.index') }}"
                   class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold px-5 py-3 rounded-lg transition">
                    <i class="fas fa-arrow-left text-sm"></i> Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count())
    <div class="mt-14">
        <h2 class="text-xl font-bold text-blue-900 mb-6">Produk Terkait</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
            @foreach($related as $rel)
            <a href="{{ route('katalog.show', $rel->id) }}"
               class="bg-white rounded-xl shadow hover:shadow-md overflow-hidden transition hover:-translate-y-1 group">
                <div class="aspect-[3/4] bg-gray-100 overflow-hidden">
                    <img src="{{ $rel->cover_url }}" alt="{{ $rel->judul }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-3">
                    <div class="font-semibold text-gray-800 text-sm line-clamp-2">{{ $rel->judul }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection
