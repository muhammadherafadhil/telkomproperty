@extends('welcome')

@section('title', 'Halaman Dashboard')

@section('content')

<!-- Meta Tag CSRF Token -->
<!-- Meta Tag CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="log-history-container">
    <h2 class="log-title">Riwayat Aktivitas Pegawai</h2>

    @if($logs->isEmpty())
        <div class="no-logs-message">
            <p>Belum ada riwayat aktivitas yang tercatat.</p>
        </div>
    @else
        <div class="log-feed">
            @php
                $seenCreatedAt = [];
            @endphp

            @foreach ($logs as $log)
                @php
                    if (in_array($log->created_at, $seenCreatedAt)) {
                        continue;
                    }
                    $seenCreatedAt[] = $log->created_at;

                    $oldData = json_decode($log->old_data, true) ?? [];
                    $newData = json_decode($log->new_data, true) ?? [];
                    $changes = [];

                    foreach ($oldData as $key => $value) {
                        if (isset($newData[$key]) && $value != $newData[$key]) {
                            if ($key === 'lamp_foto_karyawan') {
                                $changes[] = "<strong>Foto Karyawan:</strong><br>
                                    <div class='photo-comparison'>
                                        <img src='/storage/{$value}' alt='Foto Sebelum' class='employee-photo'>
                                        <span>→</span>
                                        <img src='/storage/{$newData[$key]}' alt='Foto Setelah' class='employee-photo'>
                                    </div>";
                            } elseif (preg_match('/lamp_|avatar_karyawan/', $key)) {
                                $oldFileName = pathinfo($value, PATHINFO_BASENAME);
                                $newFileName = pathinfo($newData[$key], PATHINFO_BASENAME);
                                
                                $changes[] = "<strong>Perubahan Lampiran:</strong> 
                                    <span class='old-file'>{$oldFileName}</span> → 
                                    <span class='new-file'>{$newFileName}</span>
                                    <br>
                                    <a href='/storage/{$value}' class='btn btn-link' target='_blank'>Lihat Lampiran Sebelumnya</a>
                                    <span> | </span>
                                    <a href='/storage/{$newData[$key]}' class='btn btn-link' target='_blank'>Lihat Lampiran Baru</a>";
                            } else {
                                $changes[] = "<strong>" . ucfirst(str_replace('_', ' ', $key)) . "</strong>: 
                                    <span class='old-value'>{$value}</span> → 
                                    <span class='new-value'>{$newData[$key]}</span>";
                            }
                        }
                    }
                @endphp

                <div class="log-card">
                    <div class="log-header">
                        <div class="log-info">
                            <img class="employee-profile-photo" src="{{ Storage::url($log->dataPegawai->profile_photo_url ?? 'default-profile.jpg') }}" alt="Foto Profil" width="100">
                            <span class="log-user">{{ $log->dataPegawai->nama_lengkap ?? 'Pegawai Tidak Diketahui' }}</span>
                            <span class="log-time">{{ $log->created_at->format('d-m-Y H:i:s') }}</span>
                        </div>
                        <span class="log-action">{{ ucfirst($log->action) }}</span>
                    </div>

                    <div class="log-body">
                        <p class="log-description">{{ $log->name ?? 'Melakukan perubahan' }}</p>

                        @if (!empty($changes))
                            <ul class="log-changes">
                                @foreach ($changes as $change)
                                    <li class="log-item">{!! $change !!}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="no-changes-message">Tidak ada perubahan signifikan yang tercatat.</p>
                        @endif
                    </div>

                    <div class="like-section">
                        <button class="like-btn {{ $log->likes->where('user_id', Auth::id())->isNotEmpty() ? 'liked' : '' }}" data-log-id="{{ $log->id }}">
                            ❤️ <span class="like-count">{{ $log->likes->count() }}</span> {{ $log->likes->where('user_id', Auth::id())->isNotEmpty() ? 'Unlike' : 'Like' }}
                        </button>
                    </div>

                    <div class="comment-section">
                        <form action="{{ route('logs.comment', $log->id) }}" method="POST">
                            @csrf
                            <input type="text" name="comment" placeholder="Tulis komentar..." required>
                            <button type="submit">Kirim</button>
                        </form>

                        <ul class="comments">
                            @foreach ($log->comments as $comment)
                                <li class="comment-item">
                                    <strong>{{ $comment->user->dataPegawai->nama_lengkap ?? 'User Tidak Diketahui' }}:</strong>
                                    <span class="comment-text">{{ $comment->comment }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Pagination Section -->
<div class="pagination-container">
    <div class="pagination">
        <a href="{{ $logs->previousPageUrl() }}" class="page-btn {{ $logs->onFirstPage() ? 'disabled' : '' }}">← Sebelumnya</a>

        <span class="page-indicators">
            @for ($i = 1; $i <= $logs->lastPage(); $i++)
                <a href="{{ $logs->url($i) }}" class="page-btn {{ $i == $logs->currentPage() ? 'active' : '' }}">{{ $i }}</a>
            @endfor
        </span>

        <a href="{{ $logs->nextPageUrl() }}" class="page-btn {{ !$logs->hasMorePages() ? 'disabled' : '' }}">Selanjutnya →</a>
    </div>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function loadLogs(url) {
        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function() {
                $('.log-feed').addClass('loading');
            },
            success: function(response) {
                let newContent = $(response).find('.log-feed').html();
                let paginationLinks = $(response).find('.pagination').html();
                $('.log-feed').html(newContent);
                $('.pagination').html(paginationLinks);
            },
            error: function() {
                alert("Gagal memuat halaman. Coba lagi.");
            },
            complete: function() {
                $('.log-feed').removeClass('loading');
            }
        });
    }

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if (url) {
            loadLogs(url);
        }
    });

    $(document).on('click', '.like-btn', function() {
        let button = $(this);
        let logId = button.data('log-id');
        button.prop('disabled', true);

        $.ajax({
            url: '/logs/' + logId + '/like',
            type: 'POST',
            success: function(response) {
                if (response.status === 'liked') {
                    button.addClass('liked').html('❤️ Unlike <span class="like-count">' + response.likes + '</span>');
                } else {
                    button.removeClass('liked').html('❤️ Like <span class="like-count">' + response.likes + '</span>');
                }
                localStorage.setItem('log_like_' + logId, response.status);
            },
            error: function() {
                alert("Gagal memperbarui like. Silakan coba lagi.");
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    });

    $('.like-btn').each(function() {
        let button = $(this);
        let logId = button.data('log-id');
        let status = localStorage.getItem('log_like_' + logId);
        if (status === 'liked') {
            button.addClass('liked').html('❤️ Unlike <span class="like-count">' + button.data('likes') + '</span>');
        }
    });

    $(document).on('click', '.validate-btn', function() {
        let logId = $(this).data('id');
        let status = $(this).data('status');
        
        $.ajax({
            url: '/logs/' + logId + '/validate',
            type: 'POST',
            data: { status: status },
            success: function() {
                alert('Validasi berhasil: ' + status);
                location.reload();
            },
            error: function() {
                alert("Gagal memvalidasi. Coba lagi.");
            }
        });
    });

    $(document).on('submit', '.comment-form', function(e) {
        e.preventDefault();
        let form = $(this);
        let formData = form.serialize();
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            success: function() {
                form.find('input[name="comment"]').val('');
                location.reload();
            },
            error: function() {
                alert("Gagal menambahkan komentar. Coba lagi.");
            }
        });
    });

    function showFullImageViewer(imageElement) {
        let fullImageUrl = imageElement.src;
        let fullImageViewer = $('<div class="full-image-viewer">')
            .append($('<img>').attr('src', fullImageUrl).addClass('full-image'));
        
        $('body').append(fullImageViewer);
        $('.full-image-viewer').on('click', function() {
            $(this).remove();
        });
    }

    $(document).on('click', '.employee-photo', function() {
        showFullImageViewer(this);
    });

    $(document).on('change', '.employee-photo-input', function() {
        let file = this.files[0];
        if (file) {
            let allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('Hanya file gambar (jpg, png, gif) yang diperbolehkan');
                this.value = '';
                return;
            }
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = new Image();
                img.src = e.target.result;
                img.onload = function() {
                    if (this.width > 2000 || this.height > 2000) {
                        alert('Ukuran gambar terlalu besar. Maksimal 2000x2000 pixel');
                        this.value = '';
                    }
                };
            };
            reader.readAsDataURL(file);
        }
    });
});

</script>


<style>
    /* Global Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .log-history-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .log-title {
        text-align: center;
        font-size: 36px;
        font-weight: bold;
        color: #2980b9;
        margin-bottom: 20px;
    }

    .no-logs-message {
        text-align: center;
        font-size: 18px;
        color: #7f8c8d;
    }

    /* Log Feed */
    .log-feed {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    /* Log Card Styles */
    .log-card {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .log-card:hover {
        transform: translateY(-5px);
    }

    /* Log Header Styles */
    .log-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .log-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .log-user {
        font-weight: bold;
        font-size: 16px;
        color: #2980b9;
    }

    .log-time {
        font-size: 14px;
        color: #95a5a6;
    }

    .log-action {
        font-weight: bold;
        font-size: 16px;
        color: #27ae60;
    }

    /* Log Body */
    .log-body {
        margin-top: 15px;
    }

    .log-description {
        font-size: 16px;
        color: #333;
    }

    /* Changes List */
    .log-changes {
        margin-top: 10px;
        padding: 15px;
        background-color: #ecf0f1;
        border-radius: 8px;
        list-style-type: none;
    }

    .log-item {
        font-size: 14px;
        color: #34495e;
        margin-bottom: 5px;
    }

    .old-value {
        color: #e74c3c;
    }

    .new-value {
        color: #2ecc71;
    }

    /* Profile Photo */
    .profile-photo {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    /* Attachment Photos */
    .attachment-gallery {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .attachment-photo {
        width: 20px; /* Ukuran lampiran gambar */
        height: 20px; /* Ukuran lampiran gambar */
        object-fit: cover; /* Memastikan foto tidak terdistorsi */
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    /* Profile Photo Before & After */
    .profile-photo-change {
        margin-top: 25px;
        display: flex;
        gap: 25px;
    }

    .profile-photo-change img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
    }

    /* Pagination */
    .pagination-container {
        margin-top: 30px;
        text-align: center;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .page-btn {
        padding: 10px 20px;
        background-color: #3498db;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .page-btn.disabled {
        background-color: #bdc3c7;
        cursor: not-allowed;
    }

    .page-btn.active {
        background-color: #2ecc71;
    }

    .page-btn:hover:not(.disabled) {
        background-color: #2980b9;
    }

    /* Buttons */
    .like-btn, .check-btn, .cross-btn {
        padding: 12px 18px;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .like-btn {
        background-color: #ff5722;
        color: white;
    }

    .like-btn.liked {
        background-color: #e74c3c;
    }

    .check-btn {
        background-color: #4caf50;
        color: white;
    }

    .cross-btn {
        background-color: #f44336;
        color: white;
    }

    .like-btn:hover, .check-btn:hover, .cross-btn:hover {
        opacity: 0.8;
        transform: scale(1.05);
    }

    /* Comment Section */
    .comment-section {
        margin-top: 20px;
    }

    .comment-section form {
        display: flex;
        gap: 10px;
    }

    .comment-section input {
        flex: 1;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    .comment-section button {
        padding: 10px 15px;
        background-color: #27ae60;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .comment-section button:hover {
        background-color: #2ecc71;
    }

    .comment-section ul {
        margin-top: 10px;
        list-style: none;
        padding: 0;
    }

    .comment-section li {
        font-size: 14px;
        padding: 8px 0;
        border-bottom: 1px solid #f1f1f1;
        background-color: #f9f9f9;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .log-history-container {
            padding: 15px;
        }

        .log-title {
            font-size: 28px;
        }

        .log-feed {
            gap: 15px;
        }

        .log-card {
            padding: 15px;
        }

        .pagination-container {
            margin-top: 20px;
        }
    }

    /* Additional Styles */
    .photo-comparison {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .employee-photo {
        width: 80px; /* Ukuran foto karyawan */
        height: 80px; /* Ukuran foto karyawan */
        object-fit: cover; /* Memastikan foto tidak terdistorsi */
        margin: 0 5px; /* Jarak antar foto */
    }

    .profile-photo-before, .profile-photo-after {
        width: 100px; /* Ukuran foto profil */
        height: 100px; /* Ukuran foto profil */
        object-fit: cover; /* Memastikan foto tidak terdistorsi */
        margin: 0 5px; /* Jarak antar foto */
    }

    .lampiran-image {
        width: 20px; /* Ukuran lampiran gambar */
        height: 20px; /* Ukuran lampiran gambar */
        object-fit: cover; /* Memastikan foto tidak terdistorsi */
        margin: 0 5px; /* Jarak antar gambar */
    }

    .full-image-viewer {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .full-image {
        max-width: 90%;
        max-height: 90%;
    }

    /* File Link Styles */
    .file-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #2980b9;
    }

    .file-link:hover {
        text-decoration: underline;
    }

    .lampiran-image {
        width: 20px; /* Ukuran ikon */
        height: 20px; /* Ukuran ikon */
        object-fit: cover; /* Memastikan foto tidak terdistorsi */
        margin-right: 5px; /* Jarak antara ikon dan nama file */
    }

    /* Button Link Styles */
    .btn-link {
        display: inline-block;
        padding: 8px 12px;
        margin-top: 5px;
        background-color: #007bff; /* Bootstrap primary color */
        color: white;
        text-decoration: none;
        border-radius: 4px;
    }

    .btn-link:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }
</style>

<!-- sosial media -->
<div class="container py-5">
    <div class="row">
        <div class="col-md-9">

    <!-- Layanan Unggulan untuk Pegawai -->
    @if(Auth::user()->role == 'user')
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="mb-4 text-center">Layanan Unggulan untuk Pegawai</h3>
        </div>

        <!-- Manajemen Data Pegawai -->
        <div class="col-md-6 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-file-earmark-person p-3" style="font-size: 3rem; color: #17a2b8;"></i>
                <div class="card-body">
                    <h5 class="card-title">Manajemen Data Pegawai</h5>
                    <p class="card-text">Kelola data pegawai dengan lebih efektif dan efisien.</p>
                    <a href="/data-pegawai" class="btn btn-primary btn-sm">Lihat Data</a>
                </div>
            </div>
        </div>

        <!-- Penyusunan Rencana -->
        <div class="col-md-6 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-card-checklist p-3" style="font-size: 3rem; color: #6610f2;"></i>
                <div class="card-body">
                    <h5 class="card-title">Penyusunan Rencana</h5>
                    <p class="card-text">Rencanakan proyek Anda dengan lebih terstruktur dan efisien.</p>
                    <a href="{{ route('plans.index') }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                </div>
            </div>
        </div>

        <!-- Kantor Telkom Property dan Performance Tracking -->
        <div class="row mb-5">
            <div class="col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm">
                    <i class="bi bi-building p-3" style="font-size: 3rem; color: #ffc107;"></i>
                    <div class="card-body">
                        <h5 class="card-title">Kantor Telkom Property</h5>
                        <p class="card-text">Akses informasi terkait properti dan fasilitas kantor Telkom.</p>
                        <a href="{{ route('property.index') }}" class="btn btn-success btn-sm">Lihat Properti</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm">
                    <i class="bi bi-bar-chart-line p-3" style="font-size: 3rem; color: #28a745;"></i>
                    <div class="card-body">
                        <h5 class="card-title">Pelacakan Kinerja</h5>
                        <p class="card-text">Pantau kinerja dan progres pekerjaan Anda dan tim.</p>
                        <a href="{{ route('performance.index') }}" class="btn btn-success btn-sm">Lihat Laporan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Layanan Unggulan untuk Admin -->
    @if(Auth::user()->role == 'admin')
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="mb-4 text-center">Layanan Unggulan untuk Admin</h3>
        </div>

        <!-- User Management -->
        <div class="col-md-4 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-person-check p-3" style="font-size: 3rem; color: #17a2b8;"></i>
                <div class="card-body">
                    <h5 class="card-title">Manajemen Pengguna</h5>
                    <p class="card-text">Kelola pengguna dan role untuk memastikan akses yang tepat.</p>
                    <a href="register" class="btn btn-primary btn-sm">Kelola Pengguna</a>
                </div>
            </div>
        </div>

        <!-- Performance Tracking for Admin -->
        <div class="col-md-4 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-bar-chart-line p-3" style="font-size: 3rem; color: #28a745;"></i>
                <div class="card-body">
                    <h5 class="card-title">Pelacakan Kinerja Pegawai</h5>
                    <p class="card-text">Pantau kinerja seluruh pegawai dan ambil tindakan berdasarkan data.</p>
                    <a href="{{ route('admin.performance.index') }}" class="btn btn-success btn-sm">Lihat Laporan</a>
                </div>
            </div>
        </div>

        <!-- Kantor Telkom Property -->
        <div class="col-md-4 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-building p-3" style="font-size: 3rem; color: #ffc107;"></i>
                <div class="card-body">
                    <h5 class="card-title">Kantor Telkom Property</h5>
                    <p class="card-text">Akses informasi terkait properti dan fasilitas kantor Telkom.</p>
                    <a href="{{ route('property.index') }}" class="btn btn-success btn-sm">Lihat Properti</a>
                </div>
            </div>
        </div>
    </div>
    @endif


        <!-- Data Pegawai Fitur Tambahan -->
    <div class="row mt-5">
        <div class="col-12">


<div class="container py-5">
    <div class="row justify-content-center">
<!-- Informasi Telkom Property -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Heading Section -->
            <h2 class="text-center mb-4 font-weight-bold animate-on-scroll">Informasi Telkom Property</h2>
            <p class="text-center text-muted animate-on-scroll">
                <strong>Telkom Property</strong> adalah unit strategis dari PT Telkom Indonesia yang berfokus pada pengelolaan, pengembangan, dan optimalisasi properti perusahaan. Kami memiliki pengalaman bertahun-tahun untuk menyediakan solusi properti terbaik untuk mendukung bisnis Anda, mulai dari manajemen aset hingga pengembangan infrastruktur modern dan ramah lingkungan.
            </p>

            <!-- Features Section -->
            <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Fitur Utama Telkom Property</h4>
                <ul class="list-group list-group-flush animate-on-scroll">
                    <li class="list-group-item">
                        <strong>Penyewaan Ruang Kantor:</strong> Ruang kantor fleksibel dan modern yang dilengkapi dengan teknologi terkini dan fasilitas pendukung.
                    </li>
                    <li class="list-group-item">
                        <strong>Pengelolaan Properti:</strong> Layanan komprehensif untuk menjaga properti Anda dalam kondisi optimal, termasuk keamanan, kebersihan, dan manajemen operasional.
                    </li>
                    <li class="list-group-item">
                        <strong>Pengembangan Infrastruktur:</strong> Solusi pembangunan infrastruktur berstandar tinggi untuk memenuhi kebutuhan bisnis Anda.
                    </li>
                    <li class="list-group-item">
                        <strong>Properti Komersial:</strong> Properti strategis untuk sektor bisnis dan retail dengan desain modern dan lokasi premium.
                    </li>
                    <li class="list-group-item">
                        <strong>Manajemen Aset:</strong> Optimalisasi penggunaan aset untuk memberikan nilai tambah maksimal dengan pendekatan yang efisien.
                    </li>
                    <li class="list-group-item">
                        <strong>Solusi Smart Building:</strong> Teknologi pintar yang menciptakan lingkungan kerja yang hemat energi, aman, dan produktif.
                    </li>
                    <li class="list-group-item">
                        <strong>Layanan Custom:</strong> Paket layanan yang dapat disesuaikan untuk memenuhi kebutuhan unik klien kami.
                    </li>
                </ul>
            </div>

            <!-- Why Choose Us Section -->
            <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Kenapa Memilih Telkom Property?</h4>
                <div class="row text-center">
                    <div class="col-md-3 animate-on-scroll">
                        <i class="bi bi-geo-alt-fill text-danger" style="font-size: 3rem;"></i>
                        <p><strong>Lokasi Strategis</strong><br>Properti di pusat bisnis utama Indonesia.</p>
                    </div>
                    <div class="col-md-3 animate-on-scroll">
                        <i class="bi bi-building text-primary" style="font-size: 3rem;"></i>
                        <p><strong>Fasilitas Modern</strong><br>Fasilitas lengkap untuk mendukung produktivitas.</p>
                    </div>
                    <div class="col-md-3 animate-on-scroll">
                        <i class="bi bi-people-fill text-success" style="font-size: 3rem;"></i>
                        <p><strong>Tim Profesional</strong><br>Dukungan ahli terbaik di bidangnya.</p>
                    </div>
                    <div class="col-md-3 animate-on-scroll">
                        <i class="bi bi-tree-fill text-warning" style="font-size: 3rem;"></i>
                        <p><strong>Keberlanjutan</strong><br>Komitmen pada pengelolaan ramah lingkungan.</p>
                    </div>
                </div>
            </div>

            <!-- Additional Benefits -->
            <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Keunggulan Lainnya</h4>
                <ul class="list-group list-group-flush animate-on-scroll">
                    <li class="list-group-item">
                        <strong>Jaringan Nasional:</strong> Cakupan layanan di berbagai kota besar Indonesia.
                    </li>
                    <li class="list-group-item">
                        <strong>Harga Kompetitif:</strong> Solusi properti berkualitas dengan harga terbaik.
                    </li>
                    <li class="list-group-item">
                        <strong>Inovasi Teknologi:</strong> Pemanfaatan teknologi terkini untuk efisiensi maksimal.
                    </li>
                    <li class="list-group-item">
                        <strong>Komitmen pada Keamanan:</strong> Penggunaan sistem keamanan berteknologi tinggi untuk melindungi properti dan penghuninya.
                    </li>
                    <li class="list-group-item">
                        <strong>Penyewaan Fleksibel:</strong> Kami menawarkan pilihan penyewaan jangka panjang dan jangka pendek untuk memenuhi kebutuhan Anda.
                    </li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Hubungi Kami</h4>
                <p class="text-center animate-on-scroll">
                    Dapatkan informasi lebih lanjut dan diskusikan kebutuhan Anda:
                    <br>
                    <strong>Email:</strong> info@telkomproperty.co.id<br>
                    <strong>Telepon:</strong> (021) 1234 5678<br>
                    <strong>Website:</strong> <a href="https://telkomproperty.co.id" target="_blank">www.telkomproperty.co.id</a>
                </p>
            </div>

            <!-- Location Section -->
            <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Lokasi Kami</h4>
                <p class="text-center text-muted animate-on-scroll">Kantor Pusat: Jl. Jendral Gatot Subroto No. 52, Jakarta Selatan, Indonesia.</p>
                <div id="map" style="height: 400px; border-radius: 10px; overflow: hidden;" class="animate-on-scroll">
                    <!-- Integrate Google Maps -->
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1980.6922719579117!2d106.8189658!3d-6.2157426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e431d07dbd%3A0x57b218aef1c89614!2sTelkom%20Indonesia!5e0!3m2!1sen!2sid!4v1610635732436!5m2!1sen!2sid" 
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>

            <!-- Contact Form Section -->
            <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Ajukan Pertanyaan atau Permintaan Informasi</h4>
                <form class="animate-on-scroll">
                    <div class="form-group">
                        <label for="name">Nama Lengkap:</label>
                        <input type="text" class="form-control" id="name" placeholder="Masukkan nama Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Masukkan email Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Pesan:</label>
                        <textarea class="form-control" id="message" rows="5" placeholder="Tuliskan pesan atau pertanyaan Anda" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Animasi Scroll -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const scrollElements = document.querySelectorAll(".animate-on-scroll");

        const elementInView = (el, dividend = 1) => {
            const elementTop = el.getBoundingClientRect().top;
            return (
                elementTop <=
                (window.innerHeight || document.documentElement.clientHeight) / dividend
            );
        };

        const displayScrollElements = () => {
            scrollElements.forEach((el) => {
                if (elementInView(el, 1.25)) {
                    el.classList.add("visible");
                }
            });
        };

        window.addEventListener("scroll", displayScrollElements);
        displayScrollElements();
    });
</script>

<!-- Styling -->
<style>
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .animate-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<!-- Social Media Links -->
<div class="container mt-5">
    <h5 class="text-center font-weight-bold mb-4">Media Sosial Telkom Property Regional VII</h5>
    <div class="d-flex justify-content-center flex-wrap gap-4">
        <!-- Facebook -->
        <a href="https://www.facebook.com/telkomproperty" target="_blank" class="social-link text-decoration-none text-center mx-3 animate-on-scroll">
            <img src="https://1.bp.blogspot.com/-E7Q8QGQi8jU/WImcvZPvYQI/AAAAAAAACTw/0Er2C5lpPrkRx_JMFTMU0ifRdjS3e4XJQCLcB/s1600/VEKTOR+ICON7.png" 
                alt="Facebook" 
                class="social-icon rounded-circle border border-3">
            <p class="mt-2 text-dark fw-bold">Facebook</p>
        </a>

        <!-- Instagram -->
        <a href="https://www.instagram.com/telkomproperty" target="_blank" class="social-link text-decoration-none text-center mx-3 animate-on-scroll">
            <img src="https://th.bing.com/th/id/OIP.oXKWfypMEAC8DMHWoHgo_wHaEK?rs=1&pid=ImgDetMain" 
                alt="Instagram" 
                class="social-icon rounded-circle border border-3">
            <p class="mt-2 text-dark fw-bold">Instagram</p>
        </a>

        <!-- Twitter -->
        <a href="https://twitter.com/telkomproperty" target="_blank" class="social-link text-decoration-none text-center mx-3 animate-on-scroll">
            <img src="https://th.bing.com/th/id/OIP.2sCQHLnz7YjsueYw8eZkVAHaHa?rs=1&pid=ImgDetMain" 
                alt="Twitter" 
                class="social-icon rounded-circle border border-3">
            <p class="mt-2 text-dark fw-bold">Twitter</p>
        </a>

        <!-- LinkedIn -->
        <a href="https://linkedin.com/company/telkomproperty" target="_blank" class="social-link text-decoration-none text-center mx-3 animate-on-scroll">
            <img src="https://th.bing.com/th/id/OIP.2yeDXMP6_FIR2c2fpGRBXQHaHa?pid=ImgDet&rs=1" 
                alt="LinkedIn" 
                class="social-icon rounded-circle border border-3">
            <p class="mt-2 text-dark fw-bold">LinkedIn</p>
        </a>

        <!-- YouTube -->
        <a href="https://www.youtube.com/telkomproperty" target="_blank" class="social-link text-decoration-none text-center mx-3 animate-on-scroll">
            <img src="https://th.bing.com/th/id/OIP.Bd3xtstXKpDH3jIlXyqN3AHaHa?pid=ImgDet&rs=1" 
                alt="YouTube" 
                class="social-icon rounded-circle border border-3">
            <p class="mt-2 text-dark fw-bold">YouTube</p>
        </a>
    </div>
</div>

<!-- Styling -->
<style>
    .social-link {
        text-decoration: none;
        display: inline-block;
        width: 100px; /* Fixed width for uniformity */
    }

    .social-icon {
        width: 60px;
        height: 60px;
        object-fit: contain;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .social-icon:hover {
        transform: scale(1.2); /* Zoom effect */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow on hover */
    }

    .gap-4 {
        gap: 20px; /* Spacing between social media icons */
    }

    .d-flex {
        display: flex;
    }

    .justify-content-center {
        justify-content: center;
    }

    .flex-wrap {
        flex-wrap: wrap;
    }

    .text-decoration-none {
        text-decoration: none !important;
    }

    .fw-bold {
        font-weight: bold;
    }

    .text-dark {
        color: #333;
    }

    /* Animations */
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .animate-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<!-- Script -->
<script>
    // Add scroll event listener
    document.addEventListener("DOMContentLoaded", function () {
        const items = document.querySelectorAll(".animate-on-scroll");

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");
                        observer.unobserve(entry.target); // Stop observing once animated
                    }
                });
            },
            {
                threshold: 0.1, // Trigger when 10% of the element is visible
            }
        );

        items.forEach((item) => observer.observe(item));
    });
</script>



<script>
    // Initialize Google Maps
    function initMap() {
        const telkomPropertyLocation = { lat: -6.200000, lng: 106.816666 }; // Ganti dengan koordinat lokasi Telkom Property yang tepat
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: telkomPropertyLocation,
        });
        const marker = new google.maps.Marker({
            position: telkomPropertyLocation,
            map: map,
            title: "Telkom Property",
        });
    }

    // Google Maps API
    const googleMapsApiKey = 'YOUR_API_KEY'; // Ganti dengan kunci API Google Maps Anda
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${googleMapsApiKey}&callback=initMap`;
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);

    // Weather API integration
    async function fetchWeather() {
        const city = 'Jakarta';
        const apiKey = 'YOUR_API_KEY'; // Ganti dengan kunci API cuaca Anda
        const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;

        try {
            const response = await fetch(apiUrl);
            const weatherData = await response.json();
            document.getElementById('weather-city').innerText = weatherData.name;
            document.getElementById('weather-description').innerText = weatherData.weather[0].description;
            document.getElementById('weather-temp').innerText = `${weatherData.main.temp}°C`;
        } catch (error) {
            console.error('Error fetching weather:', error);
        }
    }

    // Fetch employee data for additional features
    async function fetchEmployeeData() {
        try {
            const response = await fetch('/api/employee-count');
            const data = await response.json();
            if (data && data.count !== undefined) {
                document.getElementById('employee-count').innerText = data.count;
            } else {
                console.error('Data jumlah pegawai tidak valid');
            }
        } catch (error) {
            console.error('Gagal mengambil data jumlah pegawai:', error);
        }
    }

    // Handle click event to update employee
    document.getElementById('update-employee-count')?.addEventListener('click', async function() {
        const newCount = document.getElementById('employee-count-input')?.value;
        if (newCount === "" || isNaN(newCount)) {
            alert("Masukkan jumlah pegawai yang valid.");
            return;
        }

        try {
            const response = await fetch('/api/employee-count', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ count: newCount })
            });

            if (response.ok) {
                document.getElementById('employee-count').innerText = newCount;
                alert('Sukses memperbarui jumlah pegawai!');
            } else {
                const result = await response.json();
                alert(result.message || 'Gagal memperbarui jumlah pegawai.');
            }
        } catch (error) {
            alert('Gagal memperbarui jumlah pegawai.');
        }
    });

    // Call the fetch function when the page loads
    window.onload = function() {
        fetchWeather();
        fetchEmployeeData();
    };

    // Service Pie Chart
    const ctx = document.getElementById('serviceChart').getContext('2d');
    const serviceChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Penyusunan Rencana', 'Manajemen Data Pegawai', 'Kolaborasi Tim', 'Kantor Telkom Property'],
            datasets: [{
                label: 'Layanan Populer',
                data: [30, 20, 25, 25],
                backgroundColor: ['#6610f2', '#17a2b8', '#007bff', '#ffc107'],
                borderColor: ['#ffffff', '#ffffff', '#ffffff', '#ffffff'],
                borderWidth: 2
            }]
        }
    });

    // Toggle comment form visibility
    function toggleCommentForm(postId) {
        const commentForm = document.getElementById('comment-form-' + postId);
        commentForm.style.display = commentForm.style.display === 'none' ? 'block' : 'none';
    }
</script>

@endsection

@section('styles')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    /* Card Layout Styling */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-body {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 15px;
    }

    .card-header {
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 10px;
        margin-bottom: 15px;
        background: none;
    }

    .card-footer {
        background: none;
        border-top: 1px solid #f0f0f0;
        padding-top: 10px;
        margin-top: 15px;
    }

    /* Profile Picture and User Info Styling */
    .card-body img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }

    .d-flex {
        display: flex;
        align-items: center;
    }

    .me-3 {
        margin-right: 1rem;
    }

    .user-info {
        flex-grow: 1;
    }

    .username {
        font-size: 14px;
        font-weight: bold;
        color: #000;
        margin-bottom: 0;
    }

    .text-muted {
        font-size: 12px;
        color: #6c757d;
    }

    /* Post Content and Image Styling */
    .post-text {
        font-size: 14px;
        color: #343a40;
        margin-top: 10px;
        line-height: 1.5;
    }

    .post-image img {
        width: 100%;
        height: auto;
        max-height: 400px;
        border-radius: 10px;
        object-fit: cover;
        margin-top: 10px;
    }

    /* Input and Button Styling */
    textarea.form-control {
        border-radius: 15px;
        border: 1px solid #e0e0e0;
        box-shadow: none;
        font-size: 14px;
        padding: 10px 15px;
        resize: none;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
    }

    .btn-primary {
        border-radius: 30px;
        padding: 8px 20px;
        font-size: 14px;
        background-color: #007bff;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Comment Section Styling */
    .comment-section {
        margin-top: 20px;
    }

    .comment {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .comment img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 10px;
    }

    .comment-body {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 10px 15px;
        flex-grow: 1;
    }

    .comment-text {
        font-size: 14px;
        margin: 0;
        color: #495057;
    }

    .comment-meta {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }

    /* Responsive Design */
    @media (max-width: 576px) {
        .card {
            margin-bottom: 15px;
        }

        .post-image img {
            max-height: 300px;
        }

        .comment img {
            width: 35px;
            height: 35px;
        }

        .btn-primary {
            font-size: 12px;
            padding: 6px 15px;
        }
    }
</style>
@endsection
