<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://static.republika.co.id/uploads/images/inpicture_slide/rancangan-dari-gedung-yang-akan-dibangun-di-1-queensbridge-_170210090232-546.jpg');
            background-size: cover;
            background-position: center center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            padding: 40px 35px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .login-card:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
            transform: scale(1.05);
        }

        .logo {
            display: block;
            margin: 0 auto 30px;
            max-width: 100px;
        }

        .login-card h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #555;
            text-align: left;
            margin-bottom: 10px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 25px;
            padding: 12px 20px;
            color: #fff;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .alert-danger {
            font-size: 0.9rem;
            color: #f44336;
            margin-bottom: 20px;
            text-align: left;
            padding: 10px;
            border-radius: 8px;
            background-color: #f8d7da;
        }

        .text-muted {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .text-muted a {
            text-decoration: none;
            color: #007bff;
            font-weight: 600;
        }

        .text-muted a:hover {
            text-decoration: underline;
        }

        .form-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 30px 20px;
            }

            .login-card h1 {
                font-size: 1.8rem;
                margin-bottom: 20px;
            }

            .form-control {
                padding: 10px;
                font-size: 0.9rem;
            }

            .btn-primary {
                padding: 10px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="login-card">
            <!-- Logo -->
            <a href="#">
                <img src="https://product.telkomproperty.co.id/assets/images/logoTelkom.png" alt="Logo" class="logo">
            </a>

            <h1>Login</h1>

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf

                <!-- NIK Input -->
                <div class="mb-4">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK Anda" required
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Masukkan NIK Anda" />
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password Anda"
                        required data-bs-toggle="tooltip" data-bs-placement="top" title="Masukkan Password Anda" />
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <p class="m-0">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Initialize Bootstrap Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        document.getElementById('loginForm').addEventListener('submit', function (event) {
            const nik = document.getElementById('nik').value.trim();
            const password = document.getElementById('password').value.trim();

            // Simple client-side validation
            if (nik === '' || password === '') {
                event.preventDefault();
                alert('Semua field harus diisi!');
            } else if (!/^\d+$/.test(nik)) {
                event.preventDefault();
                alert('NIK harus berupa angka!');
            }
        });
    </script>
</body>

</html>
