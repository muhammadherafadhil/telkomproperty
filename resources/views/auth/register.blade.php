@extends('welcome')

@section('title', 'Halaman Register')

@section('content')
<div class="container">
    <h1>Form Tambahkan Akun</h1>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">NIK</label>
            <input type="text" name="nik" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
@endsection
