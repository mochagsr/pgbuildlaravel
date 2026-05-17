@extends('layouts.admin')

@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')
@section('page-title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori Baru')

@section('content')

<div class="max-w-lg">
    <form method="POST"
          action="{{ $category->exists ? route('admin.kategori.update', $category) : route('admin.kategori.store') }}"
          class="space-y-5">
        @csrf
        @if($category->exists)
        @method('PUT')
        @endif

        <div class="bg-white rounded-xl shadow p-6 space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-400 @enderror"
                       placeholder="Contoh: Buku Matematika">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Ikon (emoji)</label>
                <input type="text" name="icon" value="{{ old('icon', $category->icon) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="📚 (paste emoji)">
                <p class="text-xs text-gray-400 mt-1">Opsional. Gunakan emoji sebagai ikon kategori.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan Tampil</label>
                <input type="number" name="urutan" value="{{ old('urutan', $category->urutan ?? 0) }}" min="0"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <p class="text-xs text-gray-400 mt-1">Angka kecil tampil lebih dulu.</p>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition text-sm">
                <i class="fas fa-save"></i>
                {{ $category->exists ? 'Simpan Perubahan' : 'Tambah Kategori' }}
            </button>
            <a href="{{ route('admin.kategori.index') }}"
               class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold px-6 py-2.5 rounded-lg transition text-sm">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection
