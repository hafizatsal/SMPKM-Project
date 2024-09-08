@extends('Admin.layout.app')
@section('title', 'Daftar Kelas')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Daftar Kelas</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Daftar Kelas</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row mb-3">
      <div class="col-12">
        <a href="{{ route('kelas.tambah') }}" class="btn btn-success">Tambah Kelas</a>
      </div>
    </div>

    <div class="row g-2">
      <!-- Kategori Kelas 10 -->
      <div class="col-12 mb-4">
        <h4 class="category-header" onclick="toggleVisibility('kelas10')">Kelas 10</h4>
        <div id="kelas10" class="category-content">
          @forelse($kelas10 as $kelas)
          <div class="col-md-3 d-inline-block">
            <div class="card h-100" style="border: 2px solid black;">
              <div class="card-body p-2">
                <h5 class="card-title">{{ $kelas->nama_kelas }}</h5>
              </div>
              <div class="card-footer">
                <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('kelas.hapus', $kelas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this class?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </div>
            </div>
          </div>
          @empty
          <p>No classes found for grade 10.</p>
          @endforelse
        </div>
      </div>

      <!-- Kategori Kelas 11 -->
      <div class="col-12 mb-4">
        <h4 class="category-header" onclick="toggleVisibility('kelas11')">Kelas 11</h4>
        <div id="kelas11" class="category-content">
          @forelse($kelas11 as $kelas)
          <div class="col-md-3 d-inline-block">
            <div class="card h-100" style="border: 2px solid black;">
              <div class="card-body p-2">
                <h5 class="card-title">{{ $kelas->nama_kelas }}</h5>
              </div>
              <div class="card-footer">
                <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('kelas.hapus', $kelas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this class?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </div>
            </div>
          </div>
          @empty
          <p>No classes found for grade 11.</p>
          @endforelse
        </div>
      </div>

      <!-- Kategori Kelas 12 -->
      <div class="col-12 mb-4">
        <h4 class="category-header" onclick="toggleVisibility('kelas12')">Kelas 12</h4>
        <div id="kelas12" class="category-content">
          @forelse($kelas12 as $kelas)
          <div class="col-md-3 d-inline-block">
            <div class="card h-100" style="border: 2px solid black;">
              <div class="card-body p-2">
                <h5 class="card-title">{{ $kelas->nama_kelas }}</h5>
              </div>
              <div class="card-footer">
                <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('kelas.hapus', $kelas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this class?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
              </div>
            </div>
          </div>
          @empty
          <p>No classes found for grade 12.</p>
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

@endsection
