<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
     public function index(Request $request)
     {
         $totalBarang = Barang::count();
         $totalStok = Barang::sum('stok');
         $totalTransaksi = Transaksi::count();
         $totalPendapatan = Transaksi::sum('total');


         $stokMenipisCount = Barang::where('stok', '<=', 10)->count();
         $transaksiHariIni = Transaksi::whereDate('tanggal', now()->format('Y-m-d'))->count();
         $pendapatanHariIni = Transaksi::whereDate('tanggal', now()->format('Y-m-d'))->sum('total');


        $topProduk = Barang::leftJoin('detail_transaksi', 'barang.id', '=', 'detail_transaksi.barang_id')
            ->select(
                'barang.nama_barang',
                DB::raw('COALESCE(SUM(detail_transaksi.qty), 0) as total_terjual')
            )
            ->groupBy('barang.id', 'barang.nama_barang')
            ->orderByDesc('total_terjual')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_barang' => $item->nama_barang,
                    'total_terjual' => $item->total_terjual
                ];
            });


         $period = $request->get('period', 'hari');
         $startDate = $this->getStartDate($period);
         $endDate = now();

         $chartData = $this->getChartData($period, $startDate, $endDate);
         $chartLabels = $this->getChartLabels($period, $startDate, $endDate);

         return view('dashboard', compact(
             'totalBarang',
             'totalStok',
             'totalTransaksi',
             'totalPendapatan',
             'stokMenipisCount',
             'transaksiHariIni',
             'pendapatanHariIni',
             'topProduk',
             'chartData',
             'chartLabels',
             'period'
         ));
     }

      public function getChartDataAjax(Request $request)
      {
          $period = $request->get('period', 'hari');
          $startDate = $this->getStartDate($period);
          $endDate = now();

          $data = [
              'labels' => $this->getChartLabels($period, $startDate, $endDate),
              'values' => $this->getChartData($period, $startDate, $endDate)
          ];

          return response()->json($data);
      }

      public function produkTerlaris()
      {

          $produkTerlaris = DetailTransaksi::select(
              'barang_id',
              DB::raw('SUM(qty) as total_terjual')
          )
              ->groupBy('barang_id')
              ->orderByDesc('total_terjual')
              ->get()
              ->map(function ($item) {
                  $barang = Barang::find($item->barang_id);
                  return [
                      'nama_barang' => $barang ? $barang->nama_barang : 'Unknown',
                      'total_terjual' => $item->total_terjual,
                      'kode_barang' => $barang ? $barang->kode_barang : '-'
                  ];
              });

          return view('transaksi.produk_terlaris', compact('produkTerlaris'));
      }

    private function getStartDate($period)
    {
        switch ($period) {
            case 'hari':
                return now()->startOfDay();
            case 'minggu':
                return now()->subDays(7)->startOfDay();
            case 'bulan':
                return now()->subDays(30)->startOfDay();
            default:
                return now()->subDays(7)->startOfDay();
        }
    }

    private function getChartLabels($period, $startDate, $endDate)
    {
        $labels = [];
        $current = Carbon::parse($startDate);

        while ($current->lessThanOrEqualTo($endDate)) {
            if ($period === 'hari') {
                $labels[] = $current->format('H:00');
                $current->addHour();
            } else {
                $labels[] = $current->format('d M');
                $current->addDay();
            }
        }

        return $labels;
    }

     private function getChartData($period, $startDate, $endDate)
     {
         if ($period === 'hari') {

             $query = Transaksi::select(
                 DB::raw('HOUR(tanggal) as hour'),
                 DB::raw('SUM(total) as total')
             )
                 ->whereBetween('tanggal', [$startDate, $endDate])
                 ->groupBy(DB::raw('HOUR(tanggal)'))
                 ->orderBy('hour')
                 ->get();

             $dataMap = [];
             foreach ($query as $row) {
                 $dataMap[(int) $row->hour] = (float) $row->total;
             }

             $data = [];
             $current = Carbon::parse($startDate);
             while ($current->lessThanOrEqualTo($endDate)) {
                 $hour = (int) $current->format('G');
                 $data[] = $dataMap[$hour] ?? 0.0;
                 $current->addHour();
             }

             return $data;
         } else {

             $query = Transaksi::select(
                 DB::raw('DATE(tanggal) as date'),
                 DB::raw('SUM(total) as total')
             )
                 ->whereBetween('tanggal', [$startDate, $endDate])
                 ->groupBy(DB::raw('DATE(tanggal)'))
                 ->orderBy('date')
                 ->get();

             $dataMap = [];
             foreach ($query as $row) {
                 $dataMap[$row->date] = (float) $row->total;
             }

             $data = [];
             $current = Carbon::parse($startDate)->startOfDay();
             while ($current->lessThanOrEqualTo($endDate)) {
                 $dateKey = $current->format('Y-m-d');
                 $data[] = $dataMap[$dateKey] ?? 0.0;
                 $current->addDay();
             }

             return $data;
         }
     }
}
