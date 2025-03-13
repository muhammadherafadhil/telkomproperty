@extends('welcome')

@section('title', 'Profil Pegawai')

@section('content')
<div class="profile-page bg-dark text-black vh-100 d-flex justify-content-center align-items-center">
    <div class="profile-card shadow-lg bg-white" style="max-width: 80vw; width: 100%; height: 90vh;">
        <div class="row h-100 g-0">
            <!-- Sisi Kiri: Foto dan Header -->
            <div class="col-lg-4 bg-gradient-primary d-flex flex-column align-items-center justify-content-center text-center p-4">
                <div class="img-thumbnail" style="width: 20vw; height: auto;">
                    <img src="{{ asset('storage/' . $dataPegawai->lamp_foto_karyawan) }}" class="img-fluid profile-hover" style="object-fit: contain; background-color: #000000; border-radius: 2vh;">
                </div>
                <h2 class="mt-2">{{ $dataPegawai->nama_lengkap }}</h2>
                <p class="text-muted">{{ $dataPegawai->nama_posisi }}</p>
                <p class="text-muted">{{ $dataPegawai->unit_kerja }}</p>
            </div>
            <!-- Sisi Kanan: Informasi Lengkap -->
            <div class="col-lg-8 bg-light p-5 shadow" style="margin-top:5vh;">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <!-- Tab Data Pribadi -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active border me-2" id="pills-personal-tab" data-bs-toggle="pill" data-bs-target="#pills-personal" type="button" role="tab" aria-controls="pills-personal" aria-selected="true">
                            <i class="bi bi-person"></i> Data Pribadi
                        </button>
                    </li>
                    <!-- Tab Pekerjaan -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link border me-2" id="pills-job-tab" data-bs-toggle="pill" data-bs-target="#pills-job" type="button" role="tab" aria-controls="pills-job" aria-selected="false">
                            <i class="bi bi-briefcase"></i> Pekerjaan
                        </button>
                    </li>
                    <!-- Tab Kontak -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link border me-2" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">
                            <i class="bi bi-telephone"></i> Kontak
                        </button>
                    </li>
                    <!-- Tab Keluarga -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link border me-2" id="pills-family-tab" data-bs-toggle="pill" data-bs-target="#pills-family" type="button" role="tab" aria-controls="pills-family" aria-selected="false">
                            <i class="bi bi-people"></i> Keluarga
                        </button>
                    </li>
                    <!-- Tab Dokumen -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link border me-2" id="pills-documents-tab" data-bs-toggle="pill" data-bs-target="#pills-documents" type="button" role="tab" aria-controls="pills-documents" aria-selected="false">
                            <i class="bi bi-file-earmark-text"></i> Dokumen Pribadi
                        </button>
                    </li>
                    <!-- Tab Dokumen Keluarga -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link border me-2" id="pills-documents-familys-tab" data-bs-toggle="pill" data-bs-target="#pills-documents-familys" type="button" role="tab" aria-controls="pills-documents" aria-selected="false">
                            <i class="bi bi-folder"></i> Dokumen Keluarga
                        </button>
                    </li>
                </ul> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">                
                <div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
                <div class="tab-content" id="pills-tabContent">
                    <!-- Tab Data Pribadi -->
                    <div class="tab-pane fade show active" id="pills-personal" role="tabpanel" aria-labelledby="pills-personal-tab">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $dataPegawai->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td>{{ $dataPegawai->nik ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td>{{ $dataPegawai->agama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $dataPegawai->sex ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Golongan Darah</th>
                                    <td>{{ $dataPegawai->gol_darah ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat Lahir</th>
                                    <td>{{ $dataPegawai->tempat_lahir ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>{{ $dataPegawai->tanggal_lahir ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $dataPegawai->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td>{{ $dataPegawai->provinsi->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kabupaten</th>
                                    <td>{{ $dataPegawai->kabupaten->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kecamatan</th>
                                    <td>{{ $dataPegawai->kecamatan->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kelurahan</th>
                                    <td>{{ $dataPegawai->kelurahan->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>RT/RW</th>
                                    <td>{{ $dataPegawai->rt_rw ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor KTP</th>
                                    <td>{{ $dataPegawai->nomor_ktp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Bpjs Kesehatan</th>
                                    <td>{{ $dataPegawai->no_bpjs_kes ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Telkomedika</th>
                                    <td>{{ $dataPegawai->no_telkomedika ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor NPWP</th>
                                    <td>{{ $dataPegawai->npwp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Ibu Kandung</th>
                                    <td>{{ $dataPegawai->nama_ibu_kandung ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Ayah Kandung</th>
                                    <td>{{ $dataPegawai->nama_ayah_kandung ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pendidikan Terakhir</th>
                                    <td>{{ $dataPegawai->pendidikan_terakhir ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Tab Pekerjaan -->
                    <div class="tab-pane fade" id="pills-job" role="tabpanel" aria-labelledby="pills-job-tab">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>NIK TG</th>
                                    <td>{{ $dataPegawai->nik_tg ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Unit Kerja</th>
                                    <td>{{ $dataPegawai->unit_kerja ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Posisi</th>
                                    <td>{{ $dataPegawai->klasifikasi_posisi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td>{{ $dataPegawai->nama_posisi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pekerjaan</th>
                                    <td>{{ $dataPegawai->aktif_or_pensiun ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Lokasi Kerja</th>
                                    <td>{{ $dataPegawai->lokasi_kerja ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Mulai Kerja</th>
                                    <td>{{ $dataPegawai->tanggal_mulai_kerja ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Pos</th>
                                    <td>{{ $dataPegawai->kode_pos ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Divisi</th>
                                    <td>{{ $dataPegawai->kode_divisi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Kontrak</th>
                                    <td>{{ $dataPegawai->no_kontrak ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>MLI Kontrak</th>
                                    <td>{{ $dataPegawai->mli_kontrak ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Akhir Kontrak</th>
                                    <td>{{ $dataPegawai->end_kontrak ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>PSA </th>
                                    <td>{{ $dataPegawai->psa ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor BPJS Tenaga Kerja</th>
                                    <td>{{ $dataPegawai->no_bpjs_ket ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor SK Karyawan Tetap</th>
                                    <td>{{ $dataPegawai->no_sk_kartap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor SK Promut</th>
                                    <td>{{ $dataPegawai->no_sk_promut ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Tab Kontak -->
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>No Rekening</th>
                                    <td>{{ $dataPegawai->no_rekening ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Bank</th>
                                    <td>{{ $dataPegawai->nama_bank ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $dataPegawai->other_email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Email Telpro</th>
                                    <td>{{ $dataPegawai->email_telpro ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>No HP</th>
                                    <td>{{ $dataPegawai->no_hp ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Tab Keluarga -->
                    <div class="tab-pane fade" id="pills-family" role="tabpanel" aria-labelledby="pills-family-tab">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Status Perkawinan</th>
                                    <td>{{ $dataPegawai->status_nikah ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Pasangan</th>
                                    <td>{{ $dataPegawai->nama_suami_or_istri ?? '-' }}</td>
                                </tr>   
                                <tr>
                                    <th>No Kartu Keluarga</th>
                                    <td>{{ $dataPegawai->no_kk ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>No HP Pasangan</th>
                                    <td>{{ $dataPegawai->nomor_hp_pasangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Anak 1</th>
                                    <td>{{ $dataPegawai->nama_anak_1 ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir 1</th>
                                    <td>{{ $dataPegawai->tgl_lahir_anak_1 ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Anak 2</th>
                                    <td>{{ $dataPegawai->nama_anak_2 ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir 2</th>
                                    <td>{{ $dataPegawai->tgl_lahir_anak_2 ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Anak 3</th>
                                    <td>{{ $dataPegawai->nama_anak_3 ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir 3</th>
                                    <td>{{ $dataPegawai->tgl_lahir_anak_3 ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Tab Dokumen -->
                    <div class="tab-pane fade" id="pills-documents" role="tabpanel" aria-labelledby="pills-documents-tab">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Foto KTP</th>
                                    <td>
                                        @if($dataPegawai->lamp_ktp)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_ktp) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Foto Kontrak Kerja</th>
                                    <td>
                                        @if($dataPegawai->lamp_kontrak)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_kontrak) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Foto Buku Rekening</th>
                                    <td>
                                        @if($dataPegawai->lamp_buku_rekening)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_buku_rekening) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Foto NPWP</th>
                                    <td>
                                        @if($dataPegawai->lamp_kartu_npwp)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_kartu_npwp) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Foto SK Promosi/Mutasi</th>
                                    <td>
                                        @if($dataPegawai->lamp_kartu_npwp)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_sk_promut) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Foto SK Kartu Pekerja</th>
                                    <td>
                                        @if($dataPegawai->lamp_sk_kartap)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_sk_kartap) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Foto BPJS Kesehatan</th>
                                    <td>
                                        @if($dataPegawai->lamp_bpjs_kes)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_bpjs_kes) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Foto BPJS Tenaga Kerja</th>
                                    <td>
                                        @if($dataPegawai->lamp_bpjs_kes)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_bpjs_tk) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    
                    <!-- Tab Dokumen Keluarga -->
                    <div class="tab-pane fade" id="pills-documents-familys" role="tabpanel" aria-labelledby="pills-documents-familys-tab">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Lampiran Buku Nikah</th>
                                    <td>
                                        @if($dataPegawai->lamp_buku_nikah)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_buku_nikah) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lampiran Kartu Keluarga</th>
                                    <td>
                                        @if($dataPegawai->lamp_kk)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_kk) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Foto KTP Pasangan</th>
                                    <td>
                                        @if($dataPegawai->lamp_ktp_pasangan)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_ktp_pasangan) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lampiran Akta Anak 1</th>
                                    <td>
                                        @if($dataPegawai->lamp_akta_1)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_akta_1) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lampiran Akta Anak 2</th>
                                    <td>
                                        @if($dataPegawai->lamp_akta_2)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_akta_2) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lampiran Akta Anak 3</th>
                                    <td>
                                        @if($dataPegawai->lamp_akta_3)
                                            <a href="{{ asset('storage/' . $dataPegawai->lamp_akta_3) }}" target="_blank" class="btn btn-outline-warning">
                                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="bi bi-ban"></i> Tidak ada lampiran</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- LAINNY --}}
                </div>
            </div>
            <br>
            <a href="{{ route('data-pegawai.edit', ['nik' => $dataPegawai->nik]) }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i>   Tambah/Edit</a>
        </div>
    </div>
</div>
<style>

    .nav-link:hover {
        color: #007bff;
    }
    
    .profile-card:hover {
        box-shadow: 0 8px 10px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
