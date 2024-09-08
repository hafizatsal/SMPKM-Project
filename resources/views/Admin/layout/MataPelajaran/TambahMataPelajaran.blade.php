@extends('Admin.layout.app')
@section('title', 'Tambah Mata Pelajaran')
@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Tambah Mata Pelajaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Daftar Mata Pelajaran</a></li>
        <li class="breadcrumb-item active">Tambah Mata Pelajaran</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="card">
      <div class="card-body custom-padding-top"> <!-- Added custom class -->
        <form action="{{ route('matapelajaran.simpan') }}" method="POST">
          @csrf

          <div class="row mb-4">
            <label for="nama_mapel" class="col-sm-2 col-form-label">Nama Mata Pelajaran</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="{{ route('matapelajaran.daftar') }}" class="btn btn-secondary">Batal</a>
            </div>
          </div>

        </form>
      </div>
    </div>
  </section>

</main><!-- End #main -->
@endsection
