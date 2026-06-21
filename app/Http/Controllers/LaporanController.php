<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('user');


        $bulan = $request->bulan ?: date('n');
        $tahun = $request->tahun ?: date('Y');


        $query->whereMonth('tanggal', $bulan)
              ->whereYear('tanggal', $tahun);

        $transaksis = $query->orderBy('tanggal', 'desc')->get();
        $barangs = Barang::orderBy('stok', 'asc')->get();
        $activityLogs = ActivityLog::whereIn('aksi', ['Tambah Barang', 'Ubah Harga', 'Hapus Barang', 'Tambah Stok', 'Tambah Kategori', 'Hapus Kategori', 'Ubah Kategori'])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

        return view('laporan.index', compact('transaksis', 'barangs', 'activityLogs'));
    }

    public function laporanPenjualan(Request $request)
    {
        $query = Transaksi::with('user');

        if ($request->bulan && $request->tahun) {
            $query->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun);
        } elseif ($request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $transaksis = $query->orderBy('tanggal', 'desc')->get();
        $totalPendapatan = $transaksis->sum('total');

        return response()->json([
            'transaksis' => $transaksis,
            'totalPendapatan' => $totalPendapatan,
        ]);
    }

    public function laporanStok(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->stok_rendah == 'true') {
            $query->where('stok', '<', 10);
        }

        $barangs = $query->orderBy('stok', 'asc')->get();
        $totalStok = $barangs->sum('stok');

        return response()->json([
            'barangs' => $barangs,
            'totalStok' => $totalStok,
        ]);
    }

    public function grafikPenjualan(Request $request)
    {
        $query = Transaksi::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('SUM(total) as total')
        );

        if ($request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $data = $query->groupBy('bulan')->orderBy('bulan')->get();

        $chartData = array_fill(0, 12, 0);
        foreach ($data as $item) {
            $chartData[(int) $item->bulan - 1] = (float) $item->total;
        }

        return response()->json($chartData);
    }
}
