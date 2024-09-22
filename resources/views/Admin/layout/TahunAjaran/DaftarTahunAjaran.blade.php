@extends('Admin.layout.app')
@section('title', 'Daftar Tahun Ajaran')
@section('content')

<main id="main" class="main">
<div class="pagetitle">
    <h1>Daftar Tahun Ajaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Daftar Tahun Ajaran</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

<div class="container mt-5">
    <div class="row">
        <!-- Card for Adding Academic Year -->
        <div class="col-md-12">
            <div class="card bg-primary text-white mb-4">
                <div class="card-header">
                    <h3>Tambah Tahun Ajaran</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('tahunajaran.simpan') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tahun">Tahun Ajaran</label>
                            <input type="text" name="tahun" id="tahun" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-light mt-3">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <!-- Card for Listing Academic Years -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Daftar Tahun Ajaran</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tahun Ajaran</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($tahunAjarans->isEmpty())
                                <tr>
                                    <td colspan="2" class="text-center">Belum ada data tahun ajaran.</td>
                                </tr>
                            @else
                                @foreach($tahunAjarans as $tahunAjaran)
                                    <tr>
                                        <td>{{ $tahunAjaran->tahun }}</td>
                                        <td class="text-end">
                                            <form action="{{ route('tahunajaran.hapus', $tahunAjaran->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash3"></i>
                                                </button>
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
</main>
@endsection