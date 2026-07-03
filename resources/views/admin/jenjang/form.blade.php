@extends('layouts.admin')

@section('title', $jenjang->exists ? 'Edit Jenjang' : 'Tambah Jenjang')
@section('page-title', $jenjang->exists ? 'Edit Jenjang' : 'Tambah Jenjang Baru')

@section('content')

<div class="max-w-lg">
    <form method="POST"
          action="{{ $jenjang->exists ? route('admin.jenjang.update', $jenjang) : route('admin.jenjang.store') }}"
          class="space-y-5">
        @csrf
        @if($jenjang->exists)
        @method('PUT')
        @endif

        <div class="bg-white rounded-xl shadow p-6 space-y-5">

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Jenjang <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $jenjang->nama) }}" required
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama') border-red-400 @enderror"
                       placeholder="Contoh: MI, MTs, SD, SMP">
                @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                <p class="text-xs text-gray-400 mt-1">Nama ini muncul sebagai pilihan di dropdown Jenjang pada form produk.</p>
            </div>

            {{-- Urutan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan Tampil</label>
                <input type="number" name="urutan" value="{{ old('urutan', $jenjang->urutan ?? 0) }}" min="0"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <p class="text-xs text-gray-400 mt-1">Angka kecil tampil lebih dulu &mdash; default 0 (paling awal). Isi 1 agar tampil paling depan (jenjang lain otomatis digeser).</p>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-2.5 rounded-lg transition text-sm">
                <i class="fas fa-save"></i>
                {{ $jenjang->exists ? 'Simpan Perubahan' : 'Tambah Jenjang' }}
            </button>
            <a href="{{ route('admin.jenjang.index') }}"
               class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold px-6 py-2.5 rounded-lg transition text-sm">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection
