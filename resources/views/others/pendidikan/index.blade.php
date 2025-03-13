@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header"><i class="bi bi-suitcase-lg"></i>   Daftar Pendidikan</div>
                <div class="card-body">
                    <a href="{{ route('pendidikan.create') }}" class="btn btn-primary mb-3">
                        <i class="bi bi-plus-circle"></i>   Tambah Pendidikan
                    </a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Jenjang</th>
                                <th>Institusi</th>
                                <th>Jurusan</th>
                                <th>Tahun Lulus</th>
                                <th>Bukti Ijazah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendidikans as $pendidikan)
                                <tr>
                                    <td>{{ $pendidikan->jenjang_pendidikan }}</td>
                                    <td>{{ $pendidikan->institusi }}</td>
                                    <td>{{ $pendidikan->jurusan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pendidikan->tahun_lulus)->format(' Y') }}</td>
                                    <td>
                                        @if($pendidikan->lamp_ijazah)
                                            <img src="{{ asset('storage/' . $pendidikan->lamp_ijazah) }}" 
                                            alt="Lampiran" class="img-thumbnail" width="130">
                                        @else
                                            <span class="text-muted">Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pendidikan.edit', $pendidikan->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('pendidikan.destroy', $pendidikan->id) }}" method="POST" class="d-inline">
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
                {{ $pendidikans->links() }} </div>
            </div>
        </div>
    </div>
</div>
@endsection
