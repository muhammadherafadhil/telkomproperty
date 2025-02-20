@extends('welcome')

@section('title', 'Halaman Register')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Tambahkan Akun Baru</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('register') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <!-- Input NIK -->
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input 
                        type="text" 
                        name="nik" 
                        id="nik" 
                        class="form-control" 
                        placeholder="Masukkan NIK Anda"
                        required>
                    <div class="invalid-feedback">
                        Harap masukkan NIK yang valid (16 digit angka).
                    </div>
                </div>

                <!-- Input Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-control" 
                        placeholder="Masukkan password"
                        minlength="6" 
                        required>
                    <div class="invalid-feedback">
                        Password harus terdiri dari minimal 6 karakter.
                    </div>
                </div>

                <!-- Select Role -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select 
                        class="form-select" 
                        name="role" 
                        id="role" 
                        required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    <div class="invalid-feedback">
                        Harap pilih role.
                    </div>
                </div>

                <!-- Preview Role -->
                <div id="role-preview" class="mb-3 d-none">
                    <p class="text-secondary">Anda memilih: <strong id="role-label"></strong></p>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Validasi form Bootstrap
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // Preview Role
    const roleSelect = document.getElementById('role');
    const rolePreview = document.getElementById('role-preview');
    const roleLabel = document.getElementById('role-label');
    roleSelect.addEventListener('change', (e) => {
        if (e.target.value) {
            roleLabel.textContent = e.target.options[e.target.selectedIndex].text;
            rolePreview.classList.remove('d-none');
        } else {
            rolePreview.classList.add('d-none');
        }
    });
</script>
@endsection
