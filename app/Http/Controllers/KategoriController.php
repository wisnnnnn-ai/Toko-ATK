<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::with(['barang', 'barang.kategori'])->orderBy('id', 'desc')->get();
        return view('kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori',
        ]);

        $lastKategori = Kategori::orderBy('id', 'desc')->first();
        $nextNumber = $lastKategori ? (int)substr($lastKategori->kode_kategori, -3) + 1 : 1;

        if ($nextNumber < 6) {
            $nextNumber = 6;
        }
        $kode_kategori = 'KTG' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $kategori = Kategori::create([
            'kode_kategori' => $kode_kategori,
            'nama_kategori' => $request->nama_kategori,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Tambah Kategori',
            'detail' => 'Menambahkan kategori: ' . $request->nama_kategori,
        ]);

        return response()->json(['message' => 'Kategori berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori,' . $id,
        ]);

        $oldNama = $kategori->nama_kategori;
        $kategori->update($request->all());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Ubah Kategori',
            'detail' => 'Mengubah kategori: ' . $oldNama . ' → ' . $request->nama_kategori,
        ]);

        return response()->json(['message' => 'Kategori berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->barang()->count() > 0) {
            return response()->json(['message' => 'Tidak dapat menghapus kategori yang memiliki barang'], 422);
        }

        $nama = $kategori->nama_kategori;
        $kategori->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Hapus Kategori',
            'detail' => 'Menghapus kategori: ' . $nama,
        ]);

        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }

    public function show($id)
    {
        $kategori = Kategori::with('barang')->findOrFail($id);
        return view('kategori.detail', compact('kategori'));
    }

    public function getNextKode()
    {
        $lastKategori = Kategori::orderBy('id', 'desc')->first();
        $nextNumber = $lastKategori ? (int)substr($lastKategori->kode_kategori, -3) + 1 : 1;

        if ($nextNumber < 6) {
            $nextNumber = 6;
        }
        $kode_kategori = 'KTG' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return response()->json(['kode_kategori' => $kode_kategori]);
    }
}
