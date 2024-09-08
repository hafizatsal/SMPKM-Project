@extends('Admin.layout.app')
@section('title', 'Edit Ruangan')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Edit Ruangan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('ruangan.daftar') }}">Daftar Ruangan</a></li>
        <li class="breadcrumb-item active">Edit Ruangan</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Form Edit Ruangan</h5>

            <!-- General Form Elements -->
            <form action="{{ route('ruangan.update', $ruangan->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="row mb-3">
                <label for="nama_ruangan" class="col-sm-2 col-form-label">Nama Ruangan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control @error('nama_ruangan') is-invalid @enderror" id="nama_ruangan" name="nama_ruangan" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}" required>
                  @error('nama_ruangan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <a href="{{ route('ruangan.daftar') }}" class="btn btn-secondary">Cancel</a>
                </div>
              </div>

            </form><!-- End General Form Elements -->

          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->

@endsection
