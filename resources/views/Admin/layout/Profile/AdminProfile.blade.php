@extends('Admin.layout.app')
@section('title', 'Admin Profile')
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Admin Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Admin Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="container mt-5">
        <div class="row">
            <!-- Card for User Profile -->
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Informasi Pengguna</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="created_at" class="form-label">Dibuat pada</label>
                            <input type="text" name="created_at" id="created_at" class="form-control" value="{{ $user->created_at->format('d M Y') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="updated_at" class="form-label">Terakhir diperbarui</label>
                            <input type="text" name="updated_at" id="updated_at" class="form-control" value="{{ $user->updated_at->format('d M Y') }}" readonly>
                        </div>

                        <!-- Tampilkan total pengguna hanya untuk pengguna terlama -->
                        @php
                            $oldestUser = \App\Models\User::orderBy('id')->first();
                        @endphp
                        @if ($user->id === $oldestUser->id)
                            <div class="mb-3">
                                <label for="total_users" class="form-label">Jumlah Pengguna</label>
                                <input type="text" name="total_users" id="total_users" class="form-control" value="{{ $totalUsers }}" readonly>
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('admin.profile.edit', $user->id) }}" class="btn btn-primary">
                                Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
