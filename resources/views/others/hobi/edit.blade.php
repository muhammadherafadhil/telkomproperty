@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-black">
                    <h5 class="mb-0">Ubah Hobi</h5>
                </div>
                <div class="card-body">
                    {{-- Notifikasi Sukses dan Error --}}
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Form Edit Hobi --}}
                    <form method="POST" action="{{ route('hobi.update', $hobi->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Hobi</label>
                            <input type="text" name="hobi" class="form-control" value="{{ $hobi->hobi }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lampiran Kegiatan Hobi (Foto)</label>
                            <input type="file" name="lamp_kegiatan_hobi" class="form-control" accept="image/*">
                            <small class="text-muted">Ukuran maksimal file: 2MB</small>

                            @if($hobi->lamp_kegiatan_hobi)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . str_replace('public/', '', $hobi->lamp_kegiatan_hobi)) }}" 
                                        alt="Preview" class="img-thumbnail" width="150">
                                </div>
                            @else
                                <p class="text-muted mt-2">Tidak ada lampiran</p>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('hobi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk Fade Out Notifikasi --}}
<script>
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 3000); // 3 detik
</script>
@endsection
