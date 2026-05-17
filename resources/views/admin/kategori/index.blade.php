@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')
@section('page-subtitle', 'Atur kategori buku dalam katalog')

@section('content')

<div class="flex justify-end mb-5">
    <a href="{{ route('admin.kategori.create') }}"
       class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Kategori</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Slug</th>
                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Ikon</th>
                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Urutan</th>
                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Produk</th>
                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($categories as $category)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-5 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                <td class="px-5 py-3 text-gray-500 hidden sm:table-cell font-mono text-xs">{{ $category->slug }}</td>
                <td class="px-5 py-3 text-center text-2xl">{{ $category->icon ?: '📚' }}</td>
                <td class="px-5 py-3 text-center text-gray-600">{{ $category->urutan }}</td>
                <td class="px-5 py-3 text-center">
                    <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded-full">
                        {{ $category->products_count }}
                    </span>
                </td>
                <td class="px-5 py-3 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.kategori.edit', $category) }}"
                           class="w-8 h-8 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center hover:bg-blue-200 transition"
                           title="Edit">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.kategori.destroy', $category) }}"
                              onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
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
                <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                    <i class="fas fa-tags text-4xl mb-3 block"></i>
                    Belum ada kategori. <a href="{{ route('admin.kategori.create') }}" class="text-blue-600 hover:underline">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
