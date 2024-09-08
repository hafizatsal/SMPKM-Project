@extends('Admin.layout.app')
@section('title', 'Edit Mata Pelajaran')
@section('content')

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Edit Mata Pelajaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Edit Mata Pelajaran</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-4">Edit Mata Pelajaran</h5>
            <form action="{{ route('matapelajaran.update', $mataPelajaran->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label for="nama_mapel" class="form-label">Nama Mata Pelajaran</label>
                <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" value="{{ $mataPelajaran->nama_mapel }}" required>
              </div>

              <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->

@endsection
