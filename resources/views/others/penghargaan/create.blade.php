@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">Tambah Penghargaan</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('penghargaan.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Nama Penghargaan</label>
                            <input type="text" name="nama_penghargaan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tahun Penghargaan</label>
                            <input type="date" name="tahun_penghargaan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Lampiran (Foto)</label>
                            <input type="file" name="lamp_penghargaan" class="form-control" accept="image/*">
                            <small class="text-muted">Ukuran maksimal file: 2MB</small>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i>  Simpan
                        </button>
                        <a href="{{ route('penghargaan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i>  Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
