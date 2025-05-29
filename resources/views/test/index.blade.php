

@extends('components.welcome')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Pilih Jenis Tes</h1>
    <ul class="space-y-2">
        @foreach ($testTypes as $type)
            <li>
                <a href="{{ route('test.form', $type) }}"
                   class="text-blue-600 hover:underline capitalize">
                   {{ str_replace('_', ' ', $type) }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection
