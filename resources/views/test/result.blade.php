@extends('components.welcome')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-700 via-purple-500 to-pink-400 py-10 px-4">
        <div
            class="max-w-4xl mx-auto bg-white bg-opacity-90 backdrop-blur-md rounded-xl shadow-2xl p-8 border border-purple-300 text-gray-800">

            <!-- Lottie Animation -->
            <div class="relative h-40 flex justify-center items-center">
                <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
                <dotlottie-player src="https://lottie.host/b65c4e52-ab97-48c4-aad4-c1ef51546058/wS3X5yDZhp.lottie"
                    background="transparent" speed="1" style="width: 300px; height: 300px" class="absolute" autoplay loop>
                </dotlottie-player>
            </div>

            <!-- Judul -->
            <h1 class="text-4xl font-extrabold text-center text-purple-800 mt-8">Selamat!</h1>
            <p class="text-lg text-gray-700 mb-10 text-center">Anda telah menyelesaikan test
                {{ ucwords(str_replace('_', ' ', $result->test_type)) }}</p>

            <h2 class="text-2xl font-extrabold text-center text-purple-800 mb-3">
                Hasil Tes: {{ ucwords(str_replace('_', ' ', $result->test_type)) }}
            </h2>

            <!-- Kategori Hasil -->
            @php
                $kategori = 'Sangat Rendah';
                $score = $result->score;
                $formattedType = ucwords(str_replace('_', ' ', $result->test_type));

                if ($score >= 80 && $score <= 100) {
                    $kategori = 'Sangat Tinggi';
                } elseif ($score >= 60 && $score <= 79) {
                    $kategori = 'Tinggi';
                } elseif ($score >= 40 && $score <= 59) {
                    $kategori = 'Sedang';
                } elseif ($score >= 20 && $score <= 39) {
                    $kategori = 'Rendah';
                }
            @endphp

            <!-- Informasi Hasil -->
            <div class=" space-y-4 mb-4 text-lg text-gray-700 text-center">
                <p>
                    <span class="font-medium text-xl text-gray-700">Skor Akhir </span>
                    <br>
                    <span class="font-extrabold text-purple-700 text-4xl">{{ $result->score }}</span>
                </p>
                <p>
                    <span class="font-medium text-gray-700 text-xl">Kategori {{ $formattedType }} :</span>
                    <span class="font-extrabold text-purple-700 text-xl">{{ $kategori }}</span>
                </p>

            </div>

             <div class="text-center mt-8 mb-2">
                    <a href="{{ route('test.index') }}"
                        class="inline-block px-5 py-2 bg-purple-600 text-white font-semibold rounded-lg shadow-md hover:bg-purple-700 transition">
                        Kembali ke Pilihan Tes
                    </a>
                </div>

        </div>
    </div>
@endsection
