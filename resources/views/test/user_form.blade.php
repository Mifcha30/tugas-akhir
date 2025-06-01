@extends('components.welcome')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-700 via-purple-500 to-pink-400 py-10 px-4">
        <div
            class="max-w-4xl mx-auto bg-white bg-opacity-90 backdrop-blur-md rounded-xl shadow-2xl p-8 border border-purple-300 text-gray-800">
            
            @php
                $formattedType = ucwords(str_replace('_', ' ', $type));
            @endphp

            <h1 class="text-3xl font-extrabold text-center text-purple-800 mb-3">
                Data Diri - Tes {{ $formattedType }}
            </h1>
            <p class="text-center text-gray-700 mb-6">Silakan masukkan data diri Anda untuk memulai tes.</p>

            <form action="{{ route('test.storeUser') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="test_type" value="{{ $type }}">

                <div>
                    <label class="block  font-semibold text-purple-700 mb-1">Nama</label>
                    <input type="text" name="name" placeholder="Masukkan Nama"
                        required
                        class="w-full px-4 py-2 border border-purple-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label class="block  font-semibold text-purple-700 mb-1">Email</label>
                    <input type="email" name="email" placeholder="Masukkan Email"
                        required
                        class="w-full px-4 py-2 border border-purple-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label class="block  font-semibold text-purple-700 mb-1">No HP</label>
                    <input type="text" name="phone" placeholder="Masukkan No HP"
                        required
                        class="w-full px-4 py-2 border border-purple-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="text-center pt-4">
                    <button type="submit"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition">
                        Mulai Tes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
