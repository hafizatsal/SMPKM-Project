<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Home
    public function home()
    {
        return view('admin.home');
    }

    /*// Jadwal
     public function lihatJadwal()
    {
        return view('Admin.layout.JadwalPelajaran.LihatJadwal');
    }

    public function tambahJadwal(Request $request)
    {
        return view('Admin.layout.JadwalPelajaran.TambahJadwal');
    }

    public function editjadwal()
    {
        // Logika untuk melihat jadwal mengajar
        return view('Admin.layout.JadwalPelajaran.EditJadwal');
    }

    // Guru
    public function daftarguru()
    {
        // Logika untuk melihat jadwal pelajaran siswa
        return view('Admin.layout.DataGuru.DaftarGuru');
    }

    public function editguru()
    {
        // Logika untuk melihat jadwal pelajaran siswa
        return view('Admin.layout.DataGuru.EditGuru');
    }

    public function jadwalguru()
    {
        // Logika untuk melihat jadwal pelajaran siswa
        return view('Admin.layout.DataGuru.JadwalGuru');
    }

    public function tambahguru()
    {
        // Logika untuk melihat jadwal pelajaran siswa
        return view('Admin.layout.DataGuru.tambahGuru');
    }

    // Ruang Kelas
    public function daftarkelas()
    {
        // Logika untuk melihat jadwal pelajaran siswa
        return view('Admin.layout.RuangKelas.DaftarKelas');
    }

    public function editkelas()
    {
        // Logika untuk melihat jadwal pelajaran siswa
        return view('Admin.layout.RuangKelas.EditKelas');
    }

    public function tambahkelas()
    {
        // Logika untuk melihat jadwal pelajaran siswa
        return view('Admin.layout.RuangKelas.TambahKelas');
    }
    public function jadwalkelas()
    {
        // Logika untuk melihat jadwal pelajaran siswa
        return view('Admin.layout.RuangKelas.JadwalKelas');
    } */

}