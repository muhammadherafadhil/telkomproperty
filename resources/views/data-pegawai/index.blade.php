@extends('welcome')

@section('title', 'Halaman Register')

@section('content')
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
        <a href="{{ route('data-pegawai.edit', ['nik' => Auth::user()->nik]) }}" class="btn btn-primary d-block">Edit Profil</a>
        <a href="{{ route('beranda') }}" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
    </div>
@endsection
