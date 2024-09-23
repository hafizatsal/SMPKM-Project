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
            <div class="col-lg-12 text-center">
                <div class="card mx-auto" style="max-width: 800px;">
                    <div class="card-body">
                        <h5 class="card-title">Jadwal Hari Ini</h5>
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Pilih Tingkat:</label>
                            <select id="tingkat" class="form-select" onchange="filterJadwal(this.value)">
                                <option value="all">Semua Tingkat</option>
                                <option value="10">Tingkat 10</option>
                                <option value="11">Tingkat 11</option>
                                <option value="12">Tingkat 12</option>
                            </select>
                        </div>
                        <div class="mb-3 text-center">
                            <span class="mx-3" id="current-class-name" style="cursor: pointer;">
                                @if($jadwalsGrouped->isNotEmpty())
                                    {{ $jadwalsGrouped->keys()->first() }} <!-- Menampilkan nama kelas pertama -->
                                @else
                                    Tidak ada kelas
                                @endif
                            </span>
                        </div>

                        <div id="jadwal-list" class="table-responsive">
                            @if($jadwalHariIni->isNotEmpty())
                                <table class="table table-bordered text-center" style="table-layout: fixed; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%;">Jam</th>
                                            <th style="width: 25%;">Ruangan</th>
                                            <th style="width: 25%;">Mata Pelajaran</th>
                                            <th style="width: 25%;">Guru</th>
                                        </tr>
                                    </thead>
                                    <tbody id="jadwal-body">
                                        @foreach($jadwalHariIni as $jadwal)
                                            <tr data-kelas="{{ $jadwal->kelas->nama_kelas }}" data-tingkat="{{ $jadwal->kelas->tingkat }}">
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
                        </div>

                        <!-- Button Daftar Jadwal di bawah Jadwal Hari Ini -->
                        <div class="text-center mt-3">
                            <a href="{{ route('home.jadwal.daftar') }}" class="btn btn-primary">
                                Lihat Daftar Jadwal
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- End Jadwal Hari Ini Card -->

        </div>

    </section>

</main><!-- End Main -->

<script>
    let currentIndex = 0; // Menyimpan indeks kelas saat ini
    let currentClasses = []; // Menyimpan kelas yang sesuai dengan tingkat yang dipilih
    let jadwalPerKelas = {}; // Menyimpan jadwal per kelas

    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        document.getElementById('clock').innerText = timeString;
    }

    function fetchJadwal(tingkat, kelas, isCurrent = false) {
        const url = `/jadwal?tingkat=${tingkat}&kelas=${kelas}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (isCurrent) {
                    updateJadwalSaatIni(data.jadwal);
                } else {
                    updateJadwal(data.jadwal);
                }
            })
            .catch(error => console.error('Error fetching jadwal:', error));
    }

    function updateJadwal(jadwal) {
        const jadwalList = document.getElementById('jadwal-body');
        jadwalList.innerHTML = ''; // Kosongkan tabel

        // Reset jadwal per kelas
        jadwalPerKelas = {};

        if (jadwal.length > 0) {
            jadwal.forEach(item => {
                const kelas = item.kelas.nama_kelas;
                if (!jadwalPerKelas[kelas]) {
                    jadwalPerKelas[kelas] = [];
                }
                jadwalPerKelas[kelas].push(item);
            });
            updateJadwalList(); // Tampilkan jadwal kelas pertama
        } else {
            jadwalList.innerHTML = '<tr><td colspan="4">Tidak ada jadwal untuk hari ini.</td></tr>';
        }
    }

    function filterJadwal(tingkat) {
        const rows = document.querySelectorAll('#jadwal-body tr');
        currentClasses = []; // Reset kelas saat filter
        rows.forEach(row => {
            const rowTingkat = row.getAttribute('data-tingkat');

            if (tingkat === 'all' || rowTingkat == tingkat) {
                row.style.display = ''; // Tampilkan baris
                currentClasses.push(row); // Tambahkan ke daftar kelas yang sesuai
            } else {
                row.style.display = 'none'; // Sembunyikan baris
            }
        });

        currentIndex = 0; // Reset indeks saat filter
        updateCurrentClassName(); // Update nama kelas yang ditampilkan

        // Cek apakah currentClasses tidak kosong
        if (currentClasses.length > 0) {
            updateJadwalList(); // Update daftar jadwal
        } else {
            document.getElementById('jadwal-body').innerHTML = '<tr><td colspan="4">Tidak ada kelas untuk tingkat ini.</td></tr>';
        }
    }

    function updateJadwalList() {
        const rows = document.querySelectorAll('#jadwal-body tr');
        rows.forEach(row => {
            const rowKelas = row.getAttribute('data-kelas');
            if (currentClasses.length > 0 && rowKelas === currentClasses[currentIndex].getAttribute('data-kelas')) {
                row.style.display = ''; // Tampilkan kelas yang dipilih
            } else {
                row.style.display = 'none'; // Sembunyikan kelas yang tidak dipilih
            }
        });
    }

    function updateCurrentClassName() {
        const currentClassName = document.getElementById('current-class-name');
        currentClassName.textContent = currentClasses.length > 0 ? currentClasses[currentIndex].getAttribute('data-kelas') : 'Tidak ada kelas';
        currentClassName.onclick = changeClassOnClick; // Menambahkan event listener klik
    }

    function changeClassOnClick() {
        if (currentClasses.length > 0) {
            let currentClass = currentClasses[currentIndex].getAttribute('data-kelas');
            
            // Cari kelas berikutnya yang berbeda dari kelas saat ini
            do {
                currentIndex = (currentIndex + 1) % currentClasses.length;
            } while (currentClasses[currentIndex].getAttribute('data-kelas') === currentClass);
            
            // Update nama kelas dan daftar jadwal
            updateCurrentClassName();
            updateJadwalList();
        }
    }

    // Update clock setiap detik
    setInterval(updateClock, 1000);

    // Inisialisasi jadwal saat halaman dimuat
    window.onload = function () {
        filterJadwal('all'); // Tampilkan semua jadwal saat dimuat
        fetchJadwal('10'); // Ambil jadwal untuk tingkat 10 dan kelas 10A
    };
</script>

@endsection
