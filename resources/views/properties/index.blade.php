@extends('welcome')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Properti Telkom</h1>

    <!-- Form Pencarian dan Filter -->
    <form method="GET" action="{{ route('property.index') }}">
        <div class="row mb-4">
            <!-- Pencarian Nama atau Lokasi -->
            <div class="col-md-3">
                <input type="text" name="search" value="{{ old('search', $search) }}" class="form-control" placeholder="Cari Nama/Lokasi">
            </div>

            <!-- Filter Lokasi -->
            <div class="col-md-3">
                <select name="location" class="form-control">
                    <option value="">Pilih Lokasi</option>
                    <option value="Sulsel" {{ old('location', $location) == 'Makassar' ? 'selected' : '' }}>Makassar</option>
                    <option value="Sultra" {{ old('location', $location) == 'Sultra' ? 'selected' : '' }}>Sultra</option>
                    <option value="Sulteng" {{ old('location', $location) == 'Sulteng' ? 'selected' : '' }}>Sulteng</option>
                    <option value="Sulut Malut" {{ old('location', $location) == 'Sulut Malut' ? 'selected' : '' }}>Sulut Malut</option>
                    <option value="Maluku" {{ old('location', $location) == 'Maluku' ? 'selected' : '' }}>Maluku</option>
                    <option value="Papua Barat" {{ old('location', $location) == 'Papua Barat' ? 'selected' : '' }}>Papua Barat</option>
                    <option value="Papua" {{ old('location', $location) == 'Papua' ? 'selected' : '' }}>Papua</option>
                    <!-- Tambahkan lokasi lainnya -->
                </select>
            </div>

            <!-- Filter Harga Min -->
            <div class="col-md-2">
                <input type="number" name="min_price" value="{{ old('min_price', $minPrice) }}" class="form-control" placeholder="Min Harga">
            </div>

            <!-- Filter Harga Max -->
            <div class="col-md-2">
                <input type="number" name="max_price" value="{{ old('max_price', $maxPrice) }}" class="form-control" placeholder="Max Harga">
            </div>

            <!-- Tombol Cari -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Cari</button>
            </div>
        </div>
    </form>

    <!-- Tampilkan Pesan Berhasil -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Tambah Properti -->
    <a href="{{ route('property.create') }}" class="btn btn-success mb-4">Tambah Properti</a>

    <!-- Daftar Properti -->
    <div class="row">
        @foreach ($properties as $property)
            <div class="col-md-4 mb-4">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $property->name }}</h5>
                        <p class="card-text">{{ Str::limit($property->description, 100) }}</p>
                        <p><strong>Lokasi:</strong> {{ $property->location }}</p>
                        <p><strong>Harga:</strong> Rp {{ number_format($property->price, 0, ',', '.') }}</p>
                        <p><strong>Jenis:</strong> {{ $property->type }}</p>

                        <!-- Link ke Detail Properti -->
                        <a href="{{ route('property.show', $property->id) }}" class="btn btn-info btn-sm">Lihat Detail</a>

                        <!-- Link untuk Edit dan Hapus Properti (hanya untuk admin) -->
                        @can('update', $property)
                            <a href="{{ route('property.edit', $property->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('delete', $property)
                            <form action="{{ route('property.destroy', $property->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus properti ini?')">Hapus</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    {{ $properties->links() }}
</div>
@endsection
