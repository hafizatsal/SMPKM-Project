@extends('Admin.layout.app')
@section('title', 'Dashboard')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Date Card -->
            <div class="col-lg-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $currentDay }}, {{ $currentDate }}</h5>
                        <p class="clock" id="clock" style="font-size: 2rem; text-align: center;">{{ $currentTime }}</p>
                    </div>
                </div>
            </div><!-- End Date Card -->

            <!-- Academic Year Card -->
            <div class="col-lg-12 text-center mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tahun Ajaran: {{ $academicYear }}</h5>
                    </div>
                </div>
            </div><!-- End Academic Year Card -->

        </div>

        <div class="row mt-3">

            <!-- Jadwal Hari Ini Card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jadwal Hari Ini</h5>
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Pilih Tingkat:</label>
                            <select id="tingkat" class="form-select" onchange="filterJadwal(this.value, 'A')">
                                <option value="10">Tingkat 10</option>
                                <option value="11">Tingkat 11</option>
                                <option value="12">Tingkat 12</option>
                            </select>
                        </div>
                        <div class="mb-3 text-center">
                            <button onclick="changeClass('left')" class="btn btn-secondary">←</button>
                            <button onclick="changeClass('right')" class="btn btn-secondary">→</button>
                        </div>
                        @if($jadwalHariIni->isNotEmpty())
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Jam</th>
                                        <th>Ruangan</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jadwalHariIni as $jadwal)
                                        <tr>
                                            <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                            <td>{{ $jadwal->ruangan->nama_ruangan }}</td>
                                            <td>{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                                            <td>{{ $jadwal->guru->nama }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Tidak ada jadwal untuk hari ini.</p>
                        @endif

                        <!-- Button Daftar Jadwal di bawah Jadwal Hari Ini -->
                        <div class="text-center mt-3">
    <a href="{{ route('home.jadwal.daftar') }}" class="btn btn-primary">
        Lihat Daftar Jadwal
    </a>
</div>
                    </div>
                </div>
            </div><!-- End Jadwal Hari Ini Card -->

            <!-- Jadwal Saat Ini Card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jadwal Saat Ini</h5>
                        <div class="mb-3">
                            <label for="tingkat-saat-ini" class="form-label">Pilih Tingkat:</label>
                            <select id="tingkat-saat-ini" class="form-select" onchange="filterJadwalSaatIni(this.value, 'A')">
                                <option value="10">Tingkat 10</option>
                                <option value="11">Tingkat 11</option>
                                <option value="12">Tingkat 12</option>
                            </select>
                        </div>
                        @if($jadwalSekarang->isNotEmpty())
                            <ul id="jadwal-sekarang-list">
                                @foreach($jadwalSekarang as $jadwal)
                                    <li>
                                        <strong>{{ $jadwal->mataPelajaran->nama_mapel }} ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})</strong>
                                        <br>Kelas: {{ $jadwal->kelas->nama_kelas }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Saat ini tidak ada jadwal yang sedang berlangsung.</p>
                        @endif
                    </div>
                </div>
            </div><!-- End Jadwal Saat Ini Card -->

        </div>

    </section>

</main><!-- End Main -->

<script>
    let currentClass = 'A'; // Default class
    let currentGrade = '10'; // Default grade

    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        document.getElementById('clock').innerText = timeString;
    }

    function changeClass(direction) {
        const classes = ['A', 'B'];
        const currentIndex = classes.indexOf(currentClass);
        if (direction === 'right') {
            currentClass = classes[(currentIndex + 1) % classes.length]; // Next class
        } else {
            currentClass = classes[(currentIndex - 1 + classes.length) % classes.length]; // Previous class
        }

        filterJadwal(currentGrade, currentClass);
        filterJadwalSaatIni(currentGrade, currentClass);
    }

    function filterJadwal(tingkat, kelas) {
        fetch(`/jadwal?tingkat=${tingkat}&kelas=${kelas}`)
            .then(response => response.json())
            .then(data => {
                const jadwalList = document.getElementById('jadwal-list');
                jadwalList.innerHTML = '';

                if (data.jadwal.length > 0) {
                    data.jadwal.forEach(jadwal => {
                        jadwalList.innerHTML += `<li><strong>${jadwal.mataPelajaran.nama_mapel} (${jadwal.jam_mulai} - ${jadwal.jam_selesai})</strong><br>Kelas: ${jadwal.kelas.nama_kelas}</li>`;
                    });
                } else {
                  jadwalList.innerHTML = '<p>Tidak ada jadwal untuk hari ini.</p>';
                }
            });
    }

    function filterJadwalSaatIni(tingkat, kelas) {
        fetch(`/jadwal?tingkat=${tingkat}&kelas=${kelas}`)
            .then(response => response.json())
            .then(data => {
                const jadwalList = document.getElementById('jadwal-sekarang-list');
                jadwalList.innerHTML = '';

                if (data.jadwal.length > 0) {
                    data.jadwal.forEach(jadwal => {
                        jadwalList.innerHTML += `<li><strong>${jadwal.mataPelajaran.nama_mapel} (${jadwal.jam_mulai} - ${jadwal.jam_selesai})</strong><br>Kelas: ${jadwal.kelas.nama_kelas}</li>`;
                    });
                } else {
                    jadwalList.innerHTML = '<p>Saat ini tidak ada jadwal yang sedang berlangsung.</p>';
                }
            });
    }

    // Update the clock immediately, and then every second
    updateClock();
    setInterval(updateClock, 1000);
</script>

@endsection

