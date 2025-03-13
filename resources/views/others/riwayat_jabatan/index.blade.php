@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header"><i class="bi bi-building-fill-gear"></i> Riwayat Jabatan</div>

                <div class="card-body">
                    <a href="{{ route('riwayatjabatan.create') }}" class="btn btn-primary mb-3">
                        <i class="bi bi-plus-circle"></i>  Tambah Riwayat
                    </a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Jabatan</th>
                                <th>Tanggal Menjabat</th>
                                <th>Tanggal Akhir</th>
                                <th>Lokasi</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riwayatJabatans as $riwayat)
                                <tr>
                                    <td>{{ $riwayat->nama_jabatan }}</td>
                                    <td>{{ $riwayat->tanggal_menjabat }}</td>
                                    <td>{{ $riwayat->tanggal_akhir_jabatan ?? '-' }}</td>
                                    <td>{{ $riwayat->lokasi_penempatan }}</td>
                                    <td>
                                        @if($riwayat->lamp_jabatan)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . str_replace('public/', '', $riwayat->lamp_jabatan)) }}" 
                                                     alt="Lampiran" class="img-thumbnail" width="100">
                                            </div>
                                        @else
                                            <span class="text-muted">Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('riwayatjabatan.edit', $riwayat->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('riwayatjabatan.destroy', $riwayat->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="bi bi-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    {{ $riwayatJabatans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
