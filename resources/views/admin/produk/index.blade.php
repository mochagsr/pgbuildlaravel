@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')
@section('page-subtitle', 'Tambah, edit, dan hapus produk katalog')

@section('content')

{{-- Actions Bar --}}
<div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between mb-6">
    <form method="GET" action="{{ route('admin.produk.index') }}" class="flex gap-2 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul..."
               class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 w-48">
        <select name="kategori" onchange="this.form.submit()"
                class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800 transition">
            <i class="fas fa-search"></i>
        </button>
        @if(request()->hasAny(['search', 'kategori']))
        <a href="{{ route('admin.produk.index') }}" class="border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition">Reset</a>
        @endif
    </form>

    <a href="{{ route('admin.produk.create') }}"
       class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition shrink-0">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide w-14">Cover</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Judul</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Jenjang</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3">
                        <img src="{{ $product->cover_url }}" alt="{{ $product->judul }}"
                             class="w-10 h-14 object-cover rounded shadow-sm">
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-800 line-clamp-1">{{ $product->judul }}</div>
                        @if($product->penulis)<div class="text-xs text-gray-400">{{ $product->penulis }}</div>@endif
                    </td>
                    <td class="px-4 py-3 hidden md:table-cell text-gray-600">
                        {{ $product->category?->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 hidden lg:table-cell text-gray-600">
                        {{ $product->jenjang ?? '-' }}
                        @if($product->kelas) Kelas {{ $product->kelas }}@endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                     {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $product->is_active ? 'Aktif' : 'Non-aktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.produk.edit', $product) }}"
                               class="w-8 h-8 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center hover:bg-blue-200 transition"
                               title="Edit">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.produk.destroy', $product) }}"
                                  onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition"
                                        title="Hapus">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                        <i class="fas fa-book text-4xl mb-3 block"></i>
                        Belum ada produk. <a href="{{ route('admin.produk.create') }}" class="text-blue-600 hover:underline">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="px-4 py-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection
