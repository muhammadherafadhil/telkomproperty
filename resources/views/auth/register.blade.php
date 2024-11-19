<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6c63ff, #5bcaff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            font-weight: bold;
            color: #555;
        }

        .btn-primary {
            background-color: #6c63ff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #5a54d6;
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.5);
        }

        .alert-danger p {
            font-size: 0.9rem;
        }

        .card-title {
            color: #6c63ff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card p-4" style="max-width: 450px; margin: auto;">
            <h2 class="card-title text-center mb-4">Register User</h2>
            <form action="{{ route('register') }}" method="POST" id="registerForm">
                @csrf
                <!-- NIK Input -->
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK karyawan" required>
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password" required>
                </div>

                <!-- Role Select -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" name="role" id="role" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
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
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        document.getElementById('registerForm').addEventListener('submit', function (event) {
            const nik = document.getElementById('nik').value.trim();
            const password = document.getElementById('password').value.trim();
            const role = document.getElementById('role').value;

            // Simple client-side validation
            if (nik === '' || password === '' || role === '') {
                event.preventDefault();
                alert('Semua field harus diisi!');
            } else if (!/^\d+$/.test(nik)) {
                event.preventDefault();
                alert('NIK harus berupa angka!');
            } else if (password.length < 6) {
                event.preventDefault();
                alert('Password minimal harus memiliki 6 karakter!');
            }
        });
    </script>
</body>

</html>
