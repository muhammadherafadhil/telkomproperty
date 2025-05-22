<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Telkom Property</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f4f8;
    }

    .container-fluid {
      height: 100vh;
    }

    .row.full-height {
      height: 100%;
    }

    .left-col {
      background: linear-gradient(to bottom right,rgb(10, 157, 255),rgb(10, 106, 250));
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 50px;
      text-align: center;
    }

    .left-col img {
      max-width: 180px;
      margin-bottom: 30px;
    }

    .left-col h2 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 20px;
    }

    .left-col p {
      font-size: 1.2rem;
      max-width: 500px;
    }

    .right-col {
      background-color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .login-box {
      width: 100%;
      max-width: 600px;
      padding: 50px;
      background-color: #ffffff;
      border-radius: 20px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
      text-align: center;
    }

    .login-box img.logo {
      max-width: 160px;
      margin-bottom: 30px;
    }

    .login-box h1 {
      font-size: 2.3rem;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .login-box p.subtext {
      font-size: 1.1rem;
      color: #555;
      margin-bottom: 30px;
    }

    .form-label {
      font-weight: 600;
    }

    .form-control {
      font-size: 1.1rem;
      padding: 14px;
      border-radius: 10px;
    }

    .btn-primary {
      width: 100%;
      padding: 14px;
      font-size: 1.1rem;
      border-radius: 30px;
      font-weight: bold;
    }

    .form-footer {
      margin-top: 20px;
      font-size: 0.95rem;
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

    @media (max-width: 768px) {
      .left-col {
        display: none;
      }

      .login-box {
        padding: 30px 20px;
        max-width: 95%;
      }
    }
  </style>
</head>

<body>
  <!-- Toasts -->
  <div class="toast-container">
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

  <div class="container-fluid">
    <div class="row full-height">
      <!-- Left Section -->
      <div class="col-md-6 left-col">
        <img src="https://product.telkomproperty.co.id/assets/images/logoTelkom.png" alt="Telkom Logo" />
        <h2>Selamat Datang Di Website data Pegawai TelkomProperty</h2>
        <p>We deliver property solutions that are fast, secure, and connected. Log in to manage and monitor your digital infrastructure more effectively.</p>
      </div>

      <!-- Right Section -->
      <div class="col-md-6 right-col">
        <div class="login-box">
          <img src="https://product.telkomproperty.co.id/assets/images/logoTelkom.png" alt="Telkom Logo" class="logo">
          <h1>Login</h1>
          <p class="subtext">Masukkan NIK dan Password</p>

          <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3 text-start">
              <label for="nik" class="form-label">NIK</label>
              <input type="text" id="nik" name="nik" class="form-control @error('nik') is-invalid @enderror" placeholder="Enter your NIK" required>
              @error('nik')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3 text-start">
              <label for="password" class="form-label">Password</label>
              <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" required>
              @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">Sign In</button>

            <div class="form-footer mt-3">
              <span>Forgot password? <a href="#">Click here</a></span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll(".toast").forEach(toast => new bootstrap.Toast(toast).show());
    });
  </script>
</body>

</html>
