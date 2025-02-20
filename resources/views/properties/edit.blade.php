@extends('welcome')

@section('content')
<div class="container">
    <h1>Edit Properti</h1>

    <!-- Form Edit Properti -->
    <form action="{{ route('property.update', $property->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Properti</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $property->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" class="form-control" id="description" rows="3" required>{{ old('description', $property->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" name="location" class="form-control" id="location" value="{{ old('location', $property->location) }}" required>
        </div>

        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $property->price) }}" required>
        </div>

        <div class="form-group">
            <label for="type">Jenis Properti</label>
            <select name="type" class="form-control" required>
                <option value="Kantor" {{ $property->type == 'Kantor' ? 'selected' : '' }}>Kantor</option>
                <option value="Gedung" {{ $property->type == 'Gedung' ? 'selected' : '' }}>Gedung</option>
                <option value="Apartemen" {{ $property->type == 'Apartemen' ? 'selected' : '' }}>Apartemen</option>
                <!-- Tambahkan jenis lainnya sesuai kebutuhan -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Properti</button>
    </form>
</div>
@endsection
