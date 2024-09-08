@extends('Admin.layout.app')
@section('title', 'Daftar Mata Pelajaran')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Daftar Mata Pelajaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Daftar Mata Pelajaran</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-10 offset-md-1">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3>Daftar Mata Pelajaran</h3>
              <a href="{{ route('matapelajaran.tambah') }}" class="btn btn-primary">Tambah Mata Pelajaran</a>
            </div>
            <div class="card-body">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Nama Mata Pelajaran</th>
                  </tr>
                </thead>
                <tbody>
                  @if($mataPelajarans->isEmpty())
                    <tr>
                      <td colspan="2" class="text-center">Belum ada data mata pelajaran.</td>
                    </tr>
                  @else
                    @foreach($mataPelajarans as $mataPelajaran)
                      <tr>
                        <td>{{ $mataPelajaran->nama_mapel }}</td>
                        <td class="text-end">
                          <a href="{{ route('matapelajaran.edit', $mataPelajaran->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                          <form action="{{ route('matapelajaran.hapus', $mataPelajaran->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  @endif
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
