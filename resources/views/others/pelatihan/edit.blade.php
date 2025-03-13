@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">Edit Pelatihan</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pelatihan.update', $pelatihan->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama Pelatihan</label>
                            <input type="text" name="pelatihan" class="form-control" value="{{ $pelatihan->pelatihan }}" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_pelatihan" class="form-control" value="{{ $pelatihan->tanggal_pelatihan }}" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai_pelatihan" class="form-control" value="{{ $pelatihan->tanggal_selesai_pelatihan }}">
                        </div>

                        <div class="form-group">
                            <label>Nama Penyelenggara</label>
                            <input type="text" name="nama_penyelenggara" class="form-control" value="{{ $pelatihan->nama_penyelenggara }}" required>
                        </div>

                        <div class="form-group">
                            <label>Lampiran (Sertifikat)</label>
                            <input type="file" name="lamp_pelatihan" class="form-control" accept="image/*">
                            <small class="text-muted">Ukuran maksimal file: 2MB</small>
                            
                            @if ($pelatihan->lamp_pelatihan)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . str_replace('public/', '', $pelatihan->lamp_pelatihan)) }}" alt="Preview" class="img-thumbnail" width="200">
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i>  Simpan Perubahan
                        </button>
                        <a href="{{ route('pelatihan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i>  Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
