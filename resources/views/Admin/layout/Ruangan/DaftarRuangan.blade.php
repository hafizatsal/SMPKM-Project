@extends('Admin.layout.app')
@section('title', 'Daftar Ruangan')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Daftar Ruangan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Daftar Ruangan</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row g-2">
      <div class="col-12 mb-3">
        <a href="{{ route('ruangan.tambah') }}" class="btn btn-success">Tambah Ruangan</a>
      </div>

      <!-- Kategori Ruangan 10 -->
      <div class="col-12 mb-4">
        <h4 class="category-header" onclick="toggleVisibility('ruangan10')">Ruang 10</h4>
        <div id="ruangan10" class="category-content">
          @forelse($ruangan10 as $ruang)
          <div class="col-md-3 d-inline-block">
            <div class="card h-100 card-custom-border">
              <div class="card-body p-2">
                <h5 class="card-title">{{ $ruang->nama_ruangan }}</h5>
              </div>
              <div class="card-footer">
                <a href="{{ route('ruangan.edit', $ruang->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('ruangan.hapus', $ruang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this room?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </div>
            </div>
          </div>
          @empty
          <p>No rooms found in category 10.</p>
          @endforelse
        </div>
      </div>

      <!-- Kategori Ruangan 11 -->
      <div class="col-12 mb-4">
        <h4 class="category-header" onclick="toggleVisibility('ruangan11')">Ruang 11</h4>
        <div id="ruangan11" class="category-content">
          @forelse($ruangan11 as $ruang)
          <div class="col-md-3 d-inline-block">
            <div class="card h-100 card-custom-border">
              <div class="card-body p-2">
                <h5 class="card-title">{{ $ruang->nama_ruangan }}</h5>
              </div>
              <div class="card-footer">
                <a href="{{ route('ruangan.edit', $ruang->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('ruangan.hapus', $ruang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this room?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </div>
            </div>
          </div>
          @empty
          <p>No rooms found in category 11.</p>
          @endforelse
        </div>
      </div>

      <!-- Kategori Ruangan 12 -->
      <div class="col-12 mb-4">
        <h4 class="category-header" onclick="toggleVisibility('ruangan12')">Ruang 12</h4>
        <div id="ruangan12" class="category-content">
          @forelse($ruangan12 as $ruang)
          <div class="col-md-3 d-inline-block">
            <div class="card h-100 card-custom-border">
              <div class="card-body p-2">
                <h5 class="card-title">{{ $ruang->nama_ruangan }}</h5>
              </div>
              <div class="card-footer">
                <a href="{{ route('ruangan.edit', $ruang->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('ruangan.hapus', $ruang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this room?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </div>
            </div>
          </div>
          @empty
          <p>No rooms found in category 12.</p>
          @endforelse
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->

@section('scripts')
<script>
  function toggleVisibility(categoryId) {
    var element = document.getElementById(categoryId);
    if (element.style.display === "none" || element.style.display === "") {
      element.style.display = "block";
    } else {
      element.style.display = "none";
    }
  }
</script>
@endsection

<style>
  .card-custom-border {
    border: 0.5px solid black;
  }
</style>

@endsection
