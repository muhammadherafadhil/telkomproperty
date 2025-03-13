@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-black">Ubah Keterampilan</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('keterampilan.update', $keterampilan->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Keterampilan</label>
                            <input type="text" name="keterampilan" class="form-control" value="{{ $keterampilan->keterampilan }}" required>
                        </div>

                        <div class="form-group">
                            <label>Lampiran (Foto / Sertifikat)</label>
                            <input type="file" name="lamp_keterampilan" class="form-control" accept="image/*">
                            <small class="text-muted">Ukuran maksimal file: 2MB</small>

                            @if($keterampilan->lamp_keterampilan)
                                <img src="{{ asset('storage/' . str_replace('public/', '', $keterampilan->lamp_keterampilan)) }}" class="mt-2 img-thumbnail" width="200">
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('keterampilan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i>  Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
