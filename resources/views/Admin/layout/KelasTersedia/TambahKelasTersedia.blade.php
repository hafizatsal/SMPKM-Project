@extends('Admin.layout.app')
@section('title', 'Tambah Kelas Tersedia')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Tambah Kelas Tersedia</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('kelastersedia.daftar') }}">Daftar Kelas Tersedia</a></li>
        <li class="breadcrumb-item active">Tambah Kelas Tersedia</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="card">
            <div class="card-header">
              <h3>Tambah Kelas Tersedia</h3>
            </div>
            <div class="card-body">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

              <form action="{{ route('kelastersedia.simpan') }}" method="POST" id="kelasForm">
                @csrf
                <div class="mb-3">
                  <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                  <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-control @error('tahun_ajaran_id') is-invalid @enderror">
                    <option value="">Pilih Tahun Ajaran</option>
                    @foreach($tahunAjaran as $tahun)
                      <option value="{{ $tahun->id }}">{{ $tahun->tahun }}</option>
                    @endforeach
                  </select>
                  @error('tahun_ajaran_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div id="kelas-ruangan-container">
                  <div class="row mb-3">
                    <div class="col-md-5">
                      <label for="kelas_ids" class="form-label">Kelas</label>
                      <select name="kelas_ids[]" class="form-control @error('kelas_ids') is-invalid @enderror" multiple>
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $kls)
                          <option value="{{ $kls->id }}" data-tingkat="{{ $kls->tingkat }}">
                            {{ $kls->nama_kelas }} (Tingkat: {{ $kls->tingkat }})
                          </option>
                        @endforeach
                      </select>
                      @error('kelas_ids')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-md-5">
                      <label for="ruangan_ids" class="form-label">Ruangan</label>
                      <select name="ruangan_ids[]" class="form-control @error('ruangan_ids') is-invalid @enderror" multiple>
                        <option value="">Pilih Ruangan</option>
                        @foreach($ruangan as $ruang)
                          <option value="{{ $ruang->id }}">{{ $ruang->nama_ruangan }}</option>
                        @endforeach
                      </select>
                      @error('ruangan_ids')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                      <button type="button" class="btn btn-danger" onclick="removeRow(this)">Hapus</button>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <button type="button" class="btn btn-primary" onclick="addRow()">Tambah Kelas dan Ruangan</button>
                </div>

                <!-- Buttons below the dynamically added rows -->
                <div class="mb-3">
                  <button type="submit" class="btn btn-success">Simpan</button>
                  <a href="{{ route('kelastersedia.daftar') }}" class="btn btn-secondary">Kembali</a>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->

<script>
  function addRow() {
    const container = document.getElementById('kelas-ruangan-container');
    const row = document.createElement('div');
    row.className = 'row mb-3';
    row.innerHTML = `
      <div class="col-md-5">
        <label for="kelas_ids" class="form-label">Kelas</label>
        <select name="kelas_ids[]" class="form-control" multiple>
          <option value="">Pilih Kelas</option>
          @foreach($kelas as $kls)
            <option value="{{ $kls->id }}" data-tingkat="{{ $kls->tingkat }}">
              {{ $kls->nama_kelas }} (Tingkat: {{ $kls->tingkat }})
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-5">
        <label for="ruangan_ids" class="form-label">Ruangan</label>
        <select name="ruangan_ids[]" class="form-control" multiple>
          <option value="">Pilih Ruangan</option>
          @foreach($ruangan as $ruang)
            <option value="{{ $ruang->id }}">{{ $ruang->nama_ruangan }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="button" class="btn btn-danger" onclick="removeRow(this)">Hapus</button>
      </div>
    `;
    container.appendChild(row);
  }

  function removeRow(button) {
    const row = button.closest('.row');
    row.remove();
  }
</script>

@endsection
