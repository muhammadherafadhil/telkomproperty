@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header"><i class="bi bi-pin-angle"></i>   Daftar Keterampilan</div>
                <div class="card-body">
                    <a href="{{ route('keterampilan.create') }}" class="btn btn-primary mb-3">
                        <i class="bi bi-plus-circle"></i> Tambah Keterampilan
                    </a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Keterampilan</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($keterampilans as $index => $keterampilan)
                                <tr>
                                    <td>{{ $index + $keterampilans->firstItem() }}</td>
                                    <td>{{ $keterampilan->keterampilan }}</td>
                                    <td>
                                        @if($keterampilan->lamp_keterampilan)
                                            <img src="{{ asset('storage/' . str_replace('public/', '', $keterampilan->lamp_keterampilan)) }}" 
                                            alt="Lampiran" class="img-thumbnail" width="170">
                                        @else
                                            <span class="text-muted">Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('keterampilan.edit', $keterampilan->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('keterampilan.destroy', $keterampilan->id) }}" method="POST" class="d-inline">
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

                    {{ $keterampilans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
