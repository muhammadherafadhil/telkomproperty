@extends('welcome')

@section('title', 'Edit Laporan Kinerja')

@section('content')
<div class="container">
    <h3>Edit Laporan Kinerja</h3>

    <form action="{{ route('performance.update', $performance) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $performance->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" required>{{ $performance->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-10)</label>
            <input type="number" class="form-control" id="rating" name="rating" value="{{ $performance->rating }}" min="1" max="10" required>
        </div>
        <button type="submit" class="btn btn-primary">Perbarui Laporan</button>
    </form>
</div>
@endsection
