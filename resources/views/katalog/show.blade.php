@extends('layouts.app')

@section('title', $product->judul)

@php
    $allImages = collect([['url' => $product->cover_url, 'alt' => $product->judul]]);
    foreach ($product->images as $img) {
        $allImages->push(['url' => $img->url, 'alt' => $product->judul]);
    }
@endphp

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

        {{-- Carousel Gambar --}}
        <div class="md:col-span-1">

            @if($allImages->count() > 1)
            {{-- Carousel --}}
            <div class="relative" id="img-carousel">
                <div class="overflow-hidden rounded-xl shadow-lg bg-white">
                    <div class="flex transition-transform duration-500" id="img-track">
                        @foreach($allImages as $idx => $img)
                        <div class="min-w-full cursor-zoom-in" onclick="openLightbox({{ $idx }})">
                            <img src="{{ $img['url'] }}" alt="{{ $img['alt'] }}"
                                 class="w-full object-contain max-h-96 select-none">
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Prev/Next --}}
                @if($allImages->count() > 1)
                <button onclick="imgPrev()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full w-8 h-8 flex items-center justify-center transition">
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>
                <button onclick="imgNext()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full w-8 h-8 flex items-center justify-center transition">
                    <i class="fas fa-chevron-right text-sm"></i>
                </button>
                @endif

                {{-- Dots --}}
                <div class="flex justify-center gap-1.5 mt-3">
                    @foreach($allImages as $idx => $img)
                    <button onclick="imgGoto({{ $idx }})" class="img-dot w-2 h-2 rounded-full transition {{ $idx === 0 ? 'bg-blue-900' : 'bg-gray-300' }}"></button>
                    @endforeach
                </div>

                {{-- Thumbnail strip --}}
                <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                    @foreach($allImages as $idx => $img)
                    <img src="{{ $img['url'] }}" alt="thumb"
                         onclick="imgGoto({{ $idx }})"
                         class="img-thumb w-16 h-16 object-cover rounded-lg cursor-pointer border-2 transition {{ $idx === 0 ? 'border-blue-900' : 'border-transparent' }} shrink-0 hover:border-blue-400">
                    @endforeach
                </div>
            </div>

            @else
            {{-- Single image --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden cursor-zoom-in" onclick="openLightbox(0)">
                <img src="{{ $product->cover_url }}" alt="{{ $product->judul }}"
                     class="w-full object-contain max-h-96">
            </div>
            @endif
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

{{-- Lightbox --}}
<div id="lightbox" onclick="closeLightbox()"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.92); z-index:9999; align-items:center; justify-content:center;">
    <button onclick="closeLightbox()" style="position:absolute; top:1rem; right:1.25rem; color:#fff; font-size:1.75rem; background:none; border:none; cursor:pointer; line-height:1;">&times;</button>
    <button onclick="lbPrev(event)" style="position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:#fff; font-size:1.5rem; background:rgba(255,255,255,0.1); border:none; cursor:pointer; border-radius:50%; width:44px; height:44px;">&#8249;</button>
    <img id="lightbox-img" src="" alt=""
         style="max-width:90vw; max-height:90vh; object-fit:contain; border-radius:0.5rem; box-shadow:0 0 60px rgba(0,0,0,0.8);" onclick="event.stopPropagation()">
    <button onclick="lbNext(event)" style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); color:#fff; font-size:1.5rem; background:rgba(255,255,255,0.1); border:none; cursor:pointer; border-radius:50%; width:44px; height:44px;">&#8250;</button>
    <div id="lightbox-counter" style="position:absolute; bottom:1rem; left:50%; transform:translateX(-50%); color:#fff; font-size:0.85rem; opacity:0.7;"></div>
</div>

@push('scripts')
<script>
    // Data gambar dari server
    const images = @json($allImages->pluck('url'));
    let imgIdx = 0;

    // --- Carousel ---
    const track    = document.getElementById('img-track');
    const dots     = document.querySelectorAll('.img-dot');
    const thumbs   = document.querySelectorAll('.img-thumb');

    function imgUpdate() {
        if (!track) return;
        track.style.transform = `translateX(-${imgIdx * 100}%)`;
        dots.forEach((d, i) => {
            d.classList.toggle('bg-blue-900', i === imgIdx);
            d.classList.toggle('bg-gray-300', i !== imgIdx);
        });
        thumbs.forEach((t, i) => {
            t.classList.toggle('border-blue-900', i === imgIdx);
            t.classList.toggle('border-transparent', i !== imgIdx);
        });
    }

    function imgNext() { imgIdx = (imgIdx + 1) % images.length; imgUpdate(); }
    function imgPrev() { imgIdx = (imgIdx - 1 + images.length) % images.length; imgUpdate(); }
    function imgGoto(n) { imgIdx = n; imgUpdate(); }

    // Auto-rotate setiap 4 detik
    if (images.length > 1) setInterval(imgNext, 4000);

    // --- Lightbox ---
    const lb    = document.getElementById('lightbox');
    const lbImg = document.getElementById('lightbox-img');
    const lbCtr = document.getElementById('lightbox-counter');
    let lbIdx   = 0;

    function openLightbox(idx) {
        lbIdx = idx;
        lbImg.src = images[lbIdx];
        lbCtr.textContent = (lbIdx + 1) + ' / ' + images.length;
        lb.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lb.style.display = 'none';
        document.body.style.overflow = '';
    }

    function lbNext(e) {
        e.stopPropagation();
        lbIdx = (lbIdx + 1) % images.length;
        lbImg.src = images[lbIdx];
        lbCtr.textContent = (lbIdx + 1) + ' / ' + images.length;
    }

    function lbPrev(e) {
        e.stopPropagation();
        lbIdx = (lbIdx - 1 + images.length) % images.length;
        lbImg.src = images[lbIdx];
        lbCtr.textContent = (lbIdx + 1) + ' / ' + images.length;
    }

    // Tutup dengan tombol Esc
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') lbNext(e);
        if (e.key === 'ArrowLeft')  lbPrev(e);
    });
</script>
@endpush

@endsection
