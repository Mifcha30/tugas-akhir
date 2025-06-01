@extends('components.welcome')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-700 via-purple-500 to-pink-400 py-10 px-4">
        <div
            class="max-w-4xl mx-auto bg-white bg-opacity-90 backdrop-blur-md rounded-xl shadow-2xl p-8 border border-purple-300">
            <h2 class="text-3xl font-extrabold text-center text-purple-800 mb-2">
                Tes {{ ucwords(str_replace('_', ' ', $type)) }}
            </h2>
            <p class="text-center text-gray-600 text-lg mb-10">Pilihlah seberapa akurat setiap pernyataan mencerminkan Anda.</p>

            <form action="{{ route('test.submit') }}" method="POST" class="space-y-6" id="test-form">
                @csrf
                <input type="hidden" name="name" value="{{ $user['name'] }}">
                <input type="hidden" name="email" value="{{ $user['email'] }}">
                <input type="hidden" name="phone" value="{{ $user['phone'] }}">
                <input type="hidden" name="test_type" value="{{ $type }}">

                @foreach ($questions as $index => $question)
                    <div class="bg-white border-l-4 border-purple-500 shadow-sm p-4 rounded-lg">
                        <p class="block text-gray-800 font-semibold mb-4">
                            {{ $index + 1 }}. {{ $question }}
                        </p>

                        <div class="flex items-center justify-between gap-4 mt-2">
                            @php
                                $labels = [
                                    '4' => 'Sangat Setuju',
                                    '3' => 'Setuju',
                                    '2' => 'Tidak Setuju',
                                    '1' => 'Sangat Tidak setuju',
                                ];
                                $borderColors = [
                                    '4' => 'border-green-400',
                                    '3' => 'border-green-400',
                                    '2' => 'border-red-300',
                                    '1' => 'border-red-400',
                                ];
                                $bgCheckedColors = [
                                    '4' => 'peer-checked:bg-green-500',
                                    '3' => 'peer-checked:bg-green-300',
                                    '2' => 'peer-checked:bg-red-300',
                                    '1' => 'peer-checked:bg-red-500',
                                ];
                            @endphp

                            @foreach (['4', '3', '2', '1'] as $value)
                                <label class="flex flex-col items-center cursor-pointer relative group">
                                    <input type="radio" name="answers[{{ $index }}]" value="{{ $value }}"
                                        required class="sr-only peer" />
                                    <div
                                        class="w-8 h-8 rounded-full border-2 transition duration-200 ease-in-out
                                         {{ $borderColors[$value] }} {{ $bgCheckedColors[$value] }}
                                          peer-checked:scale-110 peer-checked:ring-4 peer-checked:ring-purple-400 peer-checked:ring-opacity-50
                                         flex items-center justify-center">
                                        <!-- Centang jika dipilih -->
                                        <svg class="hidden peer-checked:block w-4 h-4 text-white" fill="none"
                                            stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    @if ($labels[$value])
                                        <span
                                            class="text-sm mt-2 {{ in_array($value, ['4', '3']) ? 'text-green-600' : 'text-red-600' }} font-semibold">
                                            {{ $labels[$value] }}
                                        </span>
                                    @endif

                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="text-center pt-6">
                    <button type="submit"
                        class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-6 py-3 shadow-lg transition">
                        Kirim Jawaban
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
