<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>@yield('title', 'Default Title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Global styles */
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            background-color: #f7f9fc;
            font-family: 'Arial', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar styles */
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
            transition: width 0.3s ease;
            z-index: 1000;
        }

        .sidebar.minimized {
            width: 80px;
        }

        .sidebar-header {
            padding: 1rem;
            text-align: center;
            background-color: #007bff;
            border-bottom: 2px solid #495057;
            transition: padding 0.3s ease;
        }

        .sidebar-header img {
            max-width: 50px;
            height: auto;
            margin-bottom: 10px;
            transition: transform 0.3s ease;
        }

        /* Hover effect on logo */
        .sidebar-header img:hover {
            transform: scale(1.3); /* Memperbesar logo saat dihover */
            transition: transform 0.3s ease;
        }

        /* If the sidebar is minimized */
        .sidebar.minimized .sidebar-header img:hover {
            transform: scale(1.5); /* Memperbesar logo lebih besar saat sidebar diminimalkan */
        }

        .sidebar.minimized .sidebar-header {
            padding: 0.5rem; /* Mengurangi padding agar logo lebih terpusat */
        }

        .sidebar.minimized .sidebar-header img {
            transform: scale(1.2);
            margin-top: 10px; /* Menambahkan jarak atas untuk memperbaiki posisi logo */
        }

        .sidebar-header h3,
        .sidebar-header p {
            transition: opacity 0.3s ease;
            opacity: 1;
        }

        .sidebar.minimized .sidebar-header h3,
        .sidebar.minimized .sidebar-header p {
            opacity: 0;
        }

        .sidebar-menu {
            flex-grow: 1;
            padding: 1rem;
        }

        .sidebar-menu a {
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 4px;
            background-color: #495057;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .sidebar-menu a.active {
            background-color: #007bff;
            font-weight: bold;
        }

        .sidebar-menu a i {
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .sidebar.minimized .sidebar-menu a {
            justify-content: center;
        }

        .sidebar.minimized .sidebar-menu a span {
            display: none;
        }

        /* Sidebar footer styles */
        .sidebar-footer {
            padding: 1rem;
            text-align: center;
            border-top: 2px solid #495057;
        }

        /* Menyembunyikan tombol logout saat sidebar diminimalkan */
        .sidebar.minimized .sidebar-footer {
            display: none;
        }

        /* Main content styles */
        .main-content {
            flex-grow: 1;
            margin-left: 250px;
            padding: 3rem 2rem;
            background-color: #ffffff;
            transition: margin-left 0.3s ease;
        }

        .main-content.shrinked {
            margin-left: 80px;
        }

        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 50%;
            z-index: 1100;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .toggle-btn:hover {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                width: 100%;
                height: auto;
            }

            .sidebar.minimized {
                width: 80px;
            }

            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }

            .main-content.shrinked {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Toggle Button -->
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div>
            <div class="sidebar-header">
            <br><br>
                <!-- <img src="https://via.placeholder.com/50" alt="Logo"> -->
                <h3>Selamat Datang</h3>
                <p>
                    @if(Auth::user()->dataPegawai)
                        {{ Auth::user()->dataPegawai->nama }}
                    @else
                        Anda ({{ Auth::user()->role }})
                    @endif
                </p>
            </div>
            <div class="sidebar-menu">
                @if(Auth::user() && Auth::user()->role === 'admin')
                    <a href="{{ route('register.form') }}" 
                       class="{{ Request::routeIs('register.form') ? 'active' : '' }}">
                        <i class="bi bi-person-plus"></i><span>Tambahkan Akun</span>
                    </a>
                @endif
                <a href="{{ route('beranda') }}" 
                   class="{{ Request::routeIs('beranda') ? 'active' : '' }}">
                    <i class="bi bi-house"></i><span>Beranda</span>
                </a>
                <a href="{{ route('data-pegawai.index') }}" 
                   class="{{ Request::routeIs('data-pegawai.index') ? 'active' : '' }}">
                    <i class="bi bi-people"></i><span>Lihat Data Pegawai</span>
                </a>
            </div>
        </div>
        <div class="sidebar-footer">
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
    <div class="main-content" id="main-content">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        function toggleSidebar() {
            sidebar.classList.toggle('minimized');
            mainContent.classList.toggle('shrinked');
        }
    </script>
</body>

</html>
