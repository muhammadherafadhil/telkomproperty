@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">Tambah Pelatihan</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pelatihan.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Nama Pelatihan</label>
                            <input type="text" name="pelatihan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_pelatihan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai_pelatihan" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Nama Penyelenggara</label>
                            <input type="text" name="nama_penyelenggara" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Lampiran (Sertifikat)</label>
                            <input type="file" name="lamp_pelatihan" class="form-control" accept="image/*">
                            <small class="text-muted">Ukuran maksimal file: 2MB</small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i>  Simpan
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
