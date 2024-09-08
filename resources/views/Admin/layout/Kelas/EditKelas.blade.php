@extends('Admin.layout.app')
@section('title', 'Edit Kelas')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Edit Kelas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('kelas.daftar') }}">Daftar Kelas</a></li>
        <li class="breadcrumb-item active">Edit Kelas</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-4">Edit Kelas</h5>
            <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
              </div>

              <button type="submit" class="btn btn-primary mt-3">Update</button>
              <a href="{{ route('kelas.daftar') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->

@endsection
