@extends('welcome')

@section('title', 'Tambah Laporan Kinerja')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Laporan Kinerja</h3>

    <form action="{{ route('performance.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul Laporan</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="10" required>
        </div>

        <div class="mb-3">
            <label for="score" class="form-label">Skor</label>
            <input type="number" class="form-control" id="score" name="score" min="1" max="5" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
