@extends('Admin.layout.app')
@section('title', 'Edit Kelas Tersedia')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Edit Kelas Tersedia</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('kelastersedia.daftar') }}">Daftar Kelas Tersedia</a></li>
        <li class="breadcrumb-item active">Edit Kelas Tersedia</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="card">
            <div class="card-header">
              <h3>Edit Kelas Tersedia</h3>
            </div>
            <div class="card-body">
              <form action="{{ route('kelastersedia.update', $kelasTersedia->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                  <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-control @error('tahun_ajaran_id') is-invalid @enderror">
                    <option value="">Pilih Tahun Ajaran</option>
                    @foreach($tahunAjaran as $tahun)
                      <option value="{{ $tahun->id }}" {{ $tahun->id == $kelasTersedia->tahun_ajaran_id ? 'selected' : '' }}>
                        {{ $tahun->tahun }}
                      </option>
                    @endforeach
                  </select>
                  @error('tahun_ajaran_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="kelas_id" class="form-label">Kelas</label>
                  <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $kls)
                      <option value="{{ $kls->id }}" {{ $kls->id == $kelasTersedia->kelas_id ? 'selected' : '' }}>
                        {{ $kls->nama_kelas }} (Tingkat: {{ $kls->tingkat }})
                      </option>
                    @endforeach
                  </select>
                  @error('kelas_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="ruangan_id" class="form-label">Ruangan</label>
                  <select name="ruangan_id" id="ruangan_id" class="form-control @error('ruangan_id') is-invalid @enderror">
                    <option value="">Pilih Ruangan</option>
                    @foreach($ruangan as $ruang)
                      <option value="{{ $ruang->id }}" {{ $ruang->id == $kelasTersedia->ruangan_id ? 'selected' : '' }}>
                        {{ $ruang->nama_ruangan }}
                      </option>
                    @endforeach
                  </select>
                  @error('ruangan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <button type="submit" class="btn btn-primary">Simpan</button>
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
@endsection
