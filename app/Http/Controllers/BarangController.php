<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->orderBy('id', 'desc')->get();
        $kategoris = Kategori::all();
        $logs = ActivityLog::whereIn('aksi', ['Tambah Barang', 'Ubah Harga', 'Hapus Barang'])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        return view('barang.index', compact('barangs', 'kategoris', 'logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori_id' => 'required|exists:kategori,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $lastBarang = Barang::orderBy('id', 'desc')->first();
        $nextNumber = $lastBarang ? (int)substr($lastBarang->kode_barang, -3) + 1 : 1;
        $kode_barang = 'BRG' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $barang = Barang::create([
            'kode_barang' => $kode_barang,
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'harga' => $request->harga,
            'harga_modal' => $request->harga_modal ?? 0,
            'stok' => $request->stok,
            'satuan' => $request->satuan ?? 'pcs',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Tambah Barang',
            'detail' => 'Menambahkan barang: ' . $request->nama_barang . ' (Stok: ' . $request->stok . ')',
        ]);

        return response()->json(['message' => 'Barang berhasil ditambahkan']);
    }

    public function getNextKode()
    {
        $lastBarang = Barang::orderBy('id', 'desc')->first();
        $nextNumber = $lastBarang ? (int)substr($lastBarang->kode_barang, -3) + 1 : 1;
        $kode_barang = 'BRG' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $lastKategori = Kategori::orderBy('id', 'desc')->first();
        $nextKategoriNumber = $lastKategori ? (int)substr($lastKategori->kode_kategori, -3) + 1 : 1;

        if ($nextKategoriNumber < 6) {
            $nextKategoriNumber = 6;
        }
        $kode_kategori = 'KTG' . str_pad($nextKategoriNumber, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'kode_barang' => $kode_barang,
            'kode_kategori' => $kode_kategori,
        ]);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'harga' => 'required|numeric|min:0',
        ]);

        $oldHarga = $barang->harga;
        $oldHargaModal = $barang->harga_modal;

        $barang->update([
            'harga' => $request->harga,
            'harga_modal' => $request->harga_modal ?? $barang->harga_modal,
        ]);

        $changes = [];
        if ($oldHarga != $barang->harga) {
            $changes[] = 'Harga Jual: Rp ' . number_format($oldHarga, 0, ',', '.') . ' → Rp ' . number_format($barang->harga, 0, ',', '.');
        }
        if ($oldHargaModal != $barang->harga_modal) {
            $changes[] = 'Harga Modal: Rp ' . number_format($oldHargaModal, 0, ',', '.') . ' → Rp ' . number_format($barang->harga_modal, 0, ',', '.');
        }

        if (!empty($changes)) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'aksi' => 'Ubah Harga',
                'detail' => $barang->nama_barang . ': ' . implode(', ', $changes),
            ]);
        }

        return response()->json(['message' => 'Harga berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $namaBarang = $barang->nama_barang;
        $barang->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Hapus Barang',
            'detail' => 'Menghapus barang: ' . $namaBarang,
        ]);

        return response()->json(['message' => 'Barang berhasil dihapus']);
    }

    public function getBarang()
    {
        $barangs = Barang::with('kategori')->get();
        return response()->json($barangs);
    }

    public function show($id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);
        return view('barang.detail', compact('barang'));
    }

    public function getStokRendah()
    {
        $barangs = Barang::with('kategori')->orderBy('stok', 'asc')->get();
        $kategoris = Kategori::all();
        return view('barang.stok', compact('barangs', 'kategoris'));
    }

    public function restock(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $barang->increment('stok', $request->jumlah);

        if ($request->harga_modal) {
            $barang->harga_modal = $request->harga_modal;
        }
        if ($request->harga) {
            $barang->harga = $request->harga;
        }
        $barang->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Tambah Stok',
            'detail' => 'Menambahkan stok ' . $barang->nama_barang . ' +' . $request->jumlah,
        ]);

        return response()->json(['message' => 'Stok berhasil ditambahkan']);
    }
}
