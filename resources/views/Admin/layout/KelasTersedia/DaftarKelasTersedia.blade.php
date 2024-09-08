@extends('Admin.layout.app')
@section('title', 'Daftar Kelas Tersedia')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Daftar Kelas Tersedia</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Daftar Kelas Tersedia</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-10 offset-md-1">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3>Daftar Kelas Tersedia</h3>
              <a href="{{ route('kelastersedia.tambah') }}" class="btn btn-primary">Tambah Kelas Tersedia</a>
            </div>
            <div class="card-body">
              <!-- Form untuk filter tahun ajaran -->
              <div class="mb-4">
                <div class="form-group">
                  <label for="tahun_ajaran_id">Pilih Tahun Ajaran</label>
                  <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-control" onchange="location = this.value;">
                    @foreach($tahunAjaran as $tahun)
                      <option value="{{ route('kelastersedia.daftar', ['tahun_ajaran_id' => $tahun->id]) }}"
                        {{ $tahun->id == $tahunAjaranId ? 'selected' : '' }}>
                        {{ $tahun->tahun }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <!-- Tabel Kelas Tersedia -->
              <table class="table table-striped" id="kelasTersediaTable">
                <thead>
                  <tr>
                    <th>Kelas</th>
                    <th>Ruangan</th>
                    <th>Tingkat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($kelasTersedia as $kelas)
                    <tr>
                      <td>{{ $kelas->kelas->nama_kelas }}</td>
                      <td>{{ $kelas->ruangan->nama_ruangan }}</td>
                      <td>{{ $kelas->tingkat }}</td> <!-- Menampilkan tingkat -->
                      <td class="text-end">
                        <a href="{{ route('kelastersedia.edit', $kelas->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                        <form action="{{ route('kelastersedia.hapus', $kelas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus ketersediaan kelas ini?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center">Belum ada data kelas tersedia.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->

@endsection
