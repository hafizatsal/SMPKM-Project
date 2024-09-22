@extends('Admin.layout.app')
@section('title', 'Edit Jadwal')
@section('content')

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Edit Jadwal Kelas {{ $jadwal->kelas->nama_kelas }}</h1>
  </div><!-- End Page Title -->

  <section class="section dashboard">
  <form action="{{ route('jadwal.update', ['id' => $jadwal->id]) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="row g-2">
    <div class="col-2">
      <label>Jam Mulai</label>
      <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai) }}" class="form-control">
    </div>
    <div class="col-2">
      <label>Jam Selesai</label>
      <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai) }}" class="form-control">
    </div>
    <div class="col-2">
      <label>Hari</label>
      <input type="text" name="hari" value="{{ old('hari', $jadwal->hari) }}" class="form-control">
    </div>
    <div class="col-3">
      <label>Ruangan</label>
      <select name="ruangan_id" class="form-control">
        @foreach($ruangans as $ruangan)
          <option value="{{ $ruangan->id }}" {{ $jadwal->ruangan_id == $ruangan->id ? 'selected' : '' }}>
            {{ $ruangan->nama_ruangan }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-3">
      <label>Mata Pelajaran</label>
      <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-control mata-pelajaran-select">
        @foreach($mataPelajarans as $mataPelajaran)
          <option value="{{ $mataPelajaran->id }}" {{ $jadwal->mata_pelajaran_id == $mataPelajaran->id ? 'selected' : '' }}>
            {{ $mataPelajaran->nama_mapel }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-3">
      <label>Guru</label>
      <select name="guru_id" id="guru_id" class="form-control guru-select" data-selected-guru-id="{{ $jadwal->guru_id }}">
        <!-- Guru options will be populated dynamically based on selected Mata Pelajaran -->
      </select>
    </div>
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
  </div>
</form>
  </section>
</main><!-- End #main -->

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const mataPelajaranSelect = document.getElementById('mata_pelajaran_id');
    const guruSelect = document.getElementById('guru_id');
    const selectedGuruId = '{{ $jadwal->guru_id }}'; // Use Blade syntax to pass PHP value to JS
    
    const gurus = @json($gurus);
    const mataPelajarans = @json($mataPelajarans);

    // Function to update guru options based on selected mata pelajaran
    function updateGuruOptions(mataPelajaranId) {
      guruSelect.innerHTML = '<option value="">Pilih Guru</option>'; // Reset Guru options

      if (mataPelajaranId) {
        const filteredGurus = gurus.filter(guru => guru.mata_pelajarans.some(mp => mp.id === parseInt(mataPelajaranId)));
        filteredGurus.forEach(guru => {
          const option = document.createElement('option');
          option.value = guru.id;
          option.textContent = guru.nama;
          guruSelect.appendChild(option);
        });

        // Set the selected guru if one exists
        if (selectedGuruId) {
          guruSelect.value = selectedGuruId;
        }
      }
    }

    // Update on mata pelajaran change
    mataPelajaranSelect.addEventListener('change', function() {
      updateGuruOptions(this.value);
    });

    // Populate Guru options based on current Mata Pelajaran selection
    updateGuruOptions(mataPelajaranSelect.value);
  });
</script>
@endsection

@endsection
