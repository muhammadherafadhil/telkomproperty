@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">Edit Pendidikan</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pendidikan.update', $pendidikan->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Jenjang Pendidikan</label>
                            <select name="jenjang_pendidikan" class="form-control" required>
                                @foreach ($jenjangPendidikanOptions as $jenjang)
                                    <option value="{{ $jenjang }}" {{ $pendidikan->jenjang_pendidikan == $jenjang ? 'selected' : '' }}>
                                        {{ $jenjang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Institusi</label>
                            <input type="text" name="institusi" class="form-control" value="{{ $pendidikan->institusi }}" required>
                        </div>

                        <div class="form-group">
                            <label>Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" value="{{ $pendidikan->jurusan }}" required>
                        </div>

                        <div class="form-group">
                            <label>Tahun Lulus</label>
                            <input type="number" name="tahun_lulus" class="form-control" value="{{ $pendidikan->tahun_lulus }}" required>
                        </div>

                        <div class="form-group">
                            <label>Lampiran Ijazah</label>
                            <input type="file" name="lamp_ijazah" class="form-control" accept="image/*">
                            @if($pendidikan->lamp_ijazah)
                                <img src="{{ asset('storage/' . $pendidikan->lamp_ijazah) }}" class="mt-2 img-thumbnail" width="200">
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i>  Simpan
                        </button>
                        <a href="{{ route('pendidikan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i>  Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
