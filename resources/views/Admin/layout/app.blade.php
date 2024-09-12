<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title', 'Default Title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
      <img src="{{ asset('assets/img/logo.png') }}" alt="">
        <span class="d-none d-lg-block">KuMan</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">ADMIN</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>ADMIN</h6>
              <span>ADMIN</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- Sidebar -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Daftar Guru -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('guru.daftar') ? 'active' : 'collapsed' }}" href="{{ route('guru.daftar') }}">
                <i class="bi bi-person"></i>
                <span>Daftar Guru</span>
            </a>
        </li>
        @if(request()->routeIs('guru.tambah') || request()->routeIs('guru.edit'))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('guru.tambah') ? '' : 'collapsed' }}" href="{{ route('guru.tambah') }}">
                <i class="bi bi-circle"></i>
                <span>Tambah Guru</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('guru.edit') ? '' : 'collapsed' }}" href="{{ route('guru.edit', ['id' => $guru->id ?? 0]) }}">
                <i class="bi bi-circle"></i>
                <span>Edit Guru</span>
            </a>
        </li>
        @endif

        <!-- Daftar Tahun Ajaran -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('tahunajaran.daftar') ? '' : 'collapsed' }}" href="{{ route('tahunajaran.daftar') }}">
                <i class="bi bi-calendar"></i>
                <span>Daftar Tahun Ajaran</span>
            </a>
        </li>

        <!-- Daftar Mata Pelajaran -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('matapelajaran.daftar') ? '' : 'collapsed' }}" href="{{ route('matapelajaran.daftar') }}">
                <i class="bi bi-book"></i>
                <span>Daftar Mata Pelajaran</span>
            </a>
        </li>
        @if(request()->routeIs('matapelajaran.tambah') || request()->routeIs('matapelajaran.edit'))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('matapelajaran.tambah') ? '' : 'collapsed' }}" href="{{ route('matapelajaran.tambah') }}">
                <i class="bi bi-circle"></i>
                <span>Tambah Mata Pelajaran</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('matapelajaran.edit') ? '' : 'collapsed' }}" href="{{ route('matapelajaran.edit', ['id' => $matapelajaran->id ?? 0]) }}">
                <i class="bi bi-circle"></i>
                <span>Edit Mata Pelajaran</span>
            </a>
        </li>
        @endif

        <!-- Daftar Kelas -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('kelas.daftar') ? '' : 'collapsed' }}" href="{{ route('kelas.daftar') }}">
                <i class="bi bi-layout-text-window-reverse"></i>
                <span>Daftar Kelas</span>
            </a>
        </li>
        @if(request()->routeIs('kelas.tambah') || request()->routeIs('kelas.edit'))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('kelas.tambah') ? '' : 'collapsed' }}" href="{{ route('kelas.tambah') }}">
                <i class="bi bi-circle"></i>
                <span>Tambah Kelas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('kelas.edit') ? '' : 'collapsed' }}" href="{{ route('kelas.edit', ['id' => $kelas->id ?? 0]) }}">
                <i class="bi bi-circle"></i>
                <span>Edit Kelas</span>
            </a>
        </li>
        @endif

        <!-- Daftar Ruangan -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('ruangan.daftar') ? '' : 'collapsed' }}" href="{{ route('ruangan.daftar') }}">
                <i class="bi bi-house"></i>
                <span>Daftar Ruangan</span>
            </a>
        </li>
        @if(request()->routeIs('ruangan.tambah') || request()->routeIs('ruangan.edit'))
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('ruangan.tambah') ? '' : 'collapsed' }}" href="{{ route('ruangan.tambah') }}">
                <i class="bi bi-circle"></i>
                <span>Tambah Ruangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('ruangan.edit') ? '' : 'collapsed' }}" href="{{ route('ruangan.edit', ['id' => $ruangan->id ?? 0]) }}">
                <i class="bi bi-circle"></i>
                <span>Edit Ruangan</span>
            </a>
        </li>
        @endif

        <!-- Daftar Kelas Tersedia -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('kelastersedia.daftar') ? '' : 'collapsed' }}" href="{{ route('kelastersedia.daftar') }}">
                <i class="bi bi-list"></i>
                <span>Daftar Kelas Tersedia</span>
            </a>
        </li>

        <!-- Daftar Jadwal -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('jadwal.daftar') ? '' : 'collapsed' }}" href="{{ route('jadwal.daftar') }}">
                <i class="bi bi-clock"></i>
                <span>Daftar Jadwal</span>
            </a>
        </li>
    </ul>
</aside><!-- End Sidebar -->



  @yield('content')
  @yield('style')
  @yield('scripts')
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>