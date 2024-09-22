<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminProfileController extends Controller
{
    // Menampilkan profil admin
    public function adminProfile()
{
    // Ambil data pengguna yang sedang login
    $user = Auth::user();

    // Ambil jumlah semua pengguna
    $totalUsers = User::count();

    // Kirimkan $totalUsers ke view
    return view('Admin.layout.profile.AdminProfile', compact('user', 'totalUsers'));
}


    // Menampilkan halaman edit profil
    public function editProfile()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        return view('Admin.layout.profile.EditProfile', compact('user'));
    }

    public function tambahProfile()
{
    // Ambil data pengguna yang sedang login
    $user = Auth::user();

    // Ambil pengguna dengan ID paling kecil
    $oldestUser = User::orderBy('id')->first();

    // Cek apakah pengguna yang sedang login adalah pengguna dengan ID paling kecil
    if ($user->id !== $oldestUser->id) {
        return redirect()->route('admin.profile')->with('error', 'Hanya pengguna dengan ID paling lama yang dapat menambah admin.');
    }

    // Menampilkan view untuk form tambah admin
    return view('admin.layout.profile.TambahProfile', compact('user'));
}

public function listUsers()
{
    // Ambil semua pengguna, termasuk password
    $users = User::all();

    return view('Admin.layout.profile.DaftarAdmin', compact('users'));
}

public function editUser($id)
{
    // Cari pengguna berdasarkan ID
    $user = User::findOrFail($id);

    // Tampilkan view untuk mengubah password, dan kirimkan data pengguna
    return view('Admin.layout.profile.UbahPassword', compact('user'));
}

public function updateUser(Request $request, $id)
{
    $request->validate([
        'password' => 'required|min:8|confirmed',
    ]);

    // Cari pengguna berdasarkan ID
    $user = User::findOrFail($id);
    
    // Ubah password pengguna
    $user->password = Hash::make($request->input('password'));
    $user->save();

    return redirect()->route('admin.users')->with('success', 'Password berhasil diubah.');
}


public function deleteUser($id)
{
    // Temukan pengguna berdasarkan ID
    $user = User::findOrFail($id);
    
    // Hapus pengguna
    $user->delete();

    return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
}

    public function simpanProfile(Request $request)
    {
        //dd($request->all());
        // Validasi input form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat admin baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Redirect atau response setelah berhasil menambah admin
        return redirect()->route('admin.profile')->with('success', 'Admin berhasil ditambahkan.');
    }


    // Metode untuk mengupdate profil admin
    public function updateProfile(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed', // Tambahkan validasi untuk password
        ]);

        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Update data pengguna
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Cek apakah ada password baru
        if ($request->filled('password')) {
            // Hash password baru sebelum menyimpannya
            $user->password = bcrypt($request->input('password'));
        }

        $user->save(); // Simpan perubahan

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
