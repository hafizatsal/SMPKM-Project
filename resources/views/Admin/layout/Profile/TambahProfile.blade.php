@extends('Admin.layout.app')
@section('title', 'Tambah Admin')
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tambah Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Tambah Admin</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <form action="{{ route('admin.profile.simpan') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility()">
                    <i id="eyeIcon" class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" onclick="toggleConfirmPasswordVisibility()">
                    <i id="confirmEyeIcon" class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Admin</button>
    </form>
</main>

<script>
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove('bi-eye');
        eyeIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove('bi-eye-slash');
        eyeIcon.classList.add('bi-eye');
    }
}

function toggleConfirmPasswordVisibility() {
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const confirmEyeIcon = document.getElementById('confirmEyeIcon');
    
    if (confirmPasswordInput.type === "password") {
        confirmPasswordInput.type = "text";
        confirmEyeIcon.classList.remove('bi-eye');
        confirmEyeIcon.classList.add('bi-eye-slash');
    } else {
        confirmPasswordInput.type = "password";
        confirmEyeIcon.classList.remove('bi-eye-slash');
        confirmEyeIcon.classList.add('bi-eye');
    }
}
</script>

@endsection
