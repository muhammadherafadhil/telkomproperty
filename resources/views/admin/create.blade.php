@extends('welcome')

@section('title', 'Tambah Kinerja')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Kinerja Pegawai</h3>

    <form action="{{ route('admin.performance.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="user_id">Pilih Pegawai</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <!-- Daftar pegawai bisa diambil dari database -->
                @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }} (NIK: {{ $user->nik }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="rating">Rating</label>
            <input type="number" name="rating" id="rating" class="form-control" min="1" max="10" required>
        </div>

        <div class="form-group">
            <label for="score">Skor</label>
            <input type="number" name="score" id="score" class="form-control" min="1" max="5" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Kinerja</button>
    </form>

    <h3 class="mt-5">Daftar Kinerja Pegawai</h3>
    @foreach($performances as $performance)
        <div class="performance-item">
            <h5>{{ $performance->user->name }} (NIK: {{ $performance->user->nik }})</h5>
            <p><strong>Nama Pegawai:</strong> {{ $performance->user->name }}</p>
            <p><strong>Judul:</strong> {{ $performance->title }}</p>
            <p><strong>Deskripsi:</strong> {{ $performance->description }}</p>
            <p><strong>Rating:</strong> {{ $performance->rating }}</p>
            <p><strong>Skor:</strong> {{ $performance->score }}</p>
        </div>
    @endforeach
</div>
@endsection
