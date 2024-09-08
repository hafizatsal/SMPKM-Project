@extends('Admin.layout.app')
@section('title', 'Tambah Kelas')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Tambah Kelas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Tambah Kelas</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-4">Tambah Kelas</h5>
            <form action="{{ route('kelas.simpan') }}" method="POST">
              @csrf
              
              <div id="kelas-container">
                <div class="mb-3">
                  <label for="nama_kelas" class="form-label">Nama Kelas</label>
                  <input type="text" class="form-control" name="kelas[]" required>
                </div>
              </div>

              <button type="button" class="btn btn-secondary mt-3" onclick="addKelas()">Tambah Kelas Baru</button>
              <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->

@section('scripts')
<script>
  function addKelas() {
    var container = document.getElementById('kelas-container');
    var newField = document.createElement('div');
    newField.className = 'mb-3';
    newField.innerHTML = `
      <label class="form-label">Nama Kelas</label>
      <input type="text" class="form-control" name="kelas[]" required>
    `;
    container.appendChild(newField);
  }
</script>
@endsection

@endsection
