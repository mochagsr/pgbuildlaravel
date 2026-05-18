@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
    .hero-slide { display: none; }
    .hero-slide.active { display: flex; flex-direction: row; }
    @media (max-width: 768px) {
        .hero-slide.active { flex-direction: column; }
        .hero-slide.active > div:last-child { flex: none !important; max-width: 100% !important; }
    }
</style>
@endpush

@section('content')

{{-- Hero Section: Split Layout --}}
<div style="background: linear-gradient(135deg, #0c1445 0%, #1e3a8a 60%, #1d4ed8 100%); position:relative; overflow:hidden;">
    {{-- Slides --}}
    <div id="hero-wrapper">
        @php $banners = ['banner1.webp','banner2.webp','banner3.webp']; @endphp
        @foreach($banners as $i => $banner)
        <div class="hero-slide {{ $i === 0 ? 'active' : '' }}"
             style="align-items:center; gap:2rem; padding:2rem 2rem 1rem; max-width:1280px; margin:0 auto; box-sizing:border-box;">
            {{-- Teks kiri --}}
            <div style="flex:1; color:#fff; min-width:0;">
                <div style="color:#f97316; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:0.75rem;">CV. Pustaka Grafika</div>
                <h1 style="font-size:clamp(1.6rem,3.5vw,2.8rem); font-weight:800; line-height:1.2; margin-bottom:1rem; color:#fff;">
                    Mitra Mencerdaskan<br>Anak Bangsa
                </h1>
                <p style="color:#bfdbfe; font-size:0.95rem; margin-bottom:1.5rem; line-height:1.7;">
                    Produsen percetakan offset dan penyedia buku pelajaran berkualitas. Melayani SD, SMP, SMA/SMK sejak 2007.
                </p>
                <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                    <a href="{{ route('katalog.index') }}"
                       style="background:#f97316; color:#fff; font-weight:600; padding:0.65rem 1.5rem; border-radius:0.5rem; font-size:0.875rem; text-decoration:none; display:inline-block;"
                       onmouseover="this.style.background='#ea6c10'" onmouseout="this.style.background='#f97316'">
                        Lihat Katalog
                    </a>
                    <a href="https://wa.me/62811371171" target="_blank"
                       style="border:1px solid rgba(255,255,255,0.4); color:#fff; font-weight:600; padding:0.65rem 1.5rem; border-radius:0.5rem; font-size:0.875rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem;">
                        <i class="fab fa-whatsapp" style="color:#4ade80;"></i> WhatsApp
                    </a>
                </div>
            </div>
            {{-- Gambar kanan --}}
            <div style="flex:0 0 55%; max-width:55%;">
                <img src="{{ asset('images/banner/' . $banner) }}" alt="Banner {{ $i+1 }}"
                     style="width:100%; height:auto; border-radius:0.75rem; box-shadow: 0 25px 50px rgba(0,0,0,0.4); display:block;">
            </div>
        </div>
        @endforeach
    </div>

    {{-- Dots --}}
    <div style="display:flex; justify-content:center; gap:0.5rem; padding-bottom:1.25rem;">
        @foreach($banners as $i => $b)
        <button onclick="goHero({{ $i }})"
                class="hero-dot"
                data-index="{{ $i }}"
                style="width:10px; height:10px; border-radius:50%; border:none; cursor:pointer; background:{{ $i === 0 ? '#f97316' : 'rgba(255,255,255,0.4)' }};"></button>
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
            @foreach($produkLainnya as $item)
            <a href="{{ route('katalog.show', $item->id) }}"
               class="bg-white rounded-xl shadow overflow-hidden hover:shadow-md transition hover:-translate-y-1 group">
                <div class="aspect-[3/4] bg-gray-100 overflow-hidden">
                    <img src="{{ $item->cover_url }}" alt="{{ $item->judul }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-3 text-center text-sm font-semibold text-gray-700 line-clamp-2">{{ $item->judul }}</div>
            </a>
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
        heroDots[heroIndex].style.background = 'rgba(255,255,255,0.4)';
        heroIndex = n;
        heroSlides[heroIndex].classList.add('active');
        heroDots[heroIndex].style.background = '#f97316';
    }

    setInterval(() => goHero((heroIndex + 1) % heroSlides.length), 5000);
</script>
@endpush
