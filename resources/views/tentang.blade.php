@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')

<div class="bg-blue-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2">Tentang Kami</h1>
        <div class="flex items-center gap-2 text-xs text-blue-400 mt-3">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a>
            <span>/</span>
            <span class="text-white">Tentang Kami</span>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

    {{-- Intro --}}
    <div class="flex flex-col md:flex-row gap-8 mb-14 items-start">
        <div class="md:w-72 shrink-0">
            <img src="{{ asset('images/tentang/head_tentang.jpg') }}" alt="Pustaka Grafika"
                 class="w-full rounded-xl shadow-lg object-cover">
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-blue-900 mb-4">Perkenalkan Kami, <span class="text-orange-500">PUSTAKA GRAFIKA…</span></h2>
            <div class="w-16 h-1 bg-orange-500 mb-6"></div>
            <div class="text-gray-700 leading-relaxed space-y-4 text-justify">
                <p>
                    Sebuah usaha berbentuk perseroan komanditer yang dimotori sekelompok tenaga profesional muda.
                    Didirikan tahun 2007 dengan komitmen memberikan layanan pengadaan barang dan jasa di bidang pendidikan
                    pada instansi pemerintah maupun swasta.
                </p>
                <p>
                    Kami mengkhususkan diri sebagai produsen percetakan offset dan penyedia buku (alat peraga pendidikan)
                    yang telah eksis bertahun-tahun memberikan pelayanan dalam meningkatkan mutu proses belajar mengajar.
                    Dalam hal ini pengadaan buku-buku pelajaran atau bahan ajar, mulai jenjang pendidikan Sekolah Dasar,
                    Sekolah Lanjutan Menengah Pertama, Sekolah Menengah Atas ataupun Kejuruan.
                </p>
                <p>
                    Kami telah membantu beberapa instansi dan sekolah dari tingkat sekolah dasar sampai sekolah menengah atas
                    dalam percetakan dan merealisasikan pengadaannya. Kami berpengalaman di dunia percetakan dan pengadaan
                    penunjang pembelajaran.
                </p>
                <p>
                    Dengan semangat <strong class="text-blue-900">"Mitra Mencerdaskan Anak Bangsa"</strong>, kami PUSTAKA GRAFIKA
                    selalu mengutamakan mutu dan kualitas, selalu update dan pioneer dalam percetakan untuk memberikan
                    kemudahan dan kenyamanan para pengguna jasa.
                </p>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-14">
        <div class="bg-blue-900 text-white rounded-xl p-6 text-center">
            <div class="text-3xl font-bold text-orange-400 mb-1">2007</div>
            <div class="text-xs text-blue-300">Tahun Berdiri</div>
        </div>
        <div class="bg-blue-900 text-white rounded-xl p-6 text-center">
            <div class="text-3xl font-bold text-orange-400 mb-1">17+</div>
            <div class="text-xs text-blue-300">Tahun Pengalaman</div>
        </div>
        <div class="bg-blue-900 text-white rounded-xl p-6 text-center">
            <div class="text-3xl font-bold text-orange-400 mb-1">SD–SMA</div>
            <div class="text-xs text-blue-300">Jenjang Pendidikan</div>
        </div>
        <div class="bg-blue-900 text-white rounded-xl p-6 text-center">
            <div class="text-3xl font-bold text-orange-400 mb-1">100+</div>
            <div class="text-xs text-blue-300">Instansi Dilayani</div>
        </div>
    </div>

    {{-- Galeri --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-blue-900 mb-2 text-center">Galeri Kegiatan</h2>
        <div class="w-16 h-1 bg-orange-500 mx-auto mb-8"></div>
    </div>
    @php
    $tentangImages = ['t2','t3','t4','t5','t6','t7','t8','t9','t10','t11','t12','t13'];
    @endphp
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach($tentangImages as $img)
        @if(file_exists(public_path("images/tentang/{$img}.jpg")))
        <div class="aspect-square overflow-hidden rounded-xl shadow">
            <img src="{{ asset("images/tentang/{$img}.jpg") }}" alt="Kegiatan Pustaka Grafika"
                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
        </div>
        @endif
        @endforeach
    </div>

</div>

@endsection
