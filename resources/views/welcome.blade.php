<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f7f9fc;
            font-family: 'Arial', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            background-color: #007bff;
            text-align: center;
            border-bottom: 2px solid #495057;
        }

        .sidebar-menu {
            flex-grow: 1;
            padding: 1rem;
        }

        .sidebar-menu a {
            text-decoration: none;
            color: white;
            display: block;
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 4px;
            background-color: #495057;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .sidebar-menu a:hover {
            background-color: #007bff;
            transform: translateX(5px);
        }

        .sidebar-footer {
            padding: 1rem;
            text-align: center;
            border-top: 2px solid #495057;
        }

        .sidebar-footer .btn {
            width: 100%;
            margin-top: 10px;
        }

        /* Main content */
        .main-content {
            flex-grow: 1;
            margin-left: 250px;
            padding: 3rem 2rem;
            transition: margin-left 0.3s ease;
        }

        .main-content h1 {
            color: #343a40;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.2rem;
            color: #007bff;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .sidebar-menu a {
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <div class="sidebar-header">
                <h3>Selamat Datang</h3>
                <p>
                    @if(Auth::user()->dataPegawai)
                        {{ Auth::user()->dataPegawai->nama }}
                    @else
                        anda ({{ Auth::user()->role }})
                    @endif
                </p>
            </div>
            <div class="sidebar-menu">
                <!-- Tombol ke Halaman Register User (untuk admin) -->
                @if(Auth::user() && Auth::user()->role === 'admin')
                    <a href="{{ route('register.form') }}" class="btn btn-primary d-block">Register User</a>
                @endif
                @if(Auth::user() && Auth::user()->role === 'user')
                <!-- Tombol ke Halaman Edit Profil -->
                <a href="{{ route('data-pegawai.edit', ['nik' => Auth::user()->nik]) }}" class="btn btn-primary d-block">Edit Profil</a>
                <a href="{{ route('data-pegawai.index') }}" class="btn btn-secondary d-block">Lihat Data Pegawai</a>
                @endif
            </div>
        </div>

        <div class="sidebar-footer">
            <!-- Tombol Logout -->
            @if(Auth::check())
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-success">Login</a>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1 class="mb-4">Selamat Datang di Beranda</h1>
            <p>Temukan berbagai informasi dan fitur yang ada di sini.</p>

            <div class="row">
                <!-- Fitur 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Fitur 1</h5>
                            <p class="card-text">Deskripsi singkat tentang fitur pertama yang bisa diakses oleh user.</p>
                            <a href="#" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <!-- Fitur 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Fitur 2</h5>
                            <p class="card-text">Deskripsi singkat tentang fitur kedua yang tersedia.</p>
                            <a href="#" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <!-- Fitur 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Fitur 3</h5>
                            <p class="card-text">Deskripsi singkat tentang fitur ketiga yang bisa dijelajahi oleh user.</p>
                            <a href="#" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
