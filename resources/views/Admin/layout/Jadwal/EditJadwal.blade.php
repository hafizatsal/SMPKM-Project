<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Edit Jadwal</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Edit Jadwal</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Jadwal</h5>

            <!-- Form to edit existing schedule -->
            <form>
              <!-- Dropdown for Tahun Ajaran -->
              <div class="mb-3">
                <label for="tahun-ajaran-edit" class="form-label">Tahun Ajaran</label>
                <select class="form-select" id="tahun-ajaran-edit" name="tahun_ajaran_edit">
                  <option value="2023/2024">2023/2024</option>
                  <option value="2022/2023">2022/2023</option>
                  <option value="2021/2022">2021/2022</option>
                  <!-- Add more years as needed -->
                </select>
              </div>

              <!-- Tabs for Classes and Departments -->
              <ul class="nav nav-tabs" id="editTab" role="tablist">
                <!-- Kelas 10 -->
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="edit-kelas-10-tab" data-bs-toggle="tab" data-bs-target="#edit-kelas-10" type="button" role="tab" aria-controls="edit-kelas-10" aria-selected="true">Kelas 10</button>
                </li>
                <!-- Kelas 11 -->
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="edit-kelas-11-tab" data-bs-toggle="tab" data-bs-target="#edit-kelas-11" type="button" role="tab" aria-controls="edit-kelas-11" aria-selected="false">Kelas 11</button>
                </li>
                <!-- Kelas 12 -->
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="edit-kelas-12-tab" data-bs-toggle="tab" data-bs-target="#edit-kelas-12" type="button" role="tab" aria-controls="edit-kelas-12" aria-selected="false">Kelas 12</button>
                </li>
              </ul>
              <div class="tab-content" id="editTabContent">
                <!-- Kelas 10 Content -->
                <div class="tab-pane fade show active" id="edit-kelas-10" role="tabpanel" aria-labelledby="edit-kelas-10-tab">
                  <!-- IPA, IPS, Bahasa Tabs -->
                  <ul class="nav nav-pills" id="edit-pills-tab-10" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="edit-ipa-10-tab" data-bs-toggle="pill" data-bs-target="#edit-ipa-10" type="button" role="tab" aria-controls="edit-ipa-10" aria-selected="true">IPA</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="edit-ips-10-tab" data-bs-toggle="pill" data-bs-target="#edit-ips-10" type="button" role="tab" aria-controls="edit-ips-10" aria-selected="false">IPS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="edit-bahasa-10-tab" data-bs-toggle="pill" data-bs-target="#edit-bahasa-10" type="button" role="tab" aria-controls="edit-bahasa-10" aria-selected="false">Bahasa</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="edit-pills-tabContent-10">
                    <!-- IPA Content -->
                    <div class="tab-pane fade show active" id="edit-ipa-10" role="tabpanel" aria-labelledby="edit-ipa-10-tab">
                      <h6>IPA Kelas 10</h6>
                      <div class="mb-3">
                        <label for="edit-mapel-ipa-10" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="edit-mapel-ipa-10" name="mapel_ipa_10" value="Matematika, Fisika" placeholder="Nama Mata Pelajaran">
                      </div>
                      <div class="mb-3">
                        <label for="edit-guru-ipa-10" class="form-label">Guru</label>
                        <input type="text" class="form-control" id="edit-guru-ipa-10" name="guru_ipa_10" value="Budi" placeholder="Nama Guru">
                      </div>
                    </div>
                    <!-- IPS Content -->
                    <div class="tab-pane fade" id="edit-ips-10" role="tabpanel" aria-labelledby="edit-ips-10-tab">
                      <h6>IPS Kelas 10</h6>
                      <div class="mb-3">
                        <label for="edit-mapel-ips-10" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="edit-mapel-ips-10" name="mapel_ips_10" value="Sejarah, Ekonomi" placeholder="Nama Mata Pelajaran">
                      </div>
                      <div class="mb-3">
                        <label for="edit-guru-ips-10" class="form-label">Guru</label>
                        <input type="text" class="form-control" id="edit-guru-ips-10" name="guru_ips_10" value="Siti" placeholder="Nama Guru">
                      </div>
                    </div>
                    <!-- Bahasa Content -->
                    <div class="tab-pane fade" id="edit-bahasa-10" role="tabpanel" aria-labelledby="edit-bahasa-10-tab">
                      <h6>Bahasa Kelas 10</h6>
                      <div class="mb-3">
                        <label for="edit-mapel-bahasa-10" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="edit-mapel-bahasa-10" name="mapel_bahasa_10" value="Bahasa Indonesia, Bahasa Inggris" placeholder="Nama Mata Pelajaran">
                      </div>
                      <div class="mb-3">
                        <label for="edit-guru-bahasa-10" class="form-label">Guru</label>
                        <input type="text" class="form-control" id="edit-guru-bahasa-10" name="guru_bahasa_10" value="Ayu" placeholder="Nama Guru">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Kelas 11 Content -->
                <div class="tab-pane fade" id="edit-kelas-11" role="tabpanel" aria-labelledby="edit-kelas-11-tab">
                  <!-- IPA, IPS, Bahasa Tabs -->
                  <ul class="nav nav-pills" id="edit-pills-tab-11" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="edit-ipa-11-tab" data-bs-toggle="pill" data-bs-target="#edit-ipa-11" type="button" role="tab" aria-controls="edit-ipa-11" aria-selected="true">IPA</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="edit-ips-11-tab" data-bs-toggle="pill" data-bs-target="#edit-ips-11" type="button" role="tab" aria-controls="edit-ips-11" aria-selected="false">IPS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="edit-bahasa-11-tab" data-bs-toggle="pill" data-bs-target="#edit-bahasa-11" type="button" role="tab" aria-controls="edit-bahasa-11" aria-selected="false">Bahasa</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="edit-pills-tabContent-11">
                    <!-- IPA Content -->
                    <div class="tab-pane fade show active" id="edit-ipa-11" role="tabpanel" aria-labelledby="edit-ipa-11-tab">
                      <h6>IPA Kelas 11</h6>
                      <div class="mb-3">
                        <label for="edit-mapel-ipa-11" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="edit-mapel-ipa-11" name="mapel_ipa_11" value="Biologi, Kimia" placeholder="Nama Mata Pelajaran">
                      </div>
                      <div class="mb-3">
                        <label for="edit-guru-ipa-11" class="form-label">Guru</label>
                        <input type="text" class="form-control" id="edit-guru-ipa-11" name="guru_ipa_11" value="Rudi" placeholder="Nama Guru">
                      </div>
                    </div>
                    <!-- IPS Content -->
                    <div class="tab-pane fade" id="edit-ips-11" role="tabpanel" aria-labelledby="edit-ips-11-tab">
                      <h6>IPS Kelas 11</h6>
                      <div class="mb-3">
                        <label for="edit-mapel-ips-11" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="edit-mapel-ips-11" name="mapel_ips_11" value="Geografi, Sosiologi" placeholder="Nama Mata Pelajaran">
                      </div>
                      <div class="mb-3">
                        <label for="edit-guru-ips-11" class="form-label">Guru</label>
                        <input type="text" class="form-control" id="edit-guru-ips-11" name="guru_ips_11" value="Dewi" placeholder="Nama Guru">
                      </div>
                    </div>
                    <!-- Bahasa Content -->
                    <div class="tab-pane fade" id="edit-bahasa-11" role="tabpanel" aria-labelledby="edit-bahasa-11-tab">
                      <h6>Bahasa Kelas 11</h6>
                      <div class="mb-3">
                        <label for="edit-mapel-bahasa-11" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="edit-mapel-bahasa-11" name="mapel_bahasa_11" value="Bahasa Jerman, Bahasa Perancis" placeholder="Nama Mata Pelajaran">
                      </div>
                      <div class="mb-3">
                        <label for="edit-guru-bahasa-11" class="form-label">Guru</label>
                        <input type="text" class="form-control" id="edit-guru-bahasa-11" name="guru_bahasa_11" value="Lina" placeholder="Nama Guru">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Kelas 12 Content -->
                <div class="tab-pane fade" id="edit-kelas-12" role="tabpanel" aria-labelledby="edit-kelas-12-tab">
                  <!-- IPA, IPS, Bahasa Tabs -->
                  <ul class="nav nav-pills" id="edit-pills-tab-12" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="edit-ipa-12-tab" data-bs-toggle="pill" data-bs-target="#edit-ipa-12" type="button" role="tab" aria-controls="edit-ipa-12" aria-selected="true">IPA</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="edit-ips-12-tab" data-bs-toggle="pill" data-bs-target="#edit-ips-12" type="button" role="tab" aria-controls="edit-ips-12" aria-selected="false">IPS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="edit-bahasa-12-tab" data-bs-toggle="pill" data-bs-target="#edit-bahasa-12" type="button" role="tab" aria-controls="edit-bahasa-12" aria-selected="false">Bahasa</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="edit-pills-tabContent-12">
                    <!-- IPA Content -->
                    <div class="tab-pane fade show active" id="edit-ipa-12" role="tabpanel" aria-labelledby="edit-ipa-12-tab">
                      <h6>IPA Kelas 12</h6>
                      <div class="mb-3">
                        <label for="edit-mapel-ipa-12" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="edit-mapel-ipa-12" name="mapel_ipa_12" value="Astronomi, Biologi" placeholder="Nama Mata Pelajaran">
                      </div>
                      <div class="mb-3">
                        <label for="edit-guru-ipa-12" class="form-label">Guru</label>
                        <input type="text" class="form-control" id="edit-guru-ipa-12" name="guru_ipa_12" value="Maya" placeholder="Nama Guru">
                      </div>
                    </div>
                    <!-- IPS Content -->
                    <div class="tab-pane fade" id="edit-ips-12" role="tabpanel" aria-labelledby="edit-ips-12-tab">
                      <h6>IPS Kelas 12</h6>
                      <div class="mb-3">
                        <label for="edit-mapel-ips-12" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="edit-mapel-ips-12" name="mapel_ips_12" value="Politik, Ekonomi" placeholder="Nama Mata Pelajaran">
                      </div>
                      <div class="mb-3">
                        <label for="edit-guru-ips-12" class="form-label">Guru</label>
                        <input type="text" class="form-control" id="edit-guru-ips-12" name="guru_ips_12" value="Rina" placeholder="Nama Guru">
                      </div>
                    </div>
                    <!-- Bahasa Content -->
                    <div class="tab-pane fade" id="edit-bahasa-12" role="tabpanel" aria-labelledby="edit-bahasa-12-tab">
                      <h6>Bahasa Kelas 12</h6>
                      <div class="mb-3">
                        <label for="edit-mapel-bahasa-12" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="edit-mapel-bahasa-12" name="mapel_bahasa_12" value="Bahasa Mandarin, Bahasa Jepang" placeholder="Nama Mata Pelajaran">
                      </div>
                      <div class="mb-3">
                        <label for="edit-guru-bahasa-12" class="form-label">Guru</label>
                        <input type="text" class="form-control" id="edit-guru-bahasa-12" name="guru_bahasa_12" value="Nina" placeholder="Nama Guru">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="d-grid gap-2 mt-3">
                <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
              </div>

            </form><!-- End Form -->

          </div>
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>