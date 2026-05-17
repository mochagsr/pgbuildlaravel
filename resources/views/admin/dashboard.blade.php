@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang di panel admin Pustaka Grafika')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Produk</h3>
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-book text-blue-700"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800">{{ $totalProduk }}</div>
        <p class="text-xs text-gray-400 mt-1">Semua produk terdaftar</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Produk Aktif</h3>
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800">{{ $totalAktif }}</div>
        <p class="text-xs text-gray-400 mt-1">Tampil di website publik</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Kategori</h3>
            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-tags text-orange-600"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800">{{ $totalKategori }}</div>
        <p class="text-xs text-gray-400 mt-1">Kategori buku tersedia</p>
    </div>
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Recent Products --}}
    <div class="bg-white rounded-xl shadow">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Produk Terbaru</h3>
            <a href="{{ route('admin.produk.index') }}" class="text-xs text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($produkTerbaru as $p)
            <div class="flex items-center gap-4 px-6 py-4">
                <img src="{{ $p->cover_url }}" alt="{{ $p->judul }}"
                     class="w-10 h-14 object-cover rounded shadow-sm shrink-0">
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-sm text-gray-800 truncate">{{ $p->judul }}</div>
                    <div class="text-xs text-gray-400">{{ $p->category?->name ?? 'Tanpa Kategori' }} · {{ $p->jenjang ?? '-' }}</div>
                </div>
                <span class="text-xs px-2 py-1 rounded-full {{ $p->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $p->is_active ? 'Aktif' : 'Non-aktif' }}
                </span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada produk.</div>
            @endforelse
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="bg-white rounded-xl shadow">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Aksi Cepat</h3>
        </div>
        <div class="p-6 grid grid-cols-2 gap-4">
            <a href="{{ route('admin.produk.create') }}"
               class="flex flex-col items-center gap-3 p-5 bg-blue-50 hover:bg-blue-100 rounded-xl transition text-center group">
                <div class="w-12 h-12 bg-blue-900 group-hover:bg-blue-800 text-white rounded-xl flex items-center justify-center transition">
                    <i class="fas fa-plus text-lg"></i>
                </div>
                <div class="text-sm font-semibold text-gray-700">Tambah Produk</div>
            </a>
            <a href="{{ route('admin.kategori.create') }}"
               class="flex flex-col items-center gap-3 p-5 bg-orange-50 hover:bg-orange-100 rounded-xl transition text-center group">
                <div class="w-12 h-12 bg-orange-500 group-hover:bg-orange-600 text-white rounded-xl flex items-center justify-center transition">
                    <i class="fas fa-tag text-lg"></i>
                </div>
                <div class="text-sm font-semibold text-gray-700">Tambah Kategori</div>
            </a>
            <a href="{{ route('katalog.index') }}" target="_blank"
               class="flex flex-col items-center gap-3 p-5 bg-green-50 hover:bg-green-100 rounded-xl transition text-center group">
                <div class="w-12 h-12 bg-green-500 group-hover:bg-green-600 text-white rounded-xl flex items-center justify-center transition">
                    <i class="fas fa-eye text-lg"></i>
                </div>
                <div class="text-sm font-semibold text-gray-700">Lihat Katalog</div>
            </a>
            <a href="{{ route('admin.produk.index') }}"
               class="flex flex-col items-center gap-3 p-5 bg-purple-50 hover:bg-purple-100 rounded-xl transition text-center group">
                <div class="w-12 h-12 bg-purple-600 group-hover:bg-purple-700 text-white rounded-xl flex items-center justify-center transition">
                    <i class="fas fa-list text-lg"></i>
                </div>
                <div class="text-sm font-semibold text-gray-700">Semua Produk</div>
            </a>
        </div>
    </div>
</div>

@endsection
