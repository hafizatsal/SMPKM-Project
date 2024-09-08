@extends('Admin.layout.app')
@section('title', 'Tambah Guru')
@section('content')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Tambah Guru</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('guru.daftar') }}">Daftar Guru</a></li>
        <li class="breadcrumb-item active">Tambah Guru</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="card">
      <div class="card-body p-4"> <!-- Added padding to card body -->
        <form action="{{ route('guru.simpan') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Nama Guru</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="nip" class="col-sm-2 col-form-label">NIP</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nip" name="nip" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-10">
              <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
            <div class="col-sm-10">
              <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="telepon" class="col-sm-2 col-form-label">Nomor Telepon</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="telepon" name="telepon" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="foto" class="col-sm-2 col-form-label">Foto Profil</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" id="foto" name="foto">
            </div>
          </div>

          <div class="row mb-3">
            <label for="mata_pelajaran" class="col-sm-2 col-form-label">Mata Pelajaran</label>
            <div class="col-sm-10">
              <select id="mata_pelajaran" name="mata_pelajaran_id" class="form-select" required>
                <option value="">Pilih Mata Pelajaran</option>
                @foreach ($mataPelajarans as $mataPelajaran)
                  <option value="{{ $mataPelajaran->id }}">{{ $mataPelajaran->nama_mapel }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </section>

</main><!-- End #main -->
@endsection
