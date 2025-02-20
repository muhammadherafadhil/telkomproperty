@extends('welcome')

@section('content')
<div class="container">
    <h1>{{ $property->name }}</h1>

    <p><strong>Deskripsi:</strong> {{ $property->description }}</p>
    <p><strong>Lokasi:</strong> {{ $property->location }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($property->price, 0, ',', '.') }}</p>
    <p><strong>Jenis Properti:</strong> {{ $property->type }}</p>

    <a href="{{ route('property.edit', $property->id) }}" class="btn btn-warning">Edit</a>

    <form action="{{ route('property.destroy', $property->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus properti ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus</button>
    </form>

    <a href="{{ route('property.index') }}" class="btn btn-secondary">Kembali ke Daftar Properti</a>
</div>
@endsection
