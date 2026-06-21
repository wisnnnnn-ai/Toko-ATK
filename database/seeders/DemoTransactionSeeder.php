<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DemoTransactionSeeder extends Seeder
{


    public function run(): void
    {

        $barangCount = DB::table('barang')->count();
        $userCount = DB::table('users')->count();

        if ($barangCount == 0 || $userCount == 0) {
            $this->command->error('Please run db:seed first to create barang and users');
            return;
        }


        $barangIds = DB::table('barang')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();


        DB::table('transaksi')->where('kode_transaksi', 'like', 'DEMO%')->delete();
        DB::table('detail_transaksi')->whereIn('transaksi_id', function($query) {
            $query->select('id')->from('transaksi')->where('kode_transaksi', 'like', 'DEMO%');
        })->delete();


        $this->generateMonthTransactions(2026, 4, $barangIds, $userIds, 15);


        $this->generateMonthTransactions(2026, 5, $barangIds, $userIds, 20);

        $this->command->info('Demo transactions for Mei and Juni 2026 created successfully!');
    }


    private function generateMonthTransactions($year, $month, $barangIds, $userIds, $count)
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for ($i = 0; $i < $count; $i++) {

            $day = rand(1, $daysInMonth);

            $tanggal = Carbon::create($year, $month, $day);


            $kodeTransaksi = 'DEMO' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));


            $transaksiId = DB::table('transaksi')->insertGetId([
                'kode_transaksi' => $kodeTransaksi,
                'tanggal' => $tanggal->toDateString(),
                'user_id' => $userIds[array_rand($userIds)],
                'total' => 0,
                'created_at' => $tanggal,
                'updated_at' => $tanggal,
            ]);


            $itemCount = rand(1, 5);
            $total = 0;

            for ($j = 0; $j < $itemCount; $j++) {
                $barangId = $barangIds[array_rand($barangIds)];
                $barang = DB::table('barang')->where('id', $barangId)->first();

                $qty = rand(1, 5);
                $harga = $barang->harga;
                $subtotal = $harga * $qty;

                $total += $subtotal;

                DB::table('detail_transaksi')->insert([
                    'transaksi_id' => $transaksiId,
                    'barang_id' => $barangId,
                    'harga' => $harga,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                    'created_at' => $tanggal,
                    'updated_at' => $tanggal,
                ]);
            }


            DB::table('transaksi')->where('id', $transaksiId)->update([
                'total' => $total,
            ]);
        }
    }
}
