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
            background-image: url('');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Arial', sans-serif;
        }

        .login-card {
            width: 5600%;
            max-width: 560px;
            background: rgba(255, 255, 255, 0.4); /* Transparent background */
            padding: 50px 35px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            backdrop-filter: blur(1px); /* Soft blur effect */
            color: #333;
            overflow: hidden;
        }

        .login-card .logo {
            display: block;
            margin: 0 auto 20px;
            width: 100%;
            max-width: 120px;
        }

        .login-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            text-align: center;
            color: #333;
            margin-bottom: 15px;
        }

        .login-card p {
            font-size: 1rem;
            color: #555;
            text-align: center;
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control {
            font-size: 1.1rem;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.8); /* More transparent background */
            color: #333;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            background: rgba(255, 255, 255, 1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            font-size: 1.1rem;
            font-weight: bold;
            padding: 12px;
            border-radius: 30px;
            width: 100%;
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-footer {
            margin-top: 20px;
            font-size: 1rem;
            text-align: center;
        }

        .form-footer a {
            color: #007bff;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1055;
        }

        @media (max-width: 576px) {
            .login-card {
                max-width: 90%;
                padding: 20px 15px;
            }

            .login-card h1 {
                font-size: 1.5rem;
            }

            .form-label,
            .form-control {
                font-size: 1rem;
            }

            .btn-primary {
                padding: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Toast Container -->
    <div class="toast-container">
        <!-- Success Toast -->
        @if (session('success'))
        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif

        <!-- Error Toast -->
        @if (session('error'))
        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>

    <div class="login-card">
        <!-- Logo -->
        <a href="#">
            <img src="https://product.telkomproperty.co.id/assets/images/logoTelkom.png" alt="Logo" class="logo">
        </a>

        <h1>Welcome Back</h1>
        <p>Login to access your account</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <!-- NIK Input -->
            <div class="form-group">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" 
                       id="nik" 
                       name="nik" 
                       placeholder="Enter your NIK" 
                       class="form-control @error('nik') is-invalid @enderror" 
                       required>
                @error('nik')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Enter your password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       required>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for Toast Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Bootstrap Toasts
            const toastElements = document.querySelectorAll('.toast');
            toastElements.forEach(toastElement => {
                const toast = new bootstrap.Toast(toastElement);
                toast.show();
            });
        });
    </script>
</body>

</html>