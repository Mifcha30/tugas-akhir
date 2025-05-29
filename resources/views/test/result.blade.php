



@extends('components.welcome')

@section('content')
    <h2 class="text-xl font-bold">Hasil Tes: {{ ucfirst($result->test_type) }}</h2>
    <p><strong>Nama:</strong> {{ $result->name }}</p>
    <p><strong>Email:</strong> {{ $result->email }}</p>
    <p><strong>HP:</strong> {{ $result->phone }}</p>
    <p><strong>Skor Akhir:</strong> {{ $result->score }}</p>
@endsection

