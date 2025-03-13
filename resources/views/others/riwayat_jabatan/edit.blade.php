@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">Edit Riwayat Jabatan</div>
                <div class="card-body">
                    @if(isset($riwayatJabatan))
                    <form method="POST" action="{{ route('riwayatjabatan.update', $riwayatJabatan->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama Jabatan</label>
                            <input type="text" name="nama_jabatan" class="form-control" value="{{ old('nama_jabatan', $riwayatJabatan->nama_jabatan) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Menjabat</label>
                            <input type="date" name="tanggal_menjabat" class="form-control" value="{{ old('tanggal_menjabat', $riwayatJabatan->tanggal_menjabat) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Akhir Jabatan</label>
                            <input type="date" name="tanggal_akhir_jabatan" class="form-control" value="{{ old('tanggal_akhir_jabatan', $riwayatJabatan->tanggal_akhir_jabatan) }}">
                        </div>

                        <div class="form-group">
                            <label>Lokasi Penempatan</label>
                            <input type="text" name="lokasi_penempatan" class="form-control" value="{{ old('lokasi_penempatan', $riwayatJabatan->lokasi_penempatan) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Lampiran (Surat Keputusan, dsb.)</label>
                            <input type="file" name="lamp_jabatan" class="form-control" accept="image/*">
                            <small class="text-muted">Ukuran maksimal file: 2MB</small>

                            @if($riwayatJabatan->lamp_jabatan)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $riwayatJabatan->lamp_jabatan) }}" 
                                        alt="Lampiran" class="img-thumbnail" width="200">
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('riwayatjabatan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                    </form>
                    @else
                        <div class="alert alert-danger">Data tidak ditemukan.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
