@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header"><i class="bi bi-train-freight-front"></i>   Daftar Pelatihan</div>

                <div class="card-body">
                    <a href="{{ route('pelatihan.create') }}" class="btn btn-primary mb-3">
                        <i class="bi bi-plus-circle"></i>   Tambah Pelatihan
                    </a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Pelatihan</th>
                                <th>Tanggal Pelatihan</th>
                                <th>Penyelenggara</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelatihans as $pelatihan)
                                <tr>
                                    <td>{{ $pelatihan->pelatihan }}</td>
                                    <td>{{ $pelatihan->tanggal_pelatihan }} s/d {{ $pelatihan->tanggal_selesai_pelatihan ?? '-' }}</td>
                                    <td>{{ $pelatihan->nama_penyelenggara }}</td>
                                    <td>
                                        @if($pelatihan->lamp_pelatihan)
                                            <img src="{{ asset('storage/' . str_replace('public/', '', $pelatihan->lamp_pelatihan)) }}" 
                                            alt="Lampiran" class="img-thumbnail" width="120">
                                        @else
                                            <span class="text-muted">Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pelatihan.edit', $pelatihan->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('pelatihan.destroy', $pelatihan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $pelatihans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
