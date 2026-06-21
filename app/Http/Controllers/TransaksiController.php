<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $tanggal = request('tanggal');
        $barangs = Barang::where('stok', '>', 0)->with('kategori')->get();

        if ($tanggal) {
            $transaksis = Transaksi::with(['user', 'detailTransaksi'])
                ->whereDate('tanggal', $tanggal)
                ->orderBy('tanggal', 'desc')
                ->get();
        } else {
            $transaksis = Transaksi::with(['user', 'detailTransaksi'])
                ->orderBy('id', 'desc')
                ->limit(50)
                ->get();
        }

        return view('transaksi.index', compact('barangs', 'transaksis', 'tanggal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $kodeTransaksi = 'TRX-' . date('Ymd') . '-' . str_pad(Transaksi::count() + 1, 4, '0', STR_PAD_LEFT);
                $total = 0;

                $transaksi = Transaksi::create([
                    'kode_transaksi' => $kodeTransaksi,
                    'tanggal' => date('Y-m-d H:i:s'),
                    'total' => 0,
                    'user_id' => Auth::id(),
                ]);

                foreach ($request->items as $item) {
                    $barang = Barang::findOrFail($item['barang_id']);
                    $subtotal = $barang->harga * $item['qty'];
                    $total += $subtotal;

                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'barang_id' => $barang->id,
                        'qty' => $item['qty'],
                        'harga' => $barang->harga,
                        'subtotal' => $subtotal,
                    ]);

                    $barang->decrement('stok', $item['qty']);
                }

                $transaksi->update(['total' => $total]);

                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'aksi' => 'Transaksi',
                    'detail' => 'Transaksi ' . $kodeTransaksi . ' - Rp ' . number_format($total, 0, ',', '.'),
                ]);
            });

            return response()->json(['message' => 'Transaksi berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Transaksi gagal: ' . $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['user', 'detailTransaksi.barang'])->findOrFail($id);
        return view('transaksi.detail', compact('transaksi'));
    }

    public function getTransaksi()
    {
        $transaksis = Transaksi::with(['user', 'detailTransaksi'])->orderBy('id', 'desc')->get();
        return response()->json($transaksis);
    }

    public function destroyAll()
    {
        try {
            DB::transaction(function () {
                DetailTransaksi::truncate();
                Transaksi::truncate();
            });
            return response()->json(['message' => 'Semua transaksi berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus: ' . $e->getMessage()], 422);
        }
    }
}
