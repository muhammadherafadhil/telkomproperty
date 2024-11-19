<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Data Pegawai</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kolom</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <!-- Menampilkan Data Pegawai dalam Format Vertikal -->
                @foreach ($dataPegawais as $dataPegawai)
                    <tr>
                        <td><strong>NIK</strong></td>
                        <td>{{ $dataPegawai->nik }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td>{{ $dataPegawai->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jabatan</strong></td>
                        <td>{{ $dataPegawai->jabatan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{ $dataPegawai->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>{{ $dataPegawai->alamat }}</td>
                    </tr>
                    <tr>
                        <td><strong>Telepon</strong></td>
                        <td>{{ $dataPegawai->telepon }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tempat Lahir</strong></td>
                        <td>{{ $dataPegawai->tempat_lahir }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Lahir</strong></td>
                        <td>{{ $dataPegawai->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>{{ $dataPegawai->status }}</td>
                    </tr>
                    <tr>
                        <td><strong>Foto</strong></td>
                        <td><img src="{{ asset('storage/' . $dataPegawai->foto) }}" alt="Foto Pegawai" width="100"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tombol Kembali ke Beranda -->
        <a href="{{ route('beranda') }}" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
    </div>
</body>
</html>
