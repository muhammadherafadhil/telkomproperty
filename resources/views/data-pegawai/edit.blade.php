<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Data Pegawai</h1>
        <form action="{{ route('data-pegawai.update', ['nik' => $dataPegawai->nik]) }}" method="POST">
            @csrf
            @method('PATCH')  <!-- Menggunakan PATCH untuk update data -->
            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $dataPegawai->nama) }}" required>
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan', $dataPegawai->jabatan) }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            
            <!-- Tombol Cancel -->
            <a href="{{ route('beranda') }}" class="btn btn-secondary ml-2">Cancel</a>
        </form>
    </div>
</body>
</html>
