@extends('Admin.layout.app')
@section('title', 'Tambah Ruangan')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Tambah Ruangan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Tambah Ruangan</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-4">Tambah Ruangan</h5>
            <form action="{{ route('ruangan.simpan') }}" method="POST">
              @csrf

              <div id="ruangan-container">
                <div class="mb-3">
                  <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                  <input type="text" class="form-control" name="ruangan[]" required>
                </div>
              </div>

              <button type="button" class="btn btn-secondary mt-3" onclick="addRuangan()">Tambah Ruangan Baru</button>
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
  function addRuangan() {
    var container = document.getElementById('ruangan-container');
    var newField = document.createElement('div');
    newField.className = 'mb-3';
    newField.innerHTML = `
      <label class="form-label">Nama Ruangan</label>
      <input type="text" class="form-control" name="ruangan[]" required>
    `;
    container.appendChild(newField);
  }
</script>
@endsection

@endsection
