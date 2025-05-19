@extends('welcome')

@section('title', 'Halaman Dashboard')

@section('content')

<!-- CSRF Token for AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container py-5">
    <h2 class="text-center mb-4">Riwayat Aktivitas Pegawai</h2>

    @php
        $logs = $logs ?? collect();
    @endphp

    @if ($logs->isEmpty())
        <div class="alert alert-warning text-center" role="alert">
            Belum ada riwayat aktivitas yang tercatat.
        </div>
    @else
        <div class="log-feed">
            @php $seenCreatedAt = []; @endphp

            @foreach ($logs as $log)
                @php
                    if (in_array($log->created_at, $seenCreatedAt)) continue;
                    $seenCreatedAt[] = $log->created_at;

                    $oldData = is_string($log->old_data) ? json_decode($log->old_data, true) : ($log->old_data ?? []);
                    $newData = is_string($log->new_data) ? json_decode($log->new_data, true) : ($log->new_data ?? []);
                    $changes = [];

                    foreach ($newData as $key => $newValue) {
                        $oldValue = $oldData[$key] ?? null;

                        if ($oldValue === $newValue || (empty($oldValue) && empty($newValue))) continue;

                        switch ($key) {
                            case 'lamp_foto_karyawan':
                                $changes[] = "
                                    <strong>Foto Karyawan:</strong><br>
                                    <div class='photo-comparison'>
                                        <img src='/storage/{$oldValue}' alt='Foto Sebelum' class='employee-photo clickable' data-img='/storage/{$oldValue}'>
                                        <span>→</span>
                                        <img src='/storage/{$newValue}' alt='Foto Setelah' class='employee-photo clickable' data-img='/storage/{$newValue}'>
                                    </div>";
                                break;

                            case (preg_match('/lamp_|avatar_karyawan/', $key) ? true : false):
                                $oldFileName = $oldValue ? pathinfo($oldValue, PATHINFO_BASENAME) : 'Kosong';
                                $newFileName = $newValue ? pathinfo($newValue, PATHINFO_BASENAME) : 'Kosong';

                                $oldBtn = $oldValue ? "<button class='btn btn-link btn-sm' data-bs-toggle='modal' data-bs-target='#fileModal' data-file='/storage/{$oldValue}' data-file-name='{$oldFileName}'>Lihat Lampiran Sebelumnya</button>" : '';
                                $newBtn = $newValue ? "<button class='btn btn-link btn-sm' data-bs-toggle='modal' data-bs-target='#fileModal' data-file='/storage/{$newValue}' data-file-name='{$newFileName}'>Lihat Lampiran Baru</button>" : '';

                                $changes[] = "<strong>Lampiran:</strong> 
                                    <span class='old-file'>{$oldFileName}</span> → 
                                    <span class='new-file'>{$newFileName}</span><br>{$oldBtn}" . ($oldBtn && $newBtn ? ' | ' : '') . "{$newBtn}";
                                break;

                            default:
                                $changes[] = "<strong>" . ucfirst(str_replace('_', ' ', $key)) . "</strong>: 
                                    <span class='old-value'>" . ($oldValue ?? '-') . "</span> → 
                                    <span class='new-value'>" . ($newValue ?? '-') . "</span>";
                        }
                    }
                @endphp

                <div class="card mb-4 shadow-sm rounded-lg" data-log-id="{{ $log->id }}">
                    <div class="card-header d-flex justify-content-between align-items-center p-3">
                        <div class="d-flex align-items-center">
                            <img src="{{ Storage::url($log->employee_photo) }}" alt="User Photo" class="rounded-circle" style="width: 50px; height: 50px;">
                            <div class="ms-3">
                                <span class="fw-bold">{{ Auth::user()->name }}</span><br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}</small><br>
                                <span class="log-user">{{ $log->dataPegawai->nama_lengkap ?? 'Pegawai Tidak Diketahui' }}</span>
                            </div>
                        </div>

                        <div class="badge-group">
                            @if ($log->validation_status === 'approved')
                                <span class="badge bg-success text-white">✅ Diterima</span>
                            @elseif ($log->validation_status === 'rejected')
                                <span class="badge bg-danger text-white">❌ Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark">⏳ Menunggu Validasi</span>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $log->name }}</h5>
                        <p class="card-text"><strong>Hobi:</strong> {{ $log->hobi }}</p>

                        @if ($log->lampiran && is_string($log->lampiran))
                            <div class="attachment mb-3">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#fileModal" data-file="{{ Storage::url($log->lampiran) }}" data-file-name="{{ pathinfo($log->lampiran, PATHINFO_BASENAME) }}">Lihat Lampiran</button>
                            </div>
                        @endif

                        @if (!empty($changes))
                            <ul class="list-unstyled mt-3">
                                @foreach ($changes as $change)
                                    <li class="log-item py-2 border-bottom">{!! $change !!}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Tidak ada perubahan signifikan yang tercatat.</p>
                        @endif

                        @if ($log->validation_status === 'pending' && Auth::user()->role === 'admin')
                            <div class="validation-actions mt-3">
                                <button class="btn btn-success btn-sm validate-btn" data-id="{{ $log->id }}" data-status="approved">✅ Approve</button>
                                <button class="btn btn-danger btn-sm validate-btn" data-id="{{ $log->id }}" data-status="rejected">❌ Reject</button>
                            </div>
                        @endif

                        <div class="like-section mt-3">
                            <button class="btn btn-outline-primary like-btn {{ ($log->likes && $log->likes->where('user_id', Auth::id())->isNotEmpty()) ? 'active' : '' }}" data-log-id="{{ $log->id }}">
                                ❤️ <span class="like-count">{{ $log->likes ? $log->likes->count() : 0 }}</span> {{ ($log->likes && $log->likes->where('user_id', Auth::id())->isNotEmpty()) ? 'Unlike' : 'Like' }}
                            </button>
                        </div>

                        <div class="comment-section mt-4">
                            <form action="{{ route('logs.comment', $log->id) }}" method="POST" id="comment-form-{{ $log->id }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="comment" class="form-control" placeholder="Tulis komentar..." required>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </form>

                            <ul class="comments mt-3">
                                @foreach ($log->comments as $comment)
                                    <li class="comment-item mb-2">
                                        <strong>{{ $comment->user->dataPegawai->nama_lengkap ?? 'User Tidak Diketahui' }}:</strong>
                                        <span class="comment-text">{{ $comment->comment }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center">
                {{ $logs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

<!-- Modal for Viewing Attachments -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel">Lampiran File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div id="fileContent" class="text-center">
                    <!-- Akan diisi lewat JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Enlarged Images -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img src="" id="modalImage" class="img-fluid w-100" alt="Enlarged Image">
            </div>
        </div>
    </div>
</div>


<!-- jQuery and Bootstrap JS (Bootstrap 5) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // CSRF setup for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle file modal when clicking on attachment button
    $('#fileModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var fileUrl = button.data('file');
        var fileName = button.data('file-name');

        var fileExtension = fileName.split('.').pop().toLowerCase();

        var content = '';

        if (fileExtension === 'jpg' || fileExtension === 'png' || fileExtension === 'jpeg') {
            content = '<img src="' + fileUrl + '" class="img-fluid" alt="Lampiran Gambar">';
        } else {
            content = '<a href="' + fileUrl + '" target="_blank" class="btn btn-primary btn-sm">Download ' + fileName + '</a>';
        }

        $('#fileContent').html(content);
    });

    // Like functionality
    $(document).on('click', '.like-btn', function() {
        var button = $(this);
        var logId = button.data('log-id');

        $.ajax({
            url: '/logs/' + logId + '/like',
            type: 'POST',
            success: function(response) {
                let newLikes = response.likes;
                if (response.status === 'liked') {
                    button.addClass('active').html('❤️ Unlike <span class="like-count">' + newLikes + '</span>');
                } else {
                    button.removeClass('active').html('❤️ Like <span class="like-count">' + newLikes + '</span>');
                }
            },
            error: function() {
                alert("Gagal memperbarui like. Silakan coba lagi.");
            }
        });
    });

    // Validate logs (for admin role)
    $(document).on('click', '.validate-btn', function() {
        var logId = $(this).data('id');
        var status = $(this).data('status');

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

    // Comment form submission
    $(document).on('submit', '.comment-section form', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();

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
});

document.addEventListener('DOMContentLoaded', function () {
    // Handle attachment modal
    const fileModal = document.getElementById('fileModal');
    fileModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const fileUrl = button.getAttribute('data-file');
        const fileName = button.getAttribute('data-file-name');
        const fileContent = document.getElementById('fileContent');

        if (/\.(jpg|jpeg|png|gif)$/i.test(fileUrl)) {
            fileContent.innerHTML = `<img src="${fileUrl}" class="img-fluid" alt="${fileName}">`;
        } else {
            fileContent.innerHTML = `<iframe src="${fileUrl}" class="w-100" style="height:500px;"></iframe>`;
        }
    });

    // Handle click on photos for zoom
    document.querySelectorAll('.clickable').forEach(img => {
        img.addEventListener('click', function () {
            const src = this.getAttribute('data-img');
            const modalImg = document.getElementById('modalImage');
            modalImg.src = src;
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        });
    });
});

</script>

<style>
/* ===================================
   RESET & BASE STYLES
=================================== */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f2f5;
    color: #333;
    line-height: 1.6;
}

/* ===================================
   CONTAINER & GENERAL LAYOUT
=================================== */
.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 40px;
    background-color: #fff;
    border-radius: 16px;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.05);
}

/* ===================================
   HEADINGS & TITLES
=================================== */
.heading-primary {
    text-align: center;
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 40px;
}

/* ===================================
   LOG FEED
=================================== */
.log-feed {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

/* ===================================
   LOG CARD
=================================== */
.log-card {
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.log-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
}

/* ===================================
   LOG HEADER
=================================== */
.log-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.log-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.profile-photo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
}

.log-user-info {
    display: flex;
    flex-direction: column;
}

.log-user {
    font-size: 18px;
    font-weight: 600;
    color: #2980b9;
}

.log-time {
    font-size: 14px;
    color: #7f8c8d;
}

.log-action {
    font-size: 16px;
    font-weight: 600;
    color: #27ae60;
}

/* ===================================
   LOG CONTENT
=================================== */
.log-body {
    margin-top: 20px;
}

.log-description {
    font-size: 16px;
    color: #444;
}

.log-changes {
    margin-top: 20px;
    padding: 20px;
    background-color: #f1f3f5;
    border-radius: 10px;
    list-style: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
}

.log-item {
    margin-bottom: 12px;
    font-size: 15px;
    color: #2c3e50;
}

.old-value {
    color: #e74c3c;
}

.new-value {
    color: #2ecc71;
}

/* ===================================
   BUTTONS
=================================== */
.btn,
.like-btn,
.page-btn,
.validate-btn,
.comment-section button,
.input-group button {
    display: inline-block;
    padding: 12px 25px;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    font-weight: 500;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.like-btn {
    background-color: #ff5722;
    color: #fff;
}

.like-btn.liked {
    background-color: #e74c3c;
}

.page-btn {
    background-color: #2980b9;
    color: #fff;
    margin: 0 4px;
}

.page-btn.active {
    background-color: #2ecc71;
}

.comment-section button,
.input-group button {
    background-color: #27ae60;
    color: #fff;
}

.validate-btn.approve {
    background-color: #2ecc71;
    color: white;
}

.validate-btn.reject {
    background-color: #e74c3c;
    color: white;
}

.btn:hover,
.page-btn:hover,
.like-btn:hover,
.validate-btn:hover,
.comment-section button:hover,
.input-group button:hover {
    opacity: 0.9;
}

/* ===================================
   PAGINATION
=================================== */
.pagination-container {
    margin-top: 40px;
    text-align: center;
}

/* ===================================
   COMMENT SECTION
=================================== */
.comment-section {
    margin-top: 30px;
}

.comment-section form {
    display: flex;
    gap: 10px;
}

.comment-section input,
.input-group input {
    flex: 1;
    padding: 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 15px;
    color: #333;
    background-color: #fff;
}

.comment-section ul {
    margin-top: 20px;
    list-style: none;
    padding: 0;
}

.comment-item {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.comment-item strong {
    color: #2980b9;
}

/* ===================================
   BADGES & LABELS
=================================== */
.badge-group {
    display: flex;
    gap: 8px;
    font-size: 13px;
}

.badge-group span {
    padding: 6px 14px;
    border-radius: 20px;
    color: #fff;
    font-weight: 500;
}

.badge-success {
    background-color: #2ecc71;
}

.badge-danger {
    background-color: #e74c3c;
}

.badge-warning {
    background-color: #f39c12;
}

/* ===================================
   ATTACHMENTS
=================================== */
.attachment {
    margin-top: 20px;
    padding: 12px;
    background-color: #f4f6f8;
    border: 1px solid #ddd;
    border-radius: 8px;
}

/* ===================================
   MODAL
=================================== */
.modal-content {
    border-radius: 10px;
    border: 2px solid #2980b9;
}

.modal-header {
    background-color: #2980b9;
    color: white;
    font-weight: 600;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    border-top: 1px solid #ddd;
}

/* ===================================
   PHOTOS & COMPARISONS
=================================== */
.employee-photo {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
}

.photo-comparison {
    display: flex;
    gap: 15px;
    align-items: center;
}

/* ===================================
   TOOLTIP
=================================== */
.tooltip {
    position: absolute;
    background-color: #333;
    color: white;
    padding: 6px 10px;
    border-radius: 4px;
    font-size: 12px;
    z-index: 1000;
}
</style>


<!-- sosial media -->
<!-- <div class="container py-5">
    <div class="row">
        <div class="col-md-9"> -->

    <!-- Layanan Unggulan untuk Pegawai
    @if(Auth::user()->role == 'user')
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="mb-4 text-center">Layanan Unggulan untuk Pegawai</h3>
        </div>

        Manajemen Data Pegawai -->
        <!-- <div class="col-md-6 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-file-earmark-person p-3" style="font-size: 3rem; color: #17a2b8;"></i>
                <div class="card-body">
                    <h5 class="card-title">Manajemen Data Pegawai</h5>
                    <p class="card-text">Kelola data pegawai dengan lebih efektif dan efisien.</p>
                    <a href="/data-pegawai" class="btn btn-primary btn-sm">Lihat Data</a>
                </div>
            </div>
        </div> -->

        <!-- Penyusunan Rencana -->
        <!-- <div class="col-md-6 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-card-checklist p-3" style="font-size: 3rem; color: #6610f2;"></i>
                <div class="card-body">
                    <h5 class="card-title">Penyusunan Rencana</h5>
                    <p class="card-text">Rencanakan proyek Anda dengan lebih terstruktur dan efisien.</p>
                    <a href="{{ route('plans.index') }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                </div>
            </div>
        </div> -->

        <!-- Kantor Telkom Property dan Performance Tracking -->
        <!-- <div class="row mb-5">
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
    @endif -->

    <!-- Layanan Unggulan untuk Admin -->
    <!-- @if(Auth::user()->role == 'admin')
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="mb-4 text-center">Layanan Unggulan untuk Admin</h3>
        </div> -->

        <!-- User Management -->
        <!-- <div class="col-md-4 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-person-check p-3" style="font-size: 3rem; color: #17a2b8;"></i>
                <div class="card-body">
                    <h5 class="card-title">Manajemen Pengguna</h5>
                    <p class="card-text">Kelola pengguna dan role untuk memastikan akses yang tepat.</p>
                    <a href="register" class="btn btn-primary btn-sm">Kelola Pengguna</a>
                </div>
            </div>
        </div> -->

        <!-- Performance Tracking for Admin -->
        <!-- <div class="col-md-4 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-bar-chart-line p-3" style="font-size: 3rem; color: #28a745;"></i>
                <div class="card-body">
                    <h5 class="card-title">Pelacakan Kinerja Pegawai</h5>
                    <p class="card-text">Pantau kinerja seluruh pegawai dan ambil tindakan berdasarkan data.</p>
                    <a href="{{ route('admin.performance.index') }}" class="btn btn-success btn-sm">Lihat Laporan</a>
                </div>
            </div>
        </div> -->

        <!-- Kantor Telkom Property -->
        <!-- <div class="col-md-4 mb-4">
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
    @endif -->


        <!-- Data Pegawai Fitur Tambahan -->
    <!-- <div class="row mt-5">
        <div class="col-12">


<div class="container py-5">
    <div class="row justify-content-center"> -->
<!-- Informasi Telkom Property -->
<!-- <div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10"> -->
            <!-- Heading Section -->
            <!-- <h2 class="text-center mb-4 font-weight-bold animate-on-scroll">Informasi Telkom Property</h2>
            <p class="text-center text-muted animate-on-scroll">
                <strong>Telkom Property</strong> adalah unit strategis dari PT Telkom Indonesia yang berfokus pada pengelolaan, pengembangan, dan optimalisasi properti perusahaan. Kami memiliki pengalaman bertahun-tahun untuk menyediakan solusi properti terbaik untuk mendukung bisnis Anda, mulai dari manajemen aset hingga pengembangan infrastruktur modern dan ramah lingkungan.
            </p> -->

            <!-- Features Section -->
            <!-- <div class="mt-5">
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
            </div> -->

            <!-- Why Choose Us Section -->
            <!-- <div class="mt-5">
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
            </div> -->

            <!-- Additional Benefits -->
            <!-- <div class="mt-5">
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
            </div> -->

            <!-- Contact Section -->
            <!-- <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Hubungi Kami</h4>
                <p class="text-center animate-on-scroll">
                    Dapatkan informasi lebih lanjut dan diskusikan kebutuhan Anda:
                    <br>
                    <strong>Email:</strong> info@telkomproperty.co.id<br>
                    <strong>Telepon:</strong> (021) 1234 5678<br>
                    <strong>Website:</strong> <a href="https://telkomproperty.co.id" target="_blank">www.telkomproperty.co.id</a>
                </p>
            </div> -->

            <!-- Location Section -->
            <!-- <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Lokasi Kami</h4>
                <p class="text-center text-muted animate-on-scroll">Kantor Pusat: Jl. Jendral Gatot Subroto No. 52, Jakarta Selatan, Indonesia.</p>
                <div id="map" style="height: 400px; border-radius: 10px; overflow: hidden;" class="animate-on-scroll"> -->
                    <!-- Integrate Google Maps -->
                    <!-- <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1980.6922719579117!2d106.8189658!3d-6.2157426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e431d07dbd%3A0x57b218aef1c89614!2sTelkom%20Indonesia!5e0!3m2!1sen!2sid!4v1610635732436!5m2!1sen!2sid" 
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div> -->

            <!-- Contact Form Section -->
            <!-- <div class="mt-5">
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
</div> -->

<!-- Animasi Scroll -->
<!-- <script>
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
</script> -->

<!-- Styling -->
<!-- <style>
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .animate-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style> -->

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
