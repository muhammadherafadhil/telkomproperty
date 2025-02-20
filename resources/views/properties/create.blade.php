@extends('welcome')

@section('content')
<div class="container">
    <h1>Tambah Properti Baru</h1>

    <!-- Form Tambah Properti -->
    <form action="{{ route('property.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nama Properti</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Nama Properti" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" class="form-control" id="description" rows="3" placeholder="Deskripsi Properti" required></textarea>
        </div>

        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" name="location" class="form-control" id="location" placeholder="Lokasi Properti" required>
        </div>

        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" name="price" class="form-control" id="price" placeholder="Harga Properti" required>
        </div>

        <div class="form-group">
            <label for="type">Jenis Properti</label>
            <select name="type" class="form-control" required>
                <option value="Kantor">Kantor</option>
                <option value="Gedung">Gedung</option>
                <option value="Apartemen">Apartemen</option>
                <!-- Tambahkan jenis lainnya sesuai kebutuhan -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Properti</button>
    </form>
</div>
@endsection
