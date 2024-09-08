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
        <label for="tahunAjaran" class="form-label">Pilih Tahun Ajaran:</label>
        <select id="tahunAjaran" class="form-select" onchange="filterJadwal()">
          @foreach($tahunAjarans as $tahunAjaran)
            <option value="{{ $tahunAjaran->id }}" {{ $loop->last ? 'selected' : '' }}>{{ $tahunAjaran->tahun }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-12 mb-3">
  <button class="btn btn-secondary me-2" onclick="filterByTingkat(null)">Semua Tingkat</button>
  <button class="btn btn-secondary me-2" onclick="filterByTingkat(10)">Tingkat 10</button>
  <button class="btn btn-secondary me-2" onclick="filterByTingkat(11)">Tingkat 11</button>
  <button class="btn btn-secondary" onclick="filterByTingkat(12)">Tingkat 12</button>
</div>

      <div id="jadwalList" class="row g-2">
        @forelse($jadwals as $className => $classJadwals)
        <div class="col-md-6 jadwal-item" data-tahun-ajaran="{{ $classJadwals->first()->tahun_ajaran_id }}" data-tingkat="{{ $classJadwals->first()->kelas->tingkat }}">
          <div class="card h-100">
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
                    <th class="col-3">Jam</th>
                    <th class="col-3">Ruangan</th>
                    <th class="col-3">Mata Pelajaran</th>
                    <th class="col-3">Guru</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($classJadwals as $jadwal)
                    <tr class="jadwal-row" data-hari="{{ $jadwal->hari }}">
                      <td class="col-3">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                      <td class="col-3">{{ $jadwal->ruangan->nama_ruangan }}</td>
                      <td class="col-3">{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                      <td class="col-3">{{ $jadwal->guru->nama }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="card-footer">
              <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="btn btn-primary btn-sm">Edit</a>
              <form action="{{ route('jadwal.hapus', $jadwal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </div>
          </div>
        </div>
        @empty
        <p>No schedules found.</p>
        @endforelse
      </div>
    </div>
  </section>

</main><!-- End #main -->

<!-- JavaScript -->
<script>
let selectedTingkat = null;
const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

function filterJadwal() {
  const tahunAjaranId = document.getElementById('tahunAjaran').value;
  const jadwalItems = document.querySelectorAll('.jadwal-item');
  
  jadwalItems.forEach(item => {
    const itemTahunAjaran = item.getAttribute('data-tahun-ajaran');
    const itemTingkat = item.getAttribute('data-tingkat');
    
    if (
      (!tahunAjaranId || itemTahunAjaran == tahunAjaranId) &&
      (selectedTingkat === null || itemTingkat == selectedTingkat)
    ) {
      item.style.display = 'block';
    } else {
      item.style.display = 'none';
    }
  });

  filterByDay();
}

function filterByTingkat(tingkat) {
  selectedTingkat = tingkat;
  filterJadwal();
}

function filterByDay() {
  const jadwalItems = document.querySelectorAll('.jadwal-item');
  
  jadwalItems.forEach(item => {
    const currentDaySpan = item.querySelector('.current-day');
    const currentDay = currentDaySpan.textContent;
    const jadwalRows = item.querySelectorAll('.jadwal-row');
    
    jadwalRows.forEach(row => {
      if (row.getAttribute('data-hari') === currentDay) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
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

// Set the newest academic year automatically
document.addEventListener('DOMContentLoaded', function() {
  const tahunAjaranSelect = document.getElementById('tahunAjaran');
  if (tahunAjaranSelect.options.length > 0) {
    tahunAjaranSelect.value = tahunAjaranSelect.options[tahunAjaranSelect.options.length - 1].value;
    filterJadwal();
  }
  filterByDay(); // Initial filter by day
});
</script>

@endsection
