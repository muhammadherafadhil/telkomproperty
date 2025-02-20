@extends('welcome')

@section('title', 'Daftar Kinerja')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Kinerja Pegawai</h3>

    <a href="{{ route('admin.performance.create') }}" class="btn btn-primary mb-3">Tambah Kinerja</a>

    <div class="list-group">
        @foreach($performances as $performance)
            <div class="list-group-item">
                <h5>{{ $performance->user->name }} (NIK: {{ $performance->user->nik }})</h5>
                <p><strong>Judul:</strong> {{ $performance->title }}</p>
                <p><strong>Deskripsi:</strong> {{ $performance->description }}</p>
                <p><strong>Rating:</strong> {{ $performance->rating }}</p>
                <p><strong>Skor:</strong> {{ $performance->score }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
