@extends('Admin.layout.app')
@section('title', 'Daftar Guru')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Daftar Guru</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Daftar Guru</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row g-2">
      <div class="col-12 mb-3">
        <a href="{{ route('guru.tambah') }}" class="btn btn-success">Tambah Guru</a>
      </div>
      @forelse($gurus as $guru)
      <div class="col-md-3">
        <div class="card h-100 guru-card">
          @php
            // Tentukan path gambar atau gambar default jika tidak ada gambar
            $imagePath = $guru->foto ? asset($guru->foto) : asset('assets/img/profile-img.jpg');
            // Ambil mata pelajaran yang diajarkan oleh guru ini
            $mataPelajaran = $guru->guruMataPelajaran->pluck('mataPelajaran.nama_mapel')->implode(', ');
          @endphp
          <img src="{{ $imagePath }}" class="card-img-top guru-image" alt="{{ $guru->nama }}">
          <div class="card-body p-2">
            <h5 class="card-title">{{ $guru->nama }}</h5>
            <p class="card-text"><strong>NIP:</strong> {{ $guru->nip }}</p>
            <p class="card-text"><strong>Jenis Kelamin:</strong> {{ $guru->jenis_kelamin }}</p>
            <p class="card-text"><strong>Tanggal Lahir:</strong> {{ $guru->tanggal_lahir }}</p>
            <p class="card-text"><strong>Alamat:</strong> {{ $guru->alamat }}</p>
            <p class="card-text"><strong>Nomor Telepon:</strong> {{ $guru->telepon }}</p>
            <p class="card-text"><strong>Email:</strong> {{ $guru->email }}</p>
            <p class="card-text"><strong>Mata Pelajaran:</strong> {{ $mataPelajaran }}</p>
          </div>
          <div class="card-footer">
            <a href="{{ route('guru.edit', $guru->nip) }}" class="btn btn-primary btn-sm">Edit</a>
            <form action="{{ route('guru.hapus', $guru->nip) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
          </div>
        </div>
      </div>
      @empty
      <p>No teachers found.</p>
      @endforelse
    </div>
  </section>

</main><!-- End #main -->
@endsection
