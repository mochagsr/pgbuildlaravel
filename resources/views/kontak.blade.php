@extends('layouts.app')

@section('title', 'Kontak')

@section('content')

<div class="bg-blue-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2">Hubungi Kami</h1>
        <div class="flex items-center gap-2 text-xs text-blue-400 mt-3">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a>
            <span>/</span>
            <span class="text-white">Kontak</span>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

        {{-- Info Kontak --}}
        <div>
            <h2 class="text-2xl font-bold text-blue-900 mb-2">Informasi Kontak</h2>
            <div class="w-16 h-1 bg-orange-500 mb-8"></div>

            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-900 text-white rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 mb-1">Alamat Kantor</h4>
                        <p class="text-gray-600 text-sm">Jl. Puter Utara No.23, Sukun,<br>Kota Malang 65147, Jawa Timur</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-900 text-white rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-phone text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 mb-1">Telepon</h4>
                        <p class="text-gray-600 text-sm">
                            <a href="tel:0341321853" class="hover:text-blue-900">(0341) 321853</a>
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-green-500 text-white rounded-xl flex items-center justify-center shrink-0">
                        <i class="fab fa-whatsapp text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 mb-1">WhatsApp</h4>
                        <a href="https://wa.me/62811371171" target="_blank"
                           class="inline-flex items-center gap-2 text-green-600 font-semibold text-sm hover:underline">
                            +62 811-3711-171
                        </a>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-orange-500 text-white rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-envelope text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 mb-1">Email</h4>
                        <a href="mailto:pustakagrafika7@gmail.com" class="text-gray-600 text-sm hover:text-orange-500">
                            pustakagrafika7@gmail.com
                        </a>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-900 text-white rounded-xl flex items-center justify-center shrink-0">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 mb-1">Jam Operasional</h4>
                        <p class="text-gray-600 text-sm">Senin – Jumat: 08.00 – 17.00 WIB<br>Sabtu: 08.00 – 13.00 WIB</p>
                    </div>
                </div>
            </div>

            {{-- Quick WhatsApp --}}
            <div class="mt-8">
                <a href="https://wa.me/62811371171" target="_blank"
                   class="inline-flex items-center gap-3 bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-4 rounded-xl transition text-sm">
                    <i class="fab fa-whatsapp text-2xl"></i>
                    <div>
                        <div>Chat WhatsApp Sekarang</div>
                        <div class="text-xs font-normal text-green-100">Kami siap membantu Anda</div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Map --}}
        <div>
            <h2 class="text-2xl font-bold text-blue-900 mb-2">Lokasi Kami</h2>
            <div class="w-16 h-1 bg-orange-500 mb-8"></div>
            <div class="rounded-xl overflow-hidden shadow-lg">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.0!2d112.6!3d-7.98!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNyXCsDU4JzQ4LjAiUyAxMTLCsDM2JzAwLjAiRQ!5e0!3m2!1sid!2sid!4v1234567890"
                    width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <p class="text-xs text-gray-400 mt-2">
                <i class="fas fa-info-circle"></i>
                Jl. Puter Utara No.23, Sukun, Kota Malang
            </p>
        </div>
    </div>
</div>

@endsection
