@extends('welcome')

@section('content')
<div class="container py-5">
    <h2>{{ $plan->judul }}</h2>
    <p>{{ $plan->deskripsi }}</p>
    
    <!-- Menggunakan Carbon untuk memformat tanggal jika kolom sudah dalam bentuk Carbon -->
    <p><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($plan->tanggal_mulai)->format('d M Y') }}</p>
    <p><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($plan->tanggal_selesai)->format('d M Y') }}</p>
    
    <p><strong>Status:</strong> {{ ucfirst($plan->status) }}</p>

    <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-warning">Edit</a>

    <!-- Form untuk menghapus plan -->
    <form action="{{ route('plans.destroy', $plan->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus</button>
    </form>
</div>
@endsection
