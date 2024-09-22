@extends('Admin.layout.app')
@section('title', 'Ubah Password')
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Ubah Password</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.profile') }}">Profil</a></li>
                <li class="breadcrumb-item active">Ubah Password</li>
            </ol>
        </nav>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Ubah Password untuk {{ $user->name }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    <span class="input-group-text">
                                        <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                    <span class="input-group-text">
                                        <i class="bi bi-eye-slash" id="togglePasswordConfirmation" style="cursor: pointer;"></i>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the icon
        this.classList.toggle('bi-eye');
    });

    const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
    const passwordConfirmation = document.querySelector('#password_confirmation');
    togglePasswordConfirmation.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmation.setAttribute('type', type);
        // toggle the icon
        this.classList.toggle('bi-eye');
    });
</script>

@endsection
