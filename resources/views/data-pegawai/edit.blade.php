@extends('welcome')

@section('title', 'Edit Data Pegawai')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-lg rounded">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Edit Data Pegawai</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('data-pegawai.update', ['nik' => $dataPegawai->nik]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH') <!-- Menggunakan PATCH untuk update data -->

                        <!-- Field 1: Nama Posisi -->
                        <div class="mb-4">
                            <label for="nama_posisi" class="form-label">Nama Posisi</label>
                            <input type="text" class="form-control" name="nama_posisi" value="{{ old('nama_posisi', $dataPegawai->nama_posisi) }}" >
                        </div>

                        <!-- Field 3: klasifikasi_posisi -->
                        <div class="mb-4">
                            <label for="klasifikasi_posisi" class="form-label">Klasifikasi Posisi</label>
                            <input type="text" class="form-control" name="klasifikasi_posisi" value="{{ old('klasifikasi_posisi', $dataPegawai->klasifikasi_posisi) }}" >
                        </div>

                        <!-- Field 4: lokasi_kerja -->
                        <div class="mb-4">
                            <label for="lokasi_kerja" class="form-label">Lokasi Kerja</label>
                            <input type="text" class="form-control" name="lokasi_kerja" value="{{ old('lokasi_kerja', $dataPegawai->lokasi_kerja) }}" >
                        </div>

                        <!-- Field 5: unit_kerja -->
                        <div class="mb-4">
                            <label for="unit_kerja" class="form-label">Unit Kerja</label>
                            <input type="text" class="form-control" name="unit_kerja" value="{{ old('unit_kerja', $dataPegawai->unit_kerja) }}" >
                        </div>

                        <!-- Field 6: psa -->
                        <div class="mb-4">
                            <label for="psa" class="form-label">PSA</label>
                            <input type="text" class="form-control" name="psa" value="{{ old('psa', $dataPegawai->psa) }}" >
                        </div>

                        <!-- Field 7: nik_tg -->
                        <div class="mb-4">
                            <label for="nik_tg" class="form-label">NIK TG</label>
                            <input type="text" class="form-control" name="nik_tg" value="{{ old('nik_tg', $dataPegawai->nik_tg) }}" >
                        </div>

                        <!-- Field 8: nama_lengkap -->
                        <div class="mb-4">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap', $dataPegawai->nama_lengkap) }}" >
                        </div>

                        <!-- Field 9: level_eksis -->
                        <div class="mb-4">
                            <label for="level_eksis" class="form-label">Level Eksis</label>
                            <input type="text" class="form-control" name="level_eksis" value="{{ old('level_eksis', $dataPegawai->level_eksis) }}" >
                        </div>

                        <!-- Field 10: tanggal_level -->
                        <div class="mb-4">
                            <label for="tanggal_level" class="form-label">Tanggal Level</label>
                            <input type="date" class="form-control" name="tanggal_level" value="{{ old('tanggal_level', $dataPegawai->tanggal_level) }}" >
                        </div>

                        <!-- Field 11: tempat_lahir -->
                        <div class="mb-4">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $dataPegawai->tempat_lahir) }}" >
                        </div>

                        <!-- Field 12: tanggal_lahir -->
                        <div class="mb-4">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $dataPegawai->tanggal_lahir) }}" >
                        </div>

                        <!-- Field 13: agama -->
                        <div class="mb-4">
                            <label for="agama" class="form-label">Agama</label>
                            <select class="form-select" name="agama" >
                                <option value="Islam" {{ old('agama', $dataPegawai->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Protestan" {{ old('agama', $dataPegawai->agama) == 'Protestan' ? 'selected' : '' }}>Protestan</option>
                                <option value="Katholik" {{ old('agama', $dataPegawai->agama) == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                <option value="Hindu" {{ old('agama', $dataPegawai->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Budha" {{ old('agama', $dataPegawai->agama) == 'Budha' ? 'selected' : '' }}>Budha</option>
                                <option value="Konghucu" {{ old('agama', $dataPegawai->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>            
                        </div>

                        <!-- Field 14: sex -->
                        <div class="mb-4">
                            <label for="sex" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" name="sex" >
                                <option value="Laki-laki" {{ old('sex', $dataPegawai->sex) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('sex', $dataPegawai->sex) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <!-- Field 15: gol_darah -->
                        <div class="mb-4">
                            <label for="gol_darah" class="form-label">Golongan Darah</label>
                            <select class="form-select" name="gol_darah" >
                            <option value="A" {{ old('gol_darah', $dataPegawai->gol_darah) == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('gol_darah', $dataPegawai->gol_darah) == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('gol_darah', $dataPegawai->gol_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('gol_darah', $dataPegawai->gol_darah) == 'O' ? 'selected' : '' }}>O</option>
                            </select>
                        </div>

                        <!-- Field 16: pendidikan_terakhir -->
                        <div class="mb-4">
                            <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                            <select class="form-select" name="pendidikan_terakhir">
                <option value="SMA/SMK" {{ old('pendidikan_terakhir', $dataPegawai->pendidikan_terakhir) == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                <option value="D1" {{ old('pendidikan_terakhir', $dataPegawai->pendidikan_terakhir) == 'D1' ? 'selected' : '' }}>D1</option>
                <option value="D2" {{ old('pendidikan_terakhir', $dataPegawai->pendidikan_terakhir) == 'D2' ? 'selected' : '' }}>D2</option>
                <option value="D3" {{ old('pendidikan_terakhir', $dataPegawai->pendidikan_terakhir) == 'D3' ? 'selected' : '' }}>D3</option>
                <option value="D4" {{ old('pendidikan_terakhir', $dataPegawai->pendidikan_terakhir) == 'D4' ? 'selected' : '' }}>D4</option>
                <option value="S1" {{ old('pendidikan_terakhir', $dataPegawai->pendidikan_terakhir) == 'S1' ? 'selected' : '' }}>S1</option>
                <option value="S2" {{ old('pendidikan_terakhir', $dataPegawai->pendidikan_terakhir) == 'S2' ? 'selected' : '' }}>S2</option>
                <option value="S3" {{ old('pendidikan_terakhir', $dataPegawai->pendidikan_terakhir) == 'S3' ? 'selected' : '' }}>S3</option>
            </select>
                        </div>

                        <!-- Field 17: aktif_or_pensiun -->
                        <div class="mb-4">
                            <label for="aktif_or_pensiun" class="form-label">Status Aktif/Pensiun</label>
                            <select class="form-select" name="aktif_or_pensiun" >
                                <option value="aktif" {{ old('aktif_or_pensiun', $dataPegawai->aktif_or_pensiun) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="pensiun" {{ old('aktif_or_pensiun', $dataPegawai->aktif_or_pensiun) == 'pensiun' ? 'selected' : '' }}>Pensiun</option>
                            </select>
                        </div>

                        <!-- Field 18: nomor_ktp -->
                        <div class="mb-4">
    <label for="nomor_ktp" class="form-label">Nomor KTP</label>
    <input type="text" class="form-control" name="nomor_ktp" id="nomor_ktp" oninput="toggleKtpAttachmentField()"value=" {{ old('nomor_ktp', $dataPegawai->nomor_ktp)}}">
    <span id="ktp-error-message" style="color: red; font-size: 0.9em; display: none;">Nomor KTP minimal 16 karakter.</span>
    <span id="ktp-too-long-message" style="color: red; font-size: 0.9em; display: none;">Nomor KTP tidak sesuai standar (terlalu banyak).</span>
</div>

<!-- Pesan Lampirkan Foto KTP -->
<div id="lampirkan-foto-message" style="display: none;">
    <span style="color: green; font-size: 0.9em;">Lampirkan foto KTP Anda</span>
</div>

<div class="mb-4" id="lamp-ktp-field" style="display: none;">
    <label for="lamp_ktp" class="form-label">Lampirkan KTP</label>
    <input type="file" class="form-control" name="lamp_ktp">
</div>





                        <!-- Field 19: alamat -->
                        <div class="mb-4">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" name="alamat" value="{{ old('alamat', $dataPegawai->alamat) }}" >
                        </div>

                        <!-- Field 20: rt_rw -->
                        <div class="mb-4">
                            <label for="rt_rw" class="form-label">RT/RW</label>
                            <input type="text" class="form-control" name="rt_rw" value="{{ old('rt_rw', $dataPegawai->rt_rw) }}" >
                        </div>

                        <!-- Provinsi -->
                        <div class="mb-4">
                            <label for="prov" class="form-label">Provinsi</label>
                            <select id="prov" class="form-control" name="prov" value="{{ old('prov', $dataPegawai->id_prov) }}" onchange="getKabupaten(this.value)">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinsi as $prov)
                                    <option value="{{ $prov->id_prov }}" {{ old('prov') == $prov->id_prov ? 'selected' : '' }}>
                                        {{ $prov->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="kab_kot" class="form-label">Kabupaten/Kota</label>
                            <select id="kab_kot" class="form-control" name="kab_kot" onchange="getKecamatan(this.value)">
                                <option value="">Pilih Kabupaten/Kota</option>
                                <!-- Saat validasi gagal, pilih opsi yang sesuai dengan old('kab_kot') -->
                                @if (old('kab_kot'))
                                    <option value="{{ old('kab_kot') }}" selected>
                                        {{ old('kab_kot') }}
                                    </option>
                                @endif
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="kec" class="form-label">Kecamatan</label>
                            <select id="kec" class="form-control" name="kec" onchange="getKelurahan(this.value)">
                                <option value="">Pilih Kecamatan</option>
                                <!-- Saat validasi gagal, pilih opsi yang sesuai dengan old('kec') -->
                                @if (old('kec'))
                                    <option value="{{ old('kec') }}" selected>
                                        {{ old('kec') }}
                                    </option>
                                @endif
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="des_kel" class="form-label">Desa/Kelurahan</label>
                            <select id="des_kel" class="form-control" name="des_kel">
                                <option value="">Pilih Desa/Kelurahan</option>
                                <!-- Saat validasi gagal, pilih opsi yang sesuai dengan old('des_kel') -->
                                @if (old('des_kel'))
                                    <option value="{{ old('des_kel') }}" selected>
                                        {{ old('des_kel') }}
                                    </option>
                                @endif
                            </select>
                        </div>



                        <!-- Field 25: kode_pos -->
                        <div class="mb-4">
                            <label for="kode_pos" class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" name="kode_pos" value="{{ old('kode_pos', $dataPegawai->kode_pos) }}" >
                        </div>

                        <!-- Field 26: no_hp -->
                        <div class="mb-4">
                            <label for="no_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" name="no_hp" value="{{ old('no_hp', $dataPegawai->no_hp) }}" >
                        </div>

                        <!-- Field 27: email_telpro -->
                        <div class="mb-4">
                            <label for="email_telpro" class="form-label">Email Telpro</label>
                            <input type="email" class="form-control" name="email_telpro" value="{{ old('email_telpro', $dataPegawai->email_telpro) }}" >
                        </div>

                        <!-- Field 28: other_email -->
                        <div class="mb-4">
                            <label for="other_email" class="form-label">Email Lainnya</label>
                            <input type="email" class="form-control" name="other_email" value="{{ old('other_email', $dataPegawai->other_email) }}" >
                        </div>

                        <div class="mb-4">
                            <label for="taggal_mulai_kerja" class="form-label">Tanggal Mulai Kerja</label>
                            <input type="date" class="form-control" name="tanggal_mulai_kerja" value="{{ old('tanggal_mulai_kerja', $dataPegawai->tanggal_mulai_kerja) }}" >
                        </div>

                        <div class="mb-4">
                            <label for="status_karyawan" class="form-label">Status Karyawan</label>
                            <input type="text" class="form-control" name="status_karyawan" value="{{ old('status_karyawan', $dataPegawai->status_karyawan) }}" >
                        </div>

                        <!-- Field 29: lamp_foto_karyawan -->
                        <div class="mb-4">
                            <label for="lamp_foto_karyawan" class="form-label">Lampirkan Foto Karyawan</label>
                            <input type="file" class="form-control" name="lamp_foto_karyawan">
                        </div>

                                    <!-- Field 30: no_sk_kartap -->
                                    <div class="mb-4">
    <label for="no_sk_kartap" class="form-label">Nomor SK Kartu Pekerja</label>
    <input type="text" class="form-control" name="no_sk_kartap" id="no_sk_kartap" value="{{ old('no_sk_kartap', $dataPegawai->no_sk_kartap) }}" oninput="toggleKartapFields()">
</div>

<div class="mb-4" id="tanggal-kartap-field" style="display: none;">
    <label for="tanggal_kartap" class="form-label">Tanggal SK Kartu Pekerja</label>
    <input type="date" class="form-control" name="tanggal_kartap" value="{{ old('tanggal_kartap', $dataPegawai->tanggal_kartap) }}">
</div>

<div class="mb-4" id="lamp-sk-kartap-field" style="display: none;">
    <label for="lamp_sk_kartap" class="form-label">Lampirkan SK Kartu Pekerja</label>
    <input type="file" class="form-control" name="lamp_sk_kartap">
</div>
                        
                                    <!-- Field 32: no_sk_promut -->
                                    <div class="mb-4">
                                        <label for="no_sk_promut" class="form-label">Nomor SK Promosi Mutasi</label>
                                        <input type="text" class="form-control" name="no_sk_promut" id="no_sk_promut" value="{{ old('no_sk_promut', $dataPegawai->no_sk_promut) }}">
                                    </div>
                                    
                                    <!-- Field 33: tanggal_promut -->
                                    <div class="mb-4" id="tanggal_promut_field" style="display: none;">
                                        <label for="tanggal_promut" class="form-label">Tanggal SK Promosi Mutasi</label>
                                        <input type="date" class="form-control" name="tanggal_promut" value="{{ old('tanggal_promut', $dataPegawai->tanggal_promut) }}">
                                    </div>
                                    
                                    <div class="mb-4" id="lamp_sk_promut_field" style="display: none;">
                                        <label for="lamp_sk_promut" class="form-label">Lampirkan SK Promosi/Mutasi</label>
                                        <input type="file" class="form-control" name="lamp_sk_promut">
                                    </div>
                        
                                    <!-- Field 34: kode_divisi -->
                                    <div class="mb-4">
                                        <label for="kode_divisi" class="form-label">Kode Divisi</label>
                                        <input type="text" class="form-control" name="kode_divisi" value="{{ old('kode_divisi', $dataPegawai->kode_divisi) }}" >
                                    </div>
                        
                                    <!-- Field 35: nama_divisi -->
                                    <div class="mb-4">
                                        <label for="nama_divisi" class="form-label">Nama Divisi</label>
                                        <input type="text" class="form-control" name="nama_divisi" value="{{ old('nama_divisi', $dataPegawai->nama_divisi) }}" >
                                    </div>
                        
                                    <!-- Field 36: tgl_posisi -->
                                    <div class="mb-4">
                                        <label for="tgl_posisi" class="form-label">Tanggal Posisi</label>
                                        <input type="date" class="form-control" name="tgl_posisi" value="{{ old('tgl_posisi', $dataPegawai->tgl_posisi) }}" >
                                    </div>
                        
                                    <!-- Field 37: nama_kelompok_usia -->
                                    <div class="mb-4">
                                        <label for="nama_kelompok_usia" class="form-label">Nama Kelompok Usia</label>
                                        <input type="text" class="form-control" name="nama_kelompok_usia" value="{{ old('nama_kelompok_usia', $dataPegawai->nama_kelompok_usia) }}" >
                                    </div>
                        
                                    <!-- Field 38: kode_kelompok_usia -->
                                    <div class="mb-4">
                                        <label for="kode_kelompok_usia" class="form-label">Kode Kelompok Usia</label>
                                        <input type="text" class="form-control" name="kode_kelompok_usia" value="{{ old('kode_kelompok_usia', $dataPegawai->kode_kelompok_usia) }}" >
                                    </div>
                        
                                    <!-- Field 39: nama_employee_group -->
                                    <div class="mb-4">
                                        <label for="nama_employee_group" class="form-label">Nama Kelompok Karyawan</label>
                                        <input type="text" class="form-control" name="nama_employee_group" value="{{ old('nama_employee_group', $dataPegawai->nama_employee_group) }}" >
                                    </div>
                        
                                    <!-- Field 40: kota_kerja_now -->
                                    <div class="mb-4">
                                        <label for="kota_kerja_now" class="form-label">Kota Kerja Sekarang</label>
                                        <input type="text" class="form-control" name="kota_kerja_now" value="{{ old('kota_kerja_now', $dataPegawai->kota_kerja_now) }}" >
                                    </div>
                        
                                    <!-- Field 41: unit_kerja_now -->
                                    <div class="mb-4">
                                        <label for="unit_kerja_now" class="form-label">Unit Kerja Sekarang</label>
                                        <input type="text" class="form-control" name="unit_kerja_now" value="{{ old('unit_kerja_now', $dataPegawai->unit_kerja_now) }}" >
                                    </div>
                        
                                    <!-- Field 42: no_kontrak -->
                                    <div class="mb-4">
                                        <label for="no_kontrak" class="form-label">Nomor Kontrak</label>
                                        <input type="text" class="form-control" name="no_kontrak" value="{{ old('no_kontrak', $dataPegawai->no_kontrak) }}" >
                                    </div>
                        
                                    <!-- Field 43: mli_kontrak -->
                                    <div class="mb-4">
                                        <label for="mli_kontrak" class="form-label">MLI Kontrak</label>
                                        <input type="date" class="form-control" name="mli_kontrak" value="{{ old('mli_kontrak', $dataPegawai->mli_kontrak) }}" >
                                    </div>
                        
                                    <!-- Field 44: end_kontrak -->
                                    <div class="mb-4">
                                        <label for="end_kontrak" class="form-label">Akhir Kontrak</label>
                                        <input type="date" class="form-control" name="end_kontrak" value="{{ old('end_kontrak', $dataPegawai->end_kontrak) }}" >
                                    </div>

                                    <div class="mb-4">
                                        <label for="lamp_kontrak" class="form-label">Lampirkan Kontrak Kerja</label>
                                        <input type="file" class="form-control" name="lamp_kontrak">
                                    </div>
                        
                                    <!-- Field 45: formasi_jabatan -->
                                    <div class="mb-4">
                                        <label for="formasi_jabatan" class="form-label">Formasi Jabatan</label>
                                        <input type="text" class="form-control" name="formasi_jabatan" value="{{ old('formasi_jabatan', $dataPegawai->formasi_jabatan) }}" >
                                    </div>
                        
                                    <!-- Field 46: status_nikah -->
                                    <div class="mb-4">
    <label for="status_nikah" class="form-label">Status Nikah</label>
    <select class="form-control" name="status_nikah" id="status_nikah" onchange="toggleFields()">
        <option value="belum_nikah" {{ old('status_nikah', $dataPegawai->status_nikah) == 'belum_nikah' ? 'selected' : '' }}>Belum Nikah</option>
        <option value="nikah" {{ old('status_nikah', $dataPegawai->status_nikah) == 'nikah' ? 'selected' : '' }}>Nikah</option>
        <option value="cerai" {{ old('status_nikah', $dataPegawai->status_nikah) == 'cerai' ? 'selected' : '' }}>Cerai</option>
    </select>
</div>

<div id="married-fields" style="display: none;">
    <div class="mb-4">
        <label for="tanggal_nikah" class="form-label">Tanggal Nikah</label>
        <input type="date" class="form-control" name="tanggal_nikah" value="{{ old('tanggal_nikah', $dataPegawai->tanggal_nikah) }}">
    </div>
    <div class="mb-4">
        <label for="nama_suami_or_istri" class="form-label">Nama Suami/Istri</label>
        <input type="text" class="form-control" name="nama_suami_or_istri" value="{{ old('nama_suami_or_istri', $dataPegawai->nama_suami_or_istri) }}">
    </div>
    <div class="mb-4">
        <label for="nomor_hp_pasangan" class="form-label">Nomor HP Pasangan</label>
        <input type="text" class="form-control" name="nomor_hp_pasangan" value="{{ old('nomor_hp_pasangan', $dataPegawai->nomor_hp_pasangan) }}">
    </div>
    <div class="mb-4">
        <label for="lamp_buku_nikah" class="form-label">Lampirkan Buku Nikah</label>
        <input type="file" class="form-control" name="lamp_buku_nikah">
    </div>
</div>

<!-- Field for Children -->
<div id="children-fields" style="display: none;">
    <div class="mb-4">
        <label for="nama_anak_1" class="form-label">Nama Anak 1</label>
        <input type="text" class="form-control" id="nama_anak_1" name="nama_anak_1" oninput="toggleChildFields()" placeholder="Kosongkan jika tidak ada" value="{{ old('nama_anak_1', $dataPegawai->nama_anak_1) }}">
    </div>
    <div id="child-1-fields" style="display: none;">
        <div class="mb-4">
            <label for="tanggal_lahir_anak_1" class="form-label">Tanggal Lahir Anak 1</label>
            <input type="date" class="form-control" name="tgl_lahir_anak_1" value="{{ old('tgl_lahir_anak_1', $dataPegawai->tgl_lahir_anak_1) }}">
        </div>
    </div>
    <div id="lamp-akta-fields" style="display: none;">
    <div id="lamp-akta-1-field" style="display: none;">
        <div class="mb-4">
            <label for="lamp_akta_1" class="form-label">Lampirkan Akta Anak 1</label>
            <input type="file" class="form-control" name="lamp_akta_1" >
        </div>
    </div>
 
    <div class="mb-4">
        <label for="nama_anak_2" class="form-label">Nama Anak 2</label>
        <input type="text" class="form-control" id="nama_anak_2" name="nama_anak_2" oninput="toggleChildFields()" placeholder="Kosongkan jika tidak ada" value="{{ old('nama_anak_2', $dataPegawai->nama_anak_2) }}">
    </div>
    <div id="child-2-fields" style="display: none;">
        <div class="mb-4">
            <label for="tanggal_lahir_anak_2" class="form-label">Tanggal Lahir Anak 2</label>
            <input type="date" class="form-control" name="tgl_lahir_anak_2" value="{{ old('tgl_lahir_anak_2', $dataPegawai->tgl_lahir_anak_2) }}">
        </div>
    </div>
    <div id="lamp-akta-2-field" style="display: none;">
        <div class="mb-4">
            <label for="lamp_akta_2" class="form-label">Lampirkan Akta Anak 2</label>
            <input type="file" class="form-control" name="lamp_akta_2">
        </div>
    </div>

    <div class="mb-4">
        <label for="nama_anak_3" class="form-label">Nama Anak 3</label>
        <input type="text" class="form-control" id="nama_anak_3" name="nama_anak_3" oninput="toggleChildFields()" placeholder="Kosongkan jika tidak ada" value="{{ old('nama_anak_3', $dataPegawai->nama_anak_3) }}">
    </div>
    <div id="child-3-fields" style="display: none;">
        <div class="mb-4">
            <label for="tanggal_lahir_anak_3" class="form-label">Tanggal Lahir Anak 3</label>
            <input type="date" class="form-control" name="tgl_lahir_anak_3" value="{{ old('tgl_lahir_anak_3', $dataPegawai->tgl_lahir_anak_3) }}">
        </div>
    </div>
    <div id="lamp-akta-3-field" style="display: none;">
            <div class="mb-4">
                <label for="lamp_akta_3" class="form-label">Lampirkan Akta Anak 3</label>
                <input type="file" class="form-control" name="lamp_akta_3">
            </div>
        </div>
    </div>
</div>
<!-- Lampiran KTP Pasangan -->
<div class="mb-4" id="lamp_ktp_pasangan_field" style="display: none;">
    <label for="lamp_ktp_pasangan" class="form-label">Lampirkan KTP Pasangan</label>
    <input type="file" class="form-control" name="lamp_ktp_pasangan">
</div>

<div id="lamp-ktp-pasangan-field" style="display: none;">
    <div class="mb-4">
        <label for="lamp_ktp_pasangan" class="form-label">Lampirkan KTP Pasangan</label>
        <input type="file" class="form-control" name="lamp_ktp_pasangan">
    </div>
</div>
                                    <!-- Field 47: tanggal_nikah -->
                                    
                        
                                    <!-- Field 48: tang_kel -->
                                    <div class="mb-4">
                                        <label for="tang_kel" class="form-label">Tanggal Kelahiran</label>
                                        <input type="date" class="form-control" name="tang_kel" value="{{ old('tang_kel', $dataPegawai->tang_kel) }}" >
                                    </div>
                        
                                    <div class="mb-4">
    <label for="no_kk" class="form-label">Nomor KK</label>
    <input type="text" 
           class="form-control" 
           name="no_kk" 
           id="no_kk" 
           oninput="validateNoKK()" 
           maxlength="16" 
           minlength="16" 
           pattern="\d{16}" 
           title="Nomor KK harus terdiri dari 16 digit angka" 
           value="{{ old('no_kk', $dataPegawai->no_kk) }}">
    <small id="kk_note" style="color: red; display: none;">Nomor KK harus terdiri dari 16 digit angka</small>
</div>

<div class="mb-4" id="lamp_kk" style="display: none;">
    <label for="lamp_kk" class="form-label">Lampirkan Kartu Keluarga</label>
    <input type="file" class="form-control" name="lamp_kk">
</div>
                        
                                    <!-- Field 50: nama_suami_or_istri -->
                                    
                        
                                    <!-- Field 58: nama_ayah_kandung -->
                                    <div class="mb-4">
                                        <label for="nama_ayah_kandung" class="form-label">Nama Ayah Kandung</label>
                                        <input type="text" class="form-control" name="nama_ayah_kandung" value="{{ old('nama_ayah_kandung', $dataPegawai->nama_ayah_kandung) }}">
                                    </div>
                        
                                    <!-- Field 59: nama_ibu_kandung -->
                                    <div class="mb-4">
                                        <label for="nama_ibu_kandung" class="form-label">Nama Ibu Kandung</label>
                                        <input type="text" class="form-control" name="nama_ibu_kandung" value="{{ old('nama_ibu_kandung', $dataPegawai->nama_ibu_kandung) }}">
                                    </div>
                        
                                    <!-- Field 60: no_bpjs_kes -->
                                    <div class="mb-4">
    <label for="no_bpjs_kes" class="form-label">Nomor BPJS Kesehatan</label>
    <input type="text" class="form-control" name="no_bpjs_kes" id="no_bpjs_kes" oninput="toggleBpjsFields()" value="{{ old('no_bpjs_kes', $dataPegawai->no_bpjs_kes) }}">
    <span id="bpjs-kes-error-message" style="color: red; font-size: 0.9em; display: none;">Nomor BPJS Kesehatan minimal 13 karakter.</span>
</div>

<!-- Field 73: lamp_bpjs_kes -->
<div class="mb-4" id="lamp_bpjs_kes_field" style="display: none;">
    <label for="lamp_bpjs_kes" class="form-label">Lampirkan BPJS Kesehatan</label>
    <input type="file" class="form-control" name="lamp_bpjs_kes">
</div>
<div class="mb-4">
    <label for="no_bpjs_ket" class="form-label">Nomor BPJS Tenaga Kerja</label>
    <input type="text" class="form-control" name="no_bpjs_ket" id="no_bpjs_ket" oninput="toggleBpjsFields()" value="{{ old('no_bpjs_tk', $dataPegawai->no_bpjs_ket) }}">
    <span id="bpjs-ket-error-message" style="color: red; font-size: 0.9em; display: none;">Nomor BPJS Tenaga Kerja minimal 11 karakter.</span>
</div>

<!-- Field 74: lamp_bpjs_tk -->
<div class="mb-4" id="lamp_bpjs_tk_field" style="display: none;">
    <label for="lamp_bpjs_tk" class="form-label">Lampirkan BPJS Tenaga Kerja</label>
    <input type="file" class="form-control" name="lamp_bpjs_tk">
</div>

                        
                                    <!-- Field 62: no_telkomedika -->
                                    <div class="mb-4">
                                        <label for="no_telkomedika" class="form-label">Nomor Telkomedika</label>
                                        <input type="text" class="form-control" name="no_telkomedika" value="{{ old('no_telkomedika', $dataPegawai->no_telkomedika) }}">
                                    </div>
                        
                                    <!-- Field 63: npwp -->
                                    <div class="mb-4">
    <label for="npwp" class="form-label">Nomor NPWP</label>
    <input type="text" 
           class="form-control" 
           name="npwp" 
           id="npwp" 
           value="{{ old('npwp', $dataPegawai->npwp) }}" 
           oninput="formatNpwpField()" 
           maxlength="19" 
           title="Nomor NPWP harus terdiri dari 15 digit angka">
    <small id="npwp-note" class="text-muted" style="display: none;">Masukkan 15 digit.</small>
</div>

<div class="mb-4" id="lamp-kartu-npwp-field" style="display: none;">
    <label for="lamp_kartu_npwp" class="form-label">Lampirkan Kartu NPWP</label>
    <input type="file" class="form-control" name="lamp_kartu_npwp">
</div>

                        
                                    <!-- Field 64: nama_bank -->
                                    <div class="mb-4">
    <label for="no_rekening" class="form-label">Nomor Rekening</label>
    <input type="text" class="form-control" name="no_rekening" id="no_rekening" oninput="toggleBankFields()" value="{{ old('npwp', $dataPegawai->no_rekening) }}">
    <!-- Note about minimum length -->
    <small id="no_rekening_note" class="form-text text-muted" style="display: none;">Nomor Rekening minimal 10 digit</small>
</div>

<div class="mb-4" id="nama_bank_field" style="display: none;">
    <label for="nama_bank" class="form-label">Nama Bank</label>
    <select class="form-control" name="nama_bank" id="nama_bank" oninput="toggleBankFields()">
        <option value="{{ old('npwp', $dataPegawai->nama_bank) }}">Pilih Nama Bank</option>
        <option value="Bank Mandiri">Bank Mandiri</option>
        <option value="Bank Negara Indonesia">Bank Negara Indonesia (BNI)</option>
        <option value="Bank Rakyat Indonesia">Bank Rakyat Indonesia (BRI)</option>
        <option value="Bank Tabungan Negara">Bank Tabungan Negara (BTN)</option>
        <option value="Bank Central Asia">Bank Central Asia (BCA)</option>
        <option value="Bank CIMB Niaga">Bank CIMB Niaga</option>
        <option value="Bank Danamon Indonesia">Bank Danamon Indonesia</option>
        <option value="Bank Mega">Bank Mega</option>
        <option value="Bank Maybank">Bank Maybank Indonesia</option>
        <option value="Panin Bank">Panin Bank</option>
        <option value="Bank OCBC NISP">Bank OCBC NISP</option>
        <option value="Bank Permata">Bank Permata</option>
        <option value="Bank Sinarmas">Bank Sinarmas</option>
        <option value="Bank UOB Indonesia">Bank UOB Indonesia</option>
        <option value="lainnya">Lainnya...</option> <!-- Opsi lainnya -->
    </select>
</div>

<!-- Input untuk "lainnya" jika opsi Lainnya dipilih -->
<div class="mb-4" id="customBankInput" style="display: none;">
    <label for="customBank" class="form-label">Masukkan Nama Bank</label>
    <input type="text" class="form-control" id="customBank" name="nama_bank">
</div>


<div class="mb-4" id="nama_rekening_field" style="display: none;">
    <label for="nama_rekening" class="form-label">Nama Pemilik Rekening</label>
    <input type="text" class="form-control" name="nama_rekening" id="nama_rekening" oninput="toggleBankFields()">
</div>

<div class="mb-4" id="lamp_buku_rekening_field" style="display: none;">
    <label for="lamp_buku_rekening" class="form-label">Lampirkan Buku Rekening</label>
    <input type="file" class="form-control" name="lamp_buku_rekening">
</div>
                        
                                    <!-- Field 67: lamp_buku_nikah -->
                                    
                                    <!-- Field 68: lamp_kk -->
                        
                                    <!-- Field 75: lamp_kartu_npwp -->
                                    
                                    <!-- Field 76: lamp_buku_rekening -->
                                    
                                    <!-- Field 77: avatar_karyawan -->
                                    
                                    <!-- Field 78: lamp_ktp -->
                                    
                                    <!-- Field 79: lamp_sk_kartap -->

                                    <!-- Field 80: lamp_sk_promut -->
                                    

                                    <!-- Field 81: lamp_kontrak -->
                                    

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            <a href="{{ route('data-pegawai.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Fungsi untuk mengambil dan menampilkan kabupaten berdasarkan provinsi
function getKabupaten(id_prov) {
    const kabupatenDropdown = document.getElementById('kab_kot');
    kabupatenDropdown.innerHTML = '<option value="">Memuat...</option>'; // Tampilkan status loading

    if (id_prov) {
        fetch(/location/kabupaten/${id_prov})
            .then(response => response.json())
            .then(data => {
                kabupatenDropdown.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                data.forEach(kab => {
                    const option = document.createElement('option');
                    option.value = kab.id_kab;
                    option.textContent = kab.nama;
                    kabupatenDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching kabupaten:', error);
                kabupatenDropdown.innerHTML = '<option value="">Gagal memuat data</option>';
            });
    } else {
        kabupatenDropdown.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
    }
}

// Fungsi untuk mengambil dan menampilkan kecamatan berdasarkan kabupaten
function getKecamatan(id_kab) {
    const kecamatanDropdown = document.getElementById('kec');
    kecamatanDropdown.innerHTML = '<option value="">Memuat...</option>'; // Tampilkan status loading

    if (id_kab) {
        fetch(/location/kecamatan/${id_kab})
            .then(response => response.json())
            .then(data => {
                kecamatanDropdown.innerHTML = '<option value="">Pilih Kecamatan</option>';
                data.forEach(kec => {
                    const option = document.createElement('option');
                    option.value = kec.id_kec;
                    option.textContent = kec.nama;
                    kecamatanDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching kecamatan:', error);
                kecamatanDropdown.innerHTML = '<option value="">Gagal memuat data</option>';
            });
    } else {
        kecamatanDropdown.innerHTML = '<option value="">Pilih Kecamatan</option>';
    }
}

// Fungsi untuk mengambil dan menampilkan kelurahan berdasarkan kecamatan
function getKelurahan(id_kec) {
    const kelurahanDropdown = document.getElementById('des_kel');
    kelurahanDropdown.innerHTML = '<option value="">Memuat...</option>'; // Tampilkan status loading

    if (id_kec) {
        fetch(/location/kelurahan/${id_kec})
            .then(response => response.json())
            .then(data => {
                kelurahanDropdown.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                data.forEach(kel => {
                    const option = document.createElement('option');
                    option.value = kel.id_kel;
                    option.textContent = kel.nama;
                    kelurahanDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching kelurahan:', error);
                kelurahanDropdown.innerHTML = '<option value="">Gagal memuat data</option>';
            });
    } else {
        kelurahanDropdown.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
    }
}
function toggleFields() {
    const statusNikah = document.getElementById('status_nikah').value;
    const marriedFields = document.getElementById('married-fields');
    const childrenFields = document.getElementById('children-fields');
    const lampKtpPasanganField = document.getElementById('lamp-ktp-pasangan-field');
    const lampAktaFields = document.getElementById('lamp-akta-fields');
    const tanggalNikahField = document.getElementById('tanggal-nikah-field'); // Elemen Tanggal Nikah

    if (statusNikah === 'nikah') {
        marriedFields.style.display = 'block';
        childrenFields.style.display = 'block'; // Tampilkan field anak jika status Nikah
        lampKtpPasanganField.style.display = 'block';
        lampAktaFields.style.display = 'block';
        tanggalNikahField.style.display = 'block'; // Tampilkan jika status Nikah
    } else {
        marriedFields.style.display = 'none';
        childrenFields.style.display = 'none'; // Sembunyikan field anak jika bukan Nikah
        lampKtpPasanganField.style.display = 'none';
        lampAktaFields.style.display = 'none';
        tanggalNikahField.style.display = 'none'; // Sembunyikan jika bukan Nikah
    }
}

function toggleChildFields() {
    const namaAnak1 = document.getElementById('nama_anak_1').value.trim();
    const namaAnak2 = document.getElementById('nama_anak_2').value.trim();
    const namaAnak3 = document.getElementById('nama_anak_3').value.trim();

    const child1Fields = document.getElementById('child-1-fields');
    const child2Fields = document.getElementById('child-2-fields');
    const child3Fields = document.getElementById('child-3-fields');
    const lampAkta1Field = document.getElementById('lamp-akta-1-field');
    const lampAkta2Field = document.getElementById('lamp-akta-2-field');
    const lampAkta3Field = document.getElementById('lamp-akta-3-field');

    // Field Anak 1
    child1Fields.style.display = namaAnak1 ? 'block' : 'none';
    lampAkta1Field.style.display = namaAnak1 ? 'block' : 'none';

    // Field Anak 2
    child2Fields.style.display = namaAnak2 ? 'block' : 'none';
    lampAkta2Field.style.display = namaAnak2 ? 'block' : 'none';

    // Field Anak 3
    child3Fields.style.display = namaAnak3 ? 'block' : 'none';
    lampAkta3Field.style.display = namaAnak3 ? 'block' : 'none';
}


// Set default visibility on page load
document.addEventListener('DOMContentLoaded', () => {
    toggleFields();
    toggleChildFields();
});

function toggleKtpAttachmentField() {
    const nomorKtp = document.getElementById('nomor_ktp').value;
    const lampKtpField = document.getElementById('lamp-ktp-field');
    const errorMessage = document.getElementById('ktp-error-message');
    const lampirkanFotoMessage = document.getElementById('lampirkan-foto-message');
    const tooLongMessage = document.getElementById('ktp-too-long-message');

    // Cek panjang input Nomor KTP
    if (nomorKtp.length === 16) {
        lampKtpField.style.display = 'block'; // Tampilkan field lampiran KTP
        errorMessage.style.display = 'none'; // Sembunyikan pesan error
        lampirkanFotoMessage.style.display = 'block'; // Tampilkan pesan lampirkan foto KTP
        tooLongMessage.style.display = 'none'; // Sembunyikan pesan terlalu banyak karakter
    } else if (nomorKtp.length < 16) {
        lampKtpField.style.display = 'none'; // Sembunyikan field lampiran KTP
        errorMessage.style.display = 'block'; // Tampilkan pesan error
        lampirkanFotoMessage.style.display = 'none'; // Sembunyikan pesan lampirkan foto KTP
        tooLongMessage.style.display = 'none'; // Sembunyikan pesan terlalu banyak karakter
    } else if (nomorKtp.length > 16) {
        lampKtpField.style.display = 'none'; // Sembunyikan field lampiran KTP
        errorMessage.style.display = 'none'; // Sembunyikan pesan error
        lampirkanFotoMessage.style.display = 'none'; // Sembunyikan pesan lampirkan foto KTP
        tooLongMessage.style.display = 'block'; // Tampilkan pesan terlalu banyak karakter
    }
}

function toggleBpjsFields() {
    const noBpjsKes = document.getElementById('no_bpjs_kes').value;
    const noBpjsKet = document.getElementById('no_bpjs_ket').value;

    const lampBpjsKesField = document.getElementById('lamp_bpjs_kes_field');
    const lampBpjsTkField = document.getElementById('lamp_bpjs_tk_field');
    
    const bpjsKesErrorMessage = document.getElementById('bpjs-kes-error-message');
    const bpjsTkErrorMessage = document.getElementById('bpjs-ket-error-message');

    // Cek panjang input Nomor BPJS Kesehatan
    if (noBpjsKes.length >= 13) {
        lampBpjsKesField.style.display = 'block'; // Tampilkan field lampiran BPJS Kesehatan
        bpjsKesErrorMessage.style.display = 'none'; // Sembunyikan pesan error
    } else {
        lampBpjsKesField.style.display = 'none'; // Sembunyikan field lampiran BPJS Kesehatan
        bpjsKesErrorMessage.style.display = 'block'; // Tampilkan pesan error
    }

    // Cek panjang input Nomor BPJS Tenaga Kerja
    if (noBpjsKet.length >= 11) {
        lampBpjsTkField.style.display = 'block'; // Tampilkan field lampiran BPJS Tenaga Kerja
        bpjsTkErrorMessage.style.display = 'none'; // Sembunyikan pesan error
    } else {
        lampBpjsTkField.style.display = 'none'; // Sembunyikan field lampiran BPJS Tenaga Kerja
        bpjsTkErrorMessage.style.display = 'block'; // Tampilkan pesan error
    }
}

function toggleBankFields() {
    const noRekening = document.getElementById('no_rekening').value;
    const namaBankField = document.getElementById('nama_bank_field');
    const namaRekeningField = document.getElementById('nama_rekening_field');
    const lampBukuRekeningField = document.getElementById('lamp_buku_rekening_field');
    const noRekeningNote = document.getElementById('no_rekening_note'); // Catatan minimal 10 digit

    // Menampilkan atau menyembunyikan catatan tergantung pada panjang Nomor Rekening
    if (noRekening.length > 0 && noRekening.length < 10) {
        noRekeningNote.style.display = 'inline'; // Tampilkan catatan jika kurang dari 10 digit
    } else {
        noRekeningNote.style.display = 'none'; // Sembunyikan catatan jika sudah cukup 10 digit atau lebih
    }

    // Jika Nomor Rekening diisi, tampilkan Nama Bank
    if (noRekening.length >= 10) {
        namaBankField.style.display = 'block';
    } else {
        namaBankField.style.display = 'none';
        namaRekeningField.style.display = 'none';
        lampBukuRekeningField.style.display = 'none';
    }

    // Jika Nama Bank diisi, tampilkan Nama Pemilik Rekening
    const namaBank = document.getElementById('nama_bank').value;
    if (namaBank.length > 0) {
        namaRekeningField.style.display = 'block';
    } else {
        namaRekeningField.style.display = 'none';
        lampBukuRekeningField.style.display = 'none';
    }

    // Jika Nama Pemilik Rekening diisi, tampilkan Lampiran Buku Rekening
    const bukuRekening = document.getElementById('lamp_buku_rekening').value;
    if (namaRekening.length > 0) {
        lampBukuRekeningField.style.display = 'block';
    } else {
        lampBukuRekeningField.style.display = 'none';
    }
}
function validateNoKK() {
        var noKK = document.getElementById('no_kk').value;
        var kkNote = document.getElementById('kk_note');
        var lampKKField = document.getElementById('lamp_kk');

        // Validasi panjang dan format angka
        var isValidLength = noKK.length === 16;
        var isNumeric = /^\d+$/.test(noKK);

        if (isValidLength && isNumeric) {
            // Menampilkan field lampiran KK jika valid
            lampKKField.style.display = 'block';
            kkNote.style.display = 'none';
        } else {
            // Menyembunyikan field lampiran KK jika tidak valid
            lampKKField.style.display = 'none';
            // Menampilkan note jika input tidak valid
            if (noKK.length > 0) {
                kkNote.style.display = 'inline';
            } else {
                kkNote.style.display = 'none';
            }
        }
    }

    function formatNpwpField() {
        const npwpField = document.getElementById('npwp');
        const lampKartuNpwpField = document.getElementById('lamp-kartu-npwp-field');
        const npwpNote = document.getElementById('npwp-note');

        // Hapus semua karakter non-digit
        let npwpValue = npwpField.value.replace(/\D/g, '');
        
        // Batasi panjang maksimal 15 digit
        if (npwpValue.length > 15) {
            npwpValue = npwpValue.substring(0, 15);
        }

        // Terapkan format 12.345.678.9-999
        let formattedNpwp = npwpValue
            .replace(/(\d{2})(\d{3})(\d{3})(\d{1})(\d{3})/, '$1.$2.$3.$4-$5');

        // Update nilai field dengan format
        npwpField.value = formattedNpwp;

        // Validasi panjang NPWP
        if (npwpValue.length === 15) {
            lampKartuNpwpField.style.display = 'block'; // Tampilkan lampiran NPWP
            npwpNote.style.display = 'block'; // Tampilkan note
            npwpNote.textContent = "Lampirkan NPWP Anda."; // Ubah isi catatan
        } else {
            lampKartuNpwpField.style.display = 'none'; // Sembunyikan lampiran NPWP
            npwpNote.style.display = 'block'; // Tampilkan note
            npwpNote.textContent = "Masukkan 15 digit."; // Ubah isi catatan
        }
    }

function toggleKartapFields() {
    const noSkKartapField = document.getElementById('no_sk_kartap');
    const tanggalKartapField = document.getElementById('tanggal-kartap-field');
    const lampSkKartapField = document.getElementById('lamp-sk-kartap-field');

    const noSkKartapValue = noSkKartapField.value.trim();

    if (noSkKartapValue) {
        // Jika field nomor SK diisi
        tanggalKartapField.style.display = 'block'; // Tampilkan Tanggal SK
        lampSkKartapField.style.display = 'block'; // Tampilkan Lampiran SK
    } else {
        // Jika field nomor SK kosong
        tanggalKartapField.style.display = 'none'; // Sembunyikan Tanggal SK
        lampSkKartapField.style.display = 'none'; // Sembunyikan Lampiran SK
    }
}

function toggleBankFields() {
        var selectedValue = document.getElementById("nama_bank").value;
        var customBankInput = document.getElementById("customBankInput");
        var namaBankField = document.getElementById("nama_bank_field");

        // Menyembunyikan atau menampilkan input teks berdasarkan pilihan
        if (selectedValue === "lainnya") {
            customBankInput.style.display = "block"; // Menampilkan input teks untuk nama bank lain
        } else {
            customBankInput.style.display = "none"; // Menyembunyikan input teks jika tidak memilih "lainnya"
        }
        
        // Menampilkan field nama bank jika nilai dipilih selain "Pilih Nama Bank"
        if (selectedValue !== "Pilih Nama Bank") {
            namaBankField.style.display = "block";
        } else {
            namaBankField.style.display = "none";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
    const noSkPromutField = document.getElementById("no_sk_promut");
    const tanggalPromutField = document.getElementById("tanggal_promut_field");
    const lampSkPromutField = document.getElementById("lamp_sk_promut_field");

    // Fungsi untuk mengatur visibilitas elemen tanggal dan lampiran
    function toggleFields() {
        if (noSkPromutField.value.trim() !== "") {
            // Menampilkan elemen tanggal dan lampiran SK
            tanggalPromutField.style.display = "block";
            lampSkPromutField.style.display = "block";
        } else {
            // Menyembunyikan elemen tanggal dan lampiran SK
            tanggalPromutField.style.display = "none";
            lampSkPromutField.style.display = "none";
        }
    }

    // Jalankan fungsi saat halaman dimuat untuk memastikan kondisi awal
    toggleFields();

    // Event listener untuk mendeteksi perubahan di input nomor SK
    noSkPromutField.addEventListener("input", toggleFields);
});

</script>
@endsection

@section('head')
<!-- Styling tambahan untuk form -->
<style>

.hidden {
    display: none;
}

    .container {
        max-width: 100%;  /* Menyesuaikan container dengan lebar layar */
        padding: 0;  /* Menghilangkan padding agar lebih penuh */
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);  /* Menambah shadow untuk efek kedalaman */
    }

    .card-header {
        background-color: #007bff;
        border-radius: 15px 15px 0 0;
        text-align: center;
        padding: 20px;
        font-size: 1.5rem;
    }

    .form-label {
        font-weight: bold;
        color: #333;
    }

    .form-control, .form-select {
        border-radius: 0.5rem;
        border: 1px solid #ced4da;
        padding: 12px;
        font-size: 1rem;  /* Menambah ukuran font agar lebih mudah dibaca */
    }

    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.25);
    }

    .btn {
        padding: 12px 25px;
        font-size: 1.1rem;
        border-radius: 10px;
        width: 48%;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .mb-4 {
        margin-bottom: 1.75rem;
    }

    .d-flex {
        flex-wrap: wrap;  /* Memastikan tombol tidak terlalu rapat */
    }

    .col-lg-10 {
        max-width: 85%;  /* Menambah lebar form pada layar besar */
    }
</style>
@endsection