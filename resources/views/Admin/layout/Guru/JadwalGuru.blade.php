@extends('Admin.layout.app')
@section('title', 'Jadwal Guru')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Jadwal Guru</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Jadwal Guru</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Daftar Guru dan Jadwal Mengajar</h5>

            <!-- List of Teachers -->
            <ul class="list-group">
              <!-- Dummy Data for Teacher 1 -->
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Guru 1</span>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#jadwal-1" aria-expanded="false" aria-controls="jadwal-1">
                  Lihat Jadwal
                </button>
              </li>
              <div class="collapse" id="jadwal-1">
                <ul class="list-group list-group-flush mt-2">
                  <li class="list-group-item">
                    <strong>Senin:</strong> 08:00 - 10:00 (Kelas 10A)
                  </li>
                  <li class="list-group-item">
                    <strong>Selasa:</strong> 10:00 - 12:00 (Kelas 11B)
                  </li>
                  <li class="list-group-item">
                    <strong>Rabu:</strong> 12:00 - 14:00 (Kelas 12C)
                  </li>
                </ul>
              </div>

              <!-- Dummy Data for Teacher 2 -->
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Guru 2</span>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#jadwal-2" aria-expanded="false" aria-controls="jadwal-2">
                  Lihat Jadwal
                </button>
              </li>
              <div class="collapse" id="jadwal-2">
                <ul class="list-group list-group-flush mt-2">
                  <li class="list-group-item">
                    <strong>Kamis:</strong> 08:00 - 10:00 (Kelas 10B)
                  </li>
                  <li class="list-group-item">
                    <strong>Jumat:</strong> 10:00 - 12:00 (Kelas 11A)
                  </li>
                  <li class="list-group-item">
                    <strong>Sabtu:</strong> 12:00 - 14:00 (Kelas 12B)
                  </li>
                </ul>
              </div>
            </ul>

          </div>
        </div>

      </div>
    </div>
  </section>

  <script>
    // Event listener for toggle buttons
    document.querySelectorAll('[data-toggle="collapse"]').forEach(item => {
      item.addEventListener('click', function(e) {
        e.preventDefault();
        let target = this.getAttribute('data-target');
        document.querySelector(target).classList.toggle('show');
      });
    });
  </script>

</main><!-- End #main -->
@endsection
