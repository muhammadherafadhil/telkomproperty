@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header"><i class="bi bi-book"></i>    Daftar Hobi</div>
                <div class="card-body">
                    <a href="{{ route('hobi.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i>   Tambah Hobi
                    </a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Hobi</th>
                                <th>Bukti Nyata</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hobis as $index => $hobi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $hobi->hobi }}</td>
                                <td>
                                    @if ($hobi->lamp_kegiatan_hobi)
                                        <img src="{{ asset('storage/' . str_replace('public/', '', $hobi->lamp_kegiatan_hobi)) }}" alt="lampiran" class="img-thumbnail" width="150">
                                    @else
                                        Tidak ada lampiran<a href="{{ route('hobi.edit', $hobi->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                          </a>Lampiran
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('hobi.edit', $hobi->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('hobi.destroy', $hobi->id) }}" method="POST" class="d-inline" 
                                        onsubmit="return confirm('Yakin ingin menghapus hobi ini?');">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-danger btn-sm">
                                          <i class="bi bi-trash"></i> Hapus
                                      </button>
                                  </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $hobis->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>