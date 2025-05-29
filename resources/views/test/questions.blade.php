

@extends('components.welcome')

@section('content')
    <h2 class="text-lg font-bold mb-2">Tes {{ ucfirst($type) }}</h2>
    <form action="{{ route('test.submit') }}" method="POST">
        @csrf
        <input type="hidden" name="name" value="{{ $user['name'] }}">
        <input type="hidden" name="email" value="{{ $user['email'] }}">
        <input type="hidden" name="phone" value="{{ $user['phone'] }}">
        <input type="hidden" name="test_type" value="{{ $type }}">

        @foreach ($questions as $index => $question)
            <div class="mb-4">
                <p>{{ $index+1 }}. {{ $question }}</p>
                <select name="answers[{{ $index }}]" required class="border p-2 w-full mt-1">
                    <option value="4">Sangat Setuju</option>
                    <option value="3">Setuju</option>
                    <option value="2">Tidak Setuju</option>
                    <option value="1">Sangat Tidak Setuju</option>
                </select>
            </div>
        @endforeach

        <button type="submit" class="bg-green-500 text-white px-4 py-2">Kirim Jawaban</button>
    </form>
@endsection

