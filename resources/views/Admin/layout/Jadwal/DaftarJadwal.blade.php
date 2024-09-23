@extends('Admin.layout.app')
@section('title', 'Daftar Jadwal')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Daftar Jadwal</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Daftar Jadwal</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row g-2">
      <div class="col-12 mb-3">
        <a href="{{ route('jadwal.tambah') }}" class="btn btn-success">Tambah Jadwal</a>
      </div>
      
      <div class="col-12 mb-3">
        <form method="GET" action="{{ route('jadwal.daftar') }}">
          <div class="input-group">
            <label for="tahunAjaran" class="form-label me-2">Pilih Tahun Ajaran:</label>
            <select id="tahunAjaran" name="tahun_ajaran" class="form-select" onchange="this.form.submit()">
              @foreach($tahunAjarans as $tahunAjaran)
                <option value="{{ $tahunAjaran->id }}" {{ $tahunAjaranId == $tahunAjaran->id ? 'selected' : '' }}>
                  {{ $tahunAjaran->tahun }}
                </option>
              @endforeach
            </select>
          </div>
        </form>
      </div>

      <div class="col-12 mb-3">
        <button class="btn btn-secondary me-2" onclick="filterByTingkat(null)">Semua Tingkat</button>
        <button class="btn btn-secondary me-2" onclick="filterByTingkat(10)">Tingkat 10</button>
        <button class="btn btn-secondary me-2" onclick="filterByTingkat(11)">Tingkat 11</button>
        <button class="btn btn-secondary" onclick="filterByTingkat(12)">Tingkat 12</button>
      </div>

      <div id="jadwalList" class="grid-container">
        @foreach($jadwalsGrouped as $className => $classJadwals)
          @php
            $jadwalCount = $classJadwals->count();
          @endphp

          @if($jadwalCount > 0)
            <div class="card h-100 mb-3">
              <div class="card-body p-2">
                <h5 class="card-title">{{ $className }}</h5>
                
                <div class="d-flex justify-content-center align-items-center mb-2 position-relative day-navigation">
                  <button class="btn btn-primary btn-sm position-absolute start-0" onclick="previousDay(this)"><<</button>
                  <span class="current-day mx-2">Senin</span>
                  <button class="btn btn-primary btn-sm position-absolute end-0" onclick="nextDay(this)">>></button>
                </div>               
                <table class="table table-bordered table-fixed">
                  <thead>
                    <tr>
                      <th class="col-2 text-center">Jam</th>
                      <th class="col-2 text-center">Ruangan</th>
                      <th class="col-2 text-center">Mata Pelajaran</th>
                      <th class="col-2 text-center">Guru</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($classJadwals as $jadwal)
                      <tr class="jadwal-row" data-hari="{{ $jadwal->hari }}" data-kelas="{{ $className }}">
                        <td class="col-2 text-center">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                        <td class="col-2 text-center">{{ $jadwal->ruangan->nama_ruangan }}</td>
                        <td class="col-2 text-center">{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                        <td class="col-2 text-center">{{ $jadwal->guru->nama }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <form action="{{ route('jadwal.hapus', ['id' => $classJadwals->first()->kelas_id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua jadwal untuk kelas ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Hapus Jadwal {{ $className }}</button>
                </form>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </section>

</main><!-- End #main -->

<!-- JavaScript -->
<script>
let selectedTingkat = null;
const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

function filterJadwal() {
    const jadwalItems = document.querySelectorAll('.jadwal-row');
    jadwalItems.forEach(item => {
        const itemKelas = item.getAttribute('data-kelas');
        const itemTingkat = parseInt(itemKelas.split(' ')[0], 10); // Ambil tingkat dari nama kelas

        if (selectedTingkat === null || itemTingkat === selectedTingkat) {
            item.style.display = ''; // Menampilkan
            item.closest('.card').style.display = ''; // Tampilkan kartu kelas
        } else {
            item.style.display = 'none'; // Menyembunyikan
            // Jika tidak ada jadwal yang ditampilkan, sembunyikan kartu kelas
            const card = item.closest('.card');
            if (!Array.from(card.querySelectorAll('.jadwal-row')).some(row => row.style.display !== 'none')) {
                card.style.display = 'none';
            }
        }
    });
    filterByDay()
}

function filterByTingkat(tingkat) {
    selectedTingkat = tingkat;
    filterJadwal();
}

function filterByDay() {
    const jadwalItems = document.querySelectorAll('.jadwal-row');

    jadwalItems.forEach(row => {
        const currentDaySpan = row.closest('.card').querySelector('.current-day');
        const currentDay = currentDaySpan.textContent;

        if (row.getAttribute('data-hari') === currentDay) {
            row.style.display = ''; // Tampilkan jika hari cocok
        } else {
            row.style.display = 'none'; // Sembunyikan jika tidak cocok
        }
    });
}

function previousDay(button) {
    const card = button.closest('.card');
    const currentDaySpan = card.querySelector('.current-day');
    let currentDayIndex = days.indexOf(currentDaySpan.textContent);
    currentDayIndex = (currentDayIndex - 1 + days.length) % days.length;
    currentDaySpan.textContent = days[currentDayIndex];
    filterByDay();
}

function nextDay(button) {
    const card = button.closest('.card');
    const currentDaySpan = card.querySelector('.current-day');
    let currentDayIndex = days.indexOf(currentDaySpan.textContent);
    currentDayIndex = (currentDayIndex + 1) % days.length;
    currentDaySpan.textContent = days[currentDayIndex];
    filterByDay();
}

document.addEventListener('DOMContentLoaded', function() {
    const tahunAjaranSelect = document.getElementById('tahunAjaran');
    tahunAjaranSelect.value = '{{ $tahunAjaranId }}';
    
    // Set current day to Monday and filter by day
    const currentDaySpan = document.querySelector('.current-day');
    currentDaySpan.textContent = 'Senin'; // Set to Monday
    filterByDay(); // Call to show only Monday's schedule
});
</script>

@endsection
