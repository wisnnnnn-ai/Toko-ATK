<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $logs = ActivityLog::whereIn('aksi', ['Tambah Akun', 'Hapus Akun', 'Ubah Nama', 'Ubah Email', 'Ubah Password', 'Ubah Profil'])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('akun.index', compact('users', 'logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'karyawan',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Tambah Akun',
            'detail' => 'Menambahkan akun karyawan: ' . $user->name,
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->has('name')) {
            $request->validate(['name' => 'required|string|max:255']);
            $user->update(['name' => $request->name]);
            ActivityLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'Ubah Nama',
                'detail' => 'Mengubah nama akun: ' . $user->name,
            ]);
        }

        if ($request->has('email')) {
            $request->validate(['email' => 'required|email|unique:users,email,' . $id]);
            $user->update(['email' => $request->email]);
            ActivityLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'Ubah Email',
                'detail' => 'Mengubah email akun: ' . $user->name,
            ]);
        }

        if ($request->has('password') && $request->password) {
            $request->validate(['password' => 'string|min:6']);
            $user->update(['password' => $request->password]);
            ActivityLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'Ubah Password',
                'detail' => 'Mengubah password akun: ' . $user->name,
            ]);
        }

        return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui');
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        if ($request->has('name')) {
            $request->validate(['name' => 'required|string|max:255']);
            $user->update(['name' => $request->name]);
            ActivityLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'Ubah Profil',
                'detail' => 'Mengubah nama profil',
            ]);
        }

        if ($request->has('email')) {
            $request->validate(['email' => 'required|email|unique:users,email,' . Auth::id()]);
            $user->update(['email' => $request->email]);
            ActivityLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'Ubah Email',
                'detail' => 'Mengubah email profil',
            ]);
        }

        if ($request->has('password') && $request->password) {
            $request->validate([
                'password' => 'string|min:6',
                'password_baru' => 'string|min:6',
            ]);
            if (!Hash::check($request->password, $user->password)) {
                return back()->with('error', 'Password lama salah');
            }
            $user->update(['password' => $request->password_baru]);
            ActivityLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'Ubah Password',
                'detail' => 'Mengubah password',
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $nama = $user->name;
        $user->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Hapus Akun',
            'detail' => 'Menghapus akun: ' . $nama,
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus');
    }
}
