@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">Tambah Riwayat Jabatan</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('riwayatjabatan.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Nama Jabatan</label>
                            <input type="text" name="nama_jabatan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Menjabat</label>
                            <input type="date" name="tanggal_menjabat" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Akhir Jabatan</label>
                            <input type="date" name="tanggal_akhir_jabatan" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Lokasi Penempatan</label>
                            <input type="text" name="lokasi_penempatan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Lampiran (Surat Keputusan, dsb.)</label>
                            <input type="file" name="lamp_jabatan" class="form-control" accept="image/*">
                            <small class="text-muted">Ukuran maksimal file: 2MB</small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i>  Simpan
                        </button>
                        <a href="{{ route('riwayatjabatan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i>  Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
