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
              <form action="{{ route('kelastersedia.simpan') }}" method="POST">
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

                <div class="mb-3">
                  <label for="kelas_ids" class="form-label">Kelas</label>
                  <select name="kelas_ids[]" id="kelas_ids" class="form-control @error('kelas_ids') is-invalid @enderror" multiple>
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

                <div class="mb-3">
                  <label for="ruangan_id" class="form-label">Ruangan</label>
                  <select name="ruangan_id" id="ruangan_id" class="form-control @error('ruangan_id') is-invalid @enderror">
                    <option value="">Pilih Ruangan</option>
                    @foreach($ruangan as $ruang)
                      <option value="{{ $ruang->id }}">{{ $ruang->nama_ruangan }}</option>
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
