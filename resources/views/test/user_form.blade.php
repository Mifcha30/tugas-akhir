



@extends('components.welcome')

@section('content')
     <h1 class="text-xl font-bold">Data Diri - Tes {{ ucfirst($type) }}</h1>
    <form action="{{ route('test.storeUser') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="test_type" value="{{ $type }}">
        <input type="text" name="name" placeholder="Nama" required class="border p-2 w-full">
        <input type="email" name="email" placeholder="Email" required class="border p-2 w-full">
        <input type="text" name="phone" placeholder="No HP" required class="border p-2 w-full">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Mulai Tes</button>
    </form>
@endsection

