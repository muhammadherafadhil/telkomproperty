@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header"><i class="bi bi-award"></i>   Daftar Penghargaan</div>
                <div class="card-body">
                    <a href="{{ route('penghargaan.create') }}" class="btn btn-primary mb-3">
                        <i class="bi bi-plus-circle"></i>   Tambah Penghargaan
                    </a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Penghargaan</th>
                                <th>Tahun</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penghargaans as $index => $penghargaan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $penghargaan->nama_penghargaan }}</td>
                                    <td>{{ $penghargaan->tahun_penghargaan }}</td>
                                    <td>
                                        @if ($penghargaan->lamp_penghargaan)
                                            <img src="{{ asset('storage/' . str_replace('public/', '', $penghargaan->lamp_penghargaan)) }}" 
                                                 alt="Lampiran" class="img-thumbnail" width="150">
                                        @else
                                            <span class="text-muted">Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('penghargaan.edit', $penghargaan->id) }}" class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('penghargaan.destroy', $penghargaan->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $penghargaans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection