@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
    .hero-slide { display: none; }
    .hero-slide.active { display: flex; }
</style>
@endpush

@section('content')

{{-- Hero Section: Split Layout --}}
<div class="bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 relative overflow-hidden">
    {{-- Slides --}}
    <div id="hero-wrapper">
        @php $banners = ['banner1.webp','banner2.webp','banner3.webp']; @endphp
        @foreach($banners as $i => $banner)
        <div class="hero-slide {{ $i === 0 ? 'active' : '' }} flex-col md:flex-row items-center max-w-7xl mx-auto px-6 py-10 md:py-6 gap-6">
            {{-- Teks kiri --}}
            <div class="flex-1 text-white text-center md:text-left">
                <div class="text-xs font-semibold text-orange-400 uppercase tracking-widest mb-3">CV. Pustaka Grafika</div>
                <h1 class="text-3xl md:text-4xl font-bold leading-tight mb-4">
                    Mitra Mencerdaskan<br>Anak Bangsa
                </h1>
                <p class="text-blue-200 text-sm md:text-base mb-6 leading-relaxed">
                    Produsen percetakan offset dan penyedia buku pelajaran berkualitas. Melayani SD, SMP, SMA/SMK sejak 2007.
                </p>
                <div class="flex gap-3 justify-center md:justify-start flex-wrap">
                    <a href="{{ route('katalog.index') }}"
                       class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-lg transition text-sm">
                        Lihat Katalog
                    </a>
                    <a href="https://wa.me/62811371171" target="_blank"
                       class="border border-white/40 hover:bg-white/10 text-white font-semibold px-6 py-2.5 rounded-lg transition text-sm flex items-center gap-2">
                        <i class="fab fa-whatsapp text-green-400"></i> WhatsApp
                    </a>
                </div>
            </div>
            {{-- Gambar kanan --}}
            <div class="w-full md:w-auto md:max-w-sm lg:max-w-md shrink-0">
                <img src="{{ asset('images/banner/' . $banner) }}" alt="Banner {{ $i+1 }}"
                     class="w-full h-auto rounded-xl shadow-2xl">
            </div>
        </div>
        @endforeach
    </div>

    {{-- Dots --}}
    <div class="flex justify-center gap-2 pb-5">
        @foreach($banners as $i => $b)
        <button onclick="goHero({{ $i }})"
                class="hero-dot w-2.5 h-2.5 rounded-full transition {{ $i === 0 ? 'bg-orange-400' : 'bg-white/40' }}"
                data-index="{{ $i }}"></button>
        @endforeach
    </div>
</div>

{{-- Tagline Banner --}}
<div class="bg-blue-900 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-2">Mitra Mencerdaskan Anak Bangsa</h2>
        <p class="text-blue-200 text-sm md:text-base">Produsen percetakan offset dan penyedia buku pelajaran berkualitas sejak 2007</p>
    </div>
</div>

{{-- Kategori Section --}}
@if($categories->count())
<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-blue-900 mb-2">Kategori Produk</h2>
            <div class="w-16 h-1 bg-orange-500 mx-auto"></div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($categories as $cat)
            <a href="{{ route('katalog.index', ['kategori' => $cat->slug]) }}"
               class="bg-white rounded-xl shadow hover:shadow-md p-5 text-center transition hover:-translate-y-1 group">
                <div class="text-3xl mb-3">{{ $cat->icon ?: '📚' }}</div>
                <div class="font-semibold text-gray-800 text-sm group-hover:text-orange-500 transition">{{ $cat->name }}</div>
                <div class="text-xs text-gray-400 mt-1">{{ $cat->products_count }} buku</div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Products --}}
<section class="py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-2xl font-bold text-blue-900 mb-1">Produk Unggulan</h2>
                <div class="w-16 h-1 bg-orange-500"></div>
            </div>
            <a href="{{ route('katalog.index') }}" class="text-sm font-semibold text-orange-500 hover:text-orange-600 flex items-center gap-1">
                Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if($featuredProducts->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
            @foreach($featuredProducts as $product)
            <a href="{{ route('katalog.show', $product->id) }}" class="bg-white rounded-xl shadow hover:shadow-md overflow-hidden transition hover:-translate-y-1 group">
                <div class="aspect-[3/4] bg-gray-100 overflow-hidden">
                    <img src="{{ $product->cover_url }}" alt="{{ $product->judul }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-3">
                    <div class="text-xs text-orange-500 font-semibold mb-1">
                        {{ $product->category?->name ?? 'Umum' }}
                        @if($product->jenjang) · {{ $product->jenjang }}@endif
                    </div>
                    <div class="font-semibold text-gray-800 text-sm leading-tight line-clamp-2">{{ $product->judul }}</div>
                    @if($product->penulis)
                    <div class="text-xs text-gray-400 mt-1">{{ $product->penulis }}</div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 text-gray-400">
            <i class="fas fa-book text-5xl mb-4"></i>
            <p>Belum ada produk tersedia.</p>
        </div>
        @endif
    </div>
</section>

{{-- Tentang Singkat --}}
<section class="py-14 bg-blue-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-2xl font-bold mb-4">Tentang CV. Pustaka Grafika</h2>
                <div class="w-16 h-1 bg-orange-500 mb-6"></div>
                <p class="text-blue-200 leading-relaxed mb-4">
                    Sebuah usaha berbentuk perseroan komanditer yang dimotori sekelompok tenaga profesional muda.
                    Didirikan tahun 2007 dengan komitmen memberikan layanan pengadaan barang dan jasa di bidang pendidikan.
                </p>
                <p class="text-blue-200 leading-relaxed mb-6">
                    Kami mengkhususkan diri sebagai produsen percetakan offset dan penyedia buku pelajaran dari jenjang SD hingga SMA/SMK.
                </p>
                <a href="{{ route('tentang') }}" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                    Selengkapnya <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-800 rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-orange-400 mb-2">2007</div>
                    <div class="text-sm text-blue-300">Tahun Berdiri</div>
                </div>
                <div class="bg-blue-800 rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-orange-400 mb-2">17+</div>
                    <div class="text-sm text-blue-300">Tahun Pengalaman</div>
                </div>
                <div class="bg-blue-800 rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-orange-400 mb-2">SD-SMA</div>
                    <div class="text-sm text-blue-300">Jenjang Pendidikan</div>
                </div>
                <div class="bg-blue-800 rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold text-orange-400 mb-2">100+</div>
                    <div class="text-sm text-blue-300">Instansi Dilayani</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Produk Lain (other products) --}}
<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-blue-900 mb-2">Produk Lainnya</h2>
            <div class="w-16 h-1 bg-orange-500 mx-auto mb-4"></div>
            <p class="text-gray-500 text-sm">Selain buku pelajaran, kami juga menyediakan berbagai produk percetakan</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @php
            $produkLain = [
                ['img' => 'buku-tulis.jpg', 'label' => 'Buku Tulis'],
                ['img' => 'kalender-dinding.jpg', 'label' => 'Kalender Dinding'],
                ['img' => 'kalender-kerja-duduk-2023.jpg', 'label' => 'Kalender Kerja'],
                ['img' => 'cover-detak-detik-2021.jpg', 'label' => 'Majalah Sekolah'],
                ['img' => 'cover-block-name.jpg', 'label' => 'Block Name'],
            ];
            @endphp
            @foreach($produkLain as $item)
            @if(file_exists(public_path('images/produklain/' . $item['img'])))
            <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-md transition">
                <img src="{{ asset('images/produklain/' . $item['img']) }}" alt="{{ $item['label'] }}" class="w-full h-40 object-cover">
                <div class="p-3 text-center text-sm font-semibold text-gray-700">{{ $item['label'] }}</div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-12 bg-orange-500">
    <div class="max-w-7xl mx-auto px-4 text-center text-white">
        <h2 class="text-2xl font-bold mb-3">Butuh Informasi Lebih Lanjut?</h2>
        <p class="text-orange-100 mb-6">Hubungi kami sekarang untuk konsultasi pengadaan buku dan percetakan</p>
        <div class="flex items-center justify-center gap-4 flex-wrap">
            <a href="https://wa.me/62811371171" target="_blank"
               class="inline-flex items-center gap-2 bg-white text-orange-600 font-bold px-6 py-3 rounded-lg hover:bg-orange-50 transition">
                <i class="fab fa-whatsapp text-green-500 text-xl"></i> WhatsApp Kami
            </a>
            <a href="{{ route('kontak') }}"
               class="inline-flex items-center gap-2 border-2 border-white text-white font-bold px-6 py-3 rounded-lg hover:bg-orange-600 transition">
                <i class="fas fa-envelope"></i> Halaman Kontak
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    let heroIndex = 0;
    const heroSlides = document.querySelectorAll('.hero-slide');
    const heroDots  = document.querySelectorAll('.hero-dot');

    function goHero(n) {
        heroSlides[heroIndex].classList.remove('active');
        heroDots[heroIndex].classList.replace('bg-orange-400', 'bg-white/40');
        heroIndex = n;
        heroSlides[heroIndex].classList.add('active');
        heroDots[heroIndex].classList.replace('bg-white/40', 'bg-orange-400');
    }

    setInterval(() => goHero((heroIndex + 1) % heroSlides.length), 5000);
</script>
@endpush
