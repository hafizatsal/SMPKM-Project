@extends('Admin.layout.app')
@section('title', 'Tambah Jadwal')
@section('content')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Tambah Jadwal</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('jadwal.daftar') }}">Daftar Jadwal</a></li>
        <li class="breadcrumb-item active">Tambah Jadwal</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Form Tambah Jadwal</h5>

        <!-- Form tambah jadwal -->
        <form action="{{ route('jadwal.simpan') }}" method="POST">
          @csrf

          <!-- Tahun Ajaran -->
          <div class="row mb-3">
            <label for="tahun_ajaran_id" class="col-sm-2 col-form-label">Tahun Ajaran</label>
            <div class="col-sm-10">
              <select id="tahun_ajaran_id" name="tahun_ajaran_id" class="form-select" required>
                <option value="">Pilih Tahun Ajaran</option>
                @foreach ($tahunAjarans as $tahunAjaran)
                  <option value="{{ $tahunAjaran->id }}">{{ $tahunAjaran->tahun }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Tingkatan Kelas -->
          <div class="row mb-3">
            <label for="tingkatan" class="col-sm-2 col-form-label">Tingkatan Kelas</label>
            <div class="col-sm-10">
              <select id="tingkatan" name="tingkatan" class="form-select" required>
                <option value="">Pilih Tingkatan</option>
                @foreach ($tingkatanKelas as $tingkat)
                  <option value="{{ $tingkat }}">{{ $tingkat }}</option>
                @endforeach
                <option value="semua">Semua Tingkat</option>
              </select>
            </div>
          </div>

         <!-- Guru -->
<div class="row mb-3">
  <label class="col-sm-2 col-form-label">Guru</label>
  <div class="col-sm-10">
    <div class="row flex-wrap">
      @php
        $guruByMapel = [];
        $mapelOrder = []; // Array untuk menyimpan urutan mata pelajaran
        foreach ($gurus as $guru) {
          foreach ($guru->mataPelajarans as $mapel) {
            if (!isset($guruByMapel[$mapel->nama_mapel])) {
              $guruByMapel[$mapel->nama_mapel] = [];
              $mapelOrder[] = $mapel->nama_mapel; // Tambahkan ke urutan
            }
            $guruByMapel[$mapel->nama_mapel][] = $guru;
          }
        }
      @endphp

      @foreach ($mapelOrder as $mapel)
        @if (isset($guruByMapel[$mapel]))
          @php
            $guruList = $guruByMapel[$mapel];
            $count = count($guruList);
          @endphp
          @for ($i = 0; $i < $count; $i++)
            @if ($i > 0 && $i % 5 == 0)
              <div class="w-100"></div>
            @endif
            @php
              $guru = $guruList[$i];
            @endphp
            <div class="col-md-2 col-sm-4 col-6">
              <div class="card guru-card-custom guru-card-details" data-id="{{ $guru->nip }}">
                <div class="card-body d-flex flex-column align-items-center">
                  <p class="guru-name">{{ $guru->nama }}</p>
                  <small class="mata-pelajaran">{{ $mapel }}</small>
                </div>
              </div>
            </div>
          @endfor
        @endif
      @endforeach
    </div>
    <input type="hidden" id="guru_ids" name="guru_ids">
  </div>
</div>

<!-- Mata Pelajaran -->
<div class="row mb-3">
  <label class="col-sm-2 col-form-label">Mata Pelajaran</label>
  <div class="col-sm-10">
    <div class="row flex-wrap">
      @foreach ($mapelOrder as $mapel)
        @foreach ($mataPelajarans as $mataPelajaran)
          @if ($mataPelajaran->nama_mapel == $mapel) <!-- Cocokkan dengan urutan -->
            <div class="col-md-2 col-sm-4 col-6">
              <div class="card mapel-card-custom" data-id="{{ $mataPelajaran->id }}">
                <div class="card-body text-center mapel-card-body">
                  <p class="mapel-name">{{ $mataPelajaran->nama_mapel }}</p>
                </div>
              </div>
            </div>
          @endif
        @endforeach
      @endforeach
      <input type="hidden" id="mata_pelajaran_ids" name="mata_pelajaran_ids">
    </div>
  </div>
</div>




          <!-- Sesi Waktu Senin-Kamis -->
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Sesi Waktu Senin-Kamis</label>
            <div class="col-sm-10">
              <div id="sesi-senin-kamis">
                <div class="row mb-2">
                  <div class="col-md-5">
                    <input type="time" name="senin_kamis_mulai[]" class="form-control" placeholder="Mulai" required>
                  </div>
                  <div class="col-md-5">
                    <input type="time" name="senin_kamis_selesai[]" class="form-control" placeholder="Selesai" required>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-success add-sesi-senin-kamis">Tambah Sesi</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Sesi Waktu Jumat -->
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Sesi Waktu Jumat</label>
            <div class="col-sm-10">
              <div id="sesi-jumat">
                <div class="row mb-2">
                  <div class="col-md-5">
                    <input type="time" name="jumat_mulai[]" class="form-control" placeholder="Mulai" required>
                  </div>
                  <div class="col-md-5">
                    <input type="time" name="jumat_selesai[]" class="form-control" placeholder="Selesai" required>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-success add-sesi-jumat">Tambah Sesi</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tombol Submit -->
          <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </form>
        <!-- End form tambah jadwal -->
      </div>
    </div>
  </section>
</main>

<!-- Script untuk menambah sesi waktu -->
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  let selectedGuruIds = [];
  let selectedMapelIds = [];

  // Tambah sesi Senin-Kamis
  document.querySelector('.add-sesi-senin-kamis').addEventListener('click', function () {
    const sesiTemplate = `
      <div class="row mb-2">
        <div class="col-md-5">
          <input type="time" name="senin_kamis_mulai[]" class="form-control" placeholder="Mulai" required>
        </div>
        <div class="col-md-5">
          <input type="time" name="senin_kamis_selesai[]" class="form-control" placeholder="Selesai" required>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-danger remove-sesi">Hapus</button>
        </div>
      </div>`;
    document.getElementById('sesi-senin-kamis').insertAdjacentHTML('beforeend', sesiTemplate);
  });

  // Tambah sesi Jumat
  document.querySelector('.add-sesi-jumat').addEventListener('click', function () {
    const sesiTemplate = `
      <div class="row mb-2">
        <div class="col-md-5">
          <input type="time" name="jumat_mulai[]" class="form-control" placeholder="Mulai" required>
        </div>
        <div class="col-md-5">
          <input type="time" name="jumat_selesai[]" class="form-control" placeholder="Selesai" required>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-danger remove-sesi">Hapus</button>
        </div>
      </div>`;
    document.getElementById('sesi-jumat').insertAdjacentHTML('beforeend', sesiTemplate);
  });

  // Remove sesi
  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-sesi')) {
      e.target.closest('.row').remove();
    }
  });

  // Pilih dan update ID guru
  document.querySelectorAll('.guru-card-custom').forEach(card => {
    card.addEventListener('click', function () {
      const id = card.getAttribute('data-id');
      card.classList.toggle('selected');

      if (card.classList.contains('selected')) {
        if (!selectedGuruIds.includes(id)) {
          selectedGuruIds.push(id);
        }
      } else {
        selectedGuruIds = selectedGuruIds.filter(guruId => guruId !== id);
      }

      // Update hidden input value
      const guruIdsInput = document.getElementById('guru_ids');
      guruIdsInput.value = selectedGuruIds.join(',');
    });
  });

  // Pilih dan update ID mata pelajaran
  document.querySelectorAll('.mapel-card-custom').forEach(card => {
    card.addEventListener('click', function () {
      const id = card.getAttribute('data-id');
      card.classList.toggle('selected');

      if (card.classList.contains('selected')) {
        if (!selectedMapelIds.includes(id)) {
          selectedMapelIds.push(id);
        }
      } else {
        selectedMapelIds = selectedMapelIds.filter(mapelId => mapelId !== id);
      }

      // Update hidden input value
      const mapelIdsInput = document.getElementById('mata_pelajaran_ids');
      mapelIdsInput.value = selectedMapelIds.join(',');
    });
  });
});
</script>
@endsection
