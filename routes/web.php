<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\GuruMataPelajaranController;
use App\Http\Controllers\KelasTersediaController;

// Home
Route::get('/', [AdminController::class, 'home'])->name('home');

// Data Guru
Route::get('/guru/daftar', [GuruController::class, 'daftarGuru'])->name('guru.daftar');
Route::get('/guru/tambah', [GuruController::class, 'tambahGuru'])->name('guru.tambah');
Route::post('/guru/simpan', [GuruController::class, 'simpanGuru'])->name('guru.simpan');
Route::get('/guru/jadwal', [GuruController::class, 'jadwalGuru'])->name('guru.jadwal');
Route::get('guru/edit/{id}', [GuruController::class, 'editGuru'])->name('guru.edit');
Route::put('guru/update/{id}', [GuruController::class, 'updateGuru'])->name('guru.update');
Route::delete('/guru/hapus/{id}', [GuruController::class, 'hapusGuru'])->name('guru.hapus');

// Jadwal
Route::get('/jadwal/daftar', [JadwalController::class, 'daftarJadwal'])->name('jadwal.daftar');
Route::get('/jadwal/tambah', [JadwalController::class, 'tambahJadwal'])->name('jadwal.tambah');
Route::post('/jadwal/simpan', [JadwalController::class, 'simpanJadwal'])->name('jadwal.simpan');
Route::get('jadwal/edit/{id}', [JadwalController::class, 'edit'])->name('jadwal.edit');
Route::put('/jadwal/update/{id}', [JadwalController::class, 'updateJadwal'])->name('jadwal.update');
Route::delete('/jadwal/hapus/{id}', [JadwalController::class, 'hapusJadwal'])->name('jadwal.hapus');
Route::get('/api/kelas/{tahunAjaranId}/{tingkat}', [KelasController::class, 'getKelasByTingkat']);


// Kelas
Route::get('/kelas/daftar', [KelasController::class, 'daftarKelas'])->name('kelas.daftar');
Route::get('/kelas/tambah', [KelasController::class, 'tambahKelas'])->name('kelas.tambah');
Route::post('/kelas/simpan', [KelasController::class, 'simpanKelas'])->name('kelas.simpan');
Route::get('/kelas/edit/{id}', [KelasController::class, 'editKelas'])->name('kelas.edit');
Route::put('/kelas/update/{id}', [KelasController::class, 'updateKelas'])->name('kelas.update');
Route::delete('/kelas/hapus/{id}', [KelasController::class, 'hapusKelas'])->name('kelas.hapus');

// Ruangan
Route::get('/Ruangan/daftar', [RuanganController::class, 'daftarRuangan'])->name('ruangan.daftar');
Route::get('/Ruangan/tambah', [RuanganController::class, 'tambahRuangan'])->name('ruangan.tambah');
Route::post('/Ruangan/simpan', [RuanganController::class, 'simpanRuangan'])->name('ruangan.simpan');
Route::get('/Ruangan/edit/{id}', [RuanganController::class, 'editRuangan'])->name('ruangan.edit');
Route::put('/Ruangan/update/{id}', [RuanganController::class, 'updateRuangan'])->name('ruangan.update');
Route::delete('/Ruangan/hapus/{id}', [RuanganController::class, 'hapusRuangan'])->name('ruangan.hapus');

// Kelas Tersedia
Route::get('/kelastersedia/daftar', [KelasTersediaController::class, 'daftarKelasTersedia'])->name('kelastersedia.daftar');
Route::get('/kelastersedia/tambah', [KelasTersediaController::class, 'tambahKelasTersedia'])->name('kelastersedia.tambah');
Route::post('/kelastersedia/simpan', [KelasTersediaController::class, 'simpanKelasTersedia'])->name('kelastersedia.simpan');
Route::get('/kelastersedia/edit/{id}', [KelasTersediaController::class, 'editKelasTersedia'])->name('kelastersedia.edit');
Route::put('/kelastersedia/update/{id}', [KelasTersediaController::class, 'updateKelasTersedia'])->name('kelastersedia.update');
Route::delete('/kelastersedia/hapus/{id}', [KelasTersediaController::class, 'hapusKelasTersedia'])->name('kelastersedia.hapus');


// Tahun Ajaran
Route::get('/tahunajaran/daftar', [TahunAjaranController::class, 'daftarTahunAjaran'])->name('tahunajaran.daftar');
Route::post('/tahunajaran/simpan', [TahunAjaranController::class, 'simpanTahunAjaran'])->name('tahunajaran.simpan');
Route::delete('/tahunajaran/hapus/{id}', [TahunAjaranController::class, 'hapusTahunAjaran'])->name('tahunajaran.hapus');

// Mata Pelajaran
Route::get('/matapelajaran/daftar', [MataPelajaranController::class, 'daftarMataPelajaran'])->name('matapelajaran.daftar');
Route::get('/matapelajaran/tambah', [MataPelajaranController::class, 'tambahMataPelajaran'])->name('matapelajaran.tambah');
Route::get('/matapelajaran/edit/{id}', [MataPelajaranController::class, 'editMataPelajaran'])->name('matapelajaran.edit');
Route::put('/matapelajaran/update/{id}', [MataPelajaranController::class, 'updateMataPelajaran'])->name('matapelajaran.update');
Route::post('/matapelajaran/simpan', [MataPelajaranController::class, 'simpanMataPelajaran'])->name('matapelajaran.simpan');
Route::delete('/matapelajaran/hapus/{id}', [MataPelajaranController::class, 'hapusMataPelajaran'])->name('matapelajaran.hapus');