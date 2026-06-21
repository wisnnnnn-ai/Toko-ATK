<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        \DB::table('users')->where('id', $admin->id)->update(['role' => 'admin']);

        $karyawan = User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        \DB::table('users')->where('id', $karyawan->id)->update(['role' => 'karyawan']);

        $kategoris = [
            ['nama_kategori' => 'Alat Tulis'],
            ['nama_kategori' => 'Kertas'],
            ['nama_kategori' => 'Buku'],
            ['nama_kategori' => 'Penghapus'],
            ['nama_kategori' => 'Pena'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        $barangs = [

            ['kode_barang' => 'PEN001', 'nama_barang' => 'Ballpoint Hitam', 'kategori_id' => 5, 'kode_kategori' => 'PEN', 'harga' => 2500, 'harga_modal' => 1500, 'stok' => 150, 'satuan' => 'pcs', 'deskripsi' => 'Ballpoint standard warna hitam, cocok untuk penggunaan sehari-hari'],
            ['kode_barang' => 'PEN002', 'nama_barang' => 'Ballpoint Biru', 'kategori_id' => 5, 'kode_kategori' => 'PEN', 'harga' => 2500, 'harga_modal' => 1500, 'stok' => 120, 'satuan' => 'pcs', 'deskripsi' => 'Ballpoint warna biru, tinta cepat kering'],
            ['kode_barang' => 'PEN003', 'nama_barang' => 'Ballpoint Merah', 'kategori_id' => 5, 'kode_kategori' => 'PEN', 'harga' => 2500, 'harga_modal' => 1500, 'stok' => 100, 'satuan' => 'pcs', 'deskripsi' => 'Ballpoint warna merah untuk revisi atau penting'],
            ['kode_barang' => 'PEN004', 'nama_barang' => 'Pulpen Gel 0.5mm', 'kategori_id' => 5, 'kode_kategori' => 'PEN', 'harga' => 4000, 'harga_modal' => 2500, 'stok' => 80, 'satuan' => 'pcs', 'deskripsi' => 'Pulpen gel dengan ujung halus 0.5mm, nyaman untuk menulis'],
            ['kode_barang' => 'PEN005', 'nama_barang' => 'Pulpen Gel 0.7mm', 'kategori_id' => 5, 'kode_kategori' => 'PEN', 'harga' => 4500, 'harga_modal' => 2800, 'stok' => 70, 'satuan' => 'pcs', 'deskripsi' => 'Pulpen gel dengan ujung 0.7mm, tinta tebal dan jernih'],
            ['kode_barang' => 'PEN006', 'nama_barang' => 'Spidol Permanent', 'kategori_id' => 5, 'kode_kategori' => 'PEN', 'harga' => 6000, 'harga_modal' => 3500, 'stok' => 45, 'satuan' => 'pcs', 'deskripsi' => 'Spidol permanen untuk berbagai permukaan'],
            ['kode_barang' => 'PEN007', 'nama_barang' => 'Spidol Whiteboard', 'kategori_id' => 5, 'kode_kategori' => 'PEN', 'harga' => 5500, 'harga_modal' => 3200, 'stok' => 55, 'satuan' => 'pcs', 'deskripsi' => 'Spidol khusus untuk papan tulis putih, mudah dihapus'],
            ['kode_barang' => 'PEN008', 'nama_barang' => 'Highlighter Kuning', 'kategori_id' => 5, 'kode_kategori' => 'PEN', 'harga' => 3500, 'harga_modal' => 2000, 'stok' => 90, 'satuan' => 'pcs', 'deskripsi' => 'Highlighter untuk menandai teks penting'],


            ['kode_barang' => 'ATK001', 'nama_barang' => 'Pensil 2B', 'kategori_id' => 1, 'kode_kategori' => 'ATK', 'harga' => 3000, 'harga_modal' => 1800, 'stok' => 100, 'satuan' => 'pcs', 'deskripsi' => 'Pensil standar 2B untuk menulis dan menggambar'],
            ['kode_barang' => 'ATK002', 'nama_barang' => 'Penggaris 30cm', 'kategori_id' => 1, 'kode_kategori' => 'ATK', 'harga' => 5000, 'harga_modal' => 3000, 'stok' => 30, 'satuan' => 'pcs', 'deskripsi' => 'Penggaris plastik transparan 30cm untuk mengukur'],
            ['kode_barang' => 'ATK003', 'nama_barang' => 'Penghapus Pensil', 'kategori_id' => 1, 'kode_kategori' => 'ATK', 'harga' => 1500, 'harga_modal' => 800, 'stok' => 50, 'satuan' => 'pcs', 'deskripsi' => 'Penghapus untuk pensil, mudah digunakan'],
            ['kode_barang' => 'ATK004', 'nama_barang' => 'Stapler Kecil', 'kategori_id' => 1, 'kode_kategori' => 'ATK', 'harga' => 15000, 'harga_modal' => 9000, 'stok' => 15, 'satuan' => 'pcs', 'deskripsi' => 'Stapler ukuran kecil untuk penempatan dokumen'],
            ['kode_barang' => 'ATK005', 'nama_barang' => 'Isi Stapler', 'kategori_id' => 1, 'kode_kategori' => 'ATK', 'harga' => 5000, 'harga_modal' => 2500, 'stok' => 20, 'satuan' => 'box', 'deskripsi' => 'Isi stapler standar per box berisi 1000 pcs'],
            ['kode_barang' => 'ATK006', 'nama_barang' => 'Pita Korektif', 'kategori_id' => 1, 'kode_kategori' => 'ATK', 'harga' => 8000, 'harga_modal' => 4500, 'stok' => 25, 'satuan' => 'pcs', 'deskripsi' => 'Pita tipis putih untuk koreksi kesalahan ketik'],
            ['kode_barang' => 'ATK007', 'nama_barang' => 'Double Tape', 'kategori_id' => 1, 'kode_kategori' => 'ATK', 'harga' => 4500, 'harga_modal' => 2500, 'stok' => 40, 'satuan' => 'roll', 'deskripsi' => 'Double tape / lakban bening dua sisi'],
            ['kode_barang' => 'ATK008', 'nama_barang' => 'Lakban Coklat', 'kategori_id' => 1, 'kode_kategori' => 'ATK', 'harga' => 6000, 'harga_modal' => 3500, 'stok' => 35, 'satuan' => 'roll', 'deskripsi' => 'Lakban coklat transparan untuk merekatkan kardus'],
            ['kode_barang' => 'ATK009', 'nama_barang' => 'Gunting', 'kategori_id' => 1, 'kode_kategori' => 'ATK', 'harga' => 12000, 'harga_modal' => 7000, 'stok' => 20, 'satuan' => 'pcs', 'deskripsi' => 'Gunting stainless steel standar untuk kantor'],
            ['kode_barang' => 'ATK010', 'nama_barang' => 'Penjepit Kertas', 'kategori_id' => 1, 'kode_kategori' => 'ATK', 'harga' => 7000, 'harga_modal' => 4000, 'stok' => 50, 'satuan' => 'box', 'deskripsi' => 'Penjepit kertas ukuran standar per box 12 pcs'],


            ['kode_barang' => 'KRT001', 'nama_barang' => 'Kertas A4 70gsm', 'kategori_id' => 2, 'kode_kategori' => 'KRT', 'harga' => 35000, 'harga_modal' => 25000, 'stok' => 25, 'satuan' => 'rim', 'deskripsi' => 'Kertas putih premium 70gsm, 1 rim = 500 lembar'],
            ['kode_barang' => 'KRT002', 'nama_barang' => 'Kertas A4 80gsm', 'kategori_id' => 2, 'kode_kategori' => 'KRT', 'harga' => 42000, 'harga_modal' => 30000, 'stok' => 20, 'satuan' => 'rim', 'deskripsi' => 'Kertas putih berkualitas tinggi 80gsm'],
            ['kode_barang' => 'KRT003', 'nama_barang' => 'Kertas Folio', 'kategori_id' => 2, 'kode_kategori' => 'KRT', 'harga' => 20000, 'harga_modal' => 14000, 'stok' => 15, 'satuan' => 'rim', 'deskripsi' => 'Kertas folio putih standar'],
            ['kode_barang' => 'KRT004', 'nama_barang' => 'Kertas HVS Berwarna', 'kategori_id' => 2, 'kode_kategori' => 'KRT', 'harga' => 30000, 'harga_modal' => 20000, 'stok' => 10, 'satuan' => 'rim', 'deskripsi' => 'Kertas HVS berwarna pilihan (merah, biru, hijau, kuning)'],
            ['kode_barang' => 'KRT005', 'nama_barang' => 'Kertas Karbon', 'kategori_id' => 2, 'kode_kategori' => 'KRT', 'harga' => 12000, 'harga_modal' => 7000, 'stok' => 30, 'satuan' => 'rim', 'deskripsi' => 'Kertas karbon untuk membuat rangkap tulisan'],
            ['kode_barang' => 'KRT006', 'nama_barang' => 'Kertas Amplop', 'kategori_id' => 2, 'kode_kategori' => 'KRT', 'harga' => 15000, 'harga_modal' => 9000, 'stok' => 40, 'satuan' => 'pak', 'deskripsi' => 'Amplop putih standar ukuran A4 dan B5'],


            ['kode_barang' => 'BKU001', 'nama_barang' => 'Buku Tulis 32 Halaman', 'kategori_id' => 3, 'kode_kategori' => 'BKU', 'harga' => 4500, 'harga_modal' => 2500, 'stok' => 60, 'satuan' => 'pcs', 'deskripsi' => 'Buku tulis standar dengan 32 halaman bergaris'],
            ['kode_barang' => 'BKU002', 'nama_barang' => 'Buku Tulis 48 Halaman', 'kategori_id' => 3, 'kode_kategori' => 'BKU', 'harga' => 6000, 'harga_modal' => 3500, 'stok' => 50, 'satuan' => 'pcs', 'deskripsi' => 'Buku tulis dengan 48 halaman bergaris'],
            ['kode_barang' => 'BKU003', 'nama_barang' => 'Buku Tulis A5', 'kategori_id' => 3, 'kode_kategori' => 'BKU', 'harga' => 3500, 'harga_modal' => 2000, 'stok' => 70, 'satuan' => 'pcs', 'deskripsi' => 'Buku tulis kecil ukuran A5 untuk catatan'],
            ['kode_barang' => 'BKU004', 'nama_barang' => 'Buku Kwadrat', 'kategori_id' => 3, 'kode_kategori' => 'BKU', 'harga' => 5000, 'harga_modal' => 3000, 'stok' => 45, 'satuan' => 'pcs', 'deskripsi' => 'Buku dengan garis kotak-kotak untuk sketsa dan grafis'],
            ['kode_barang' => 'BKU005', 'nama_barang' => 'Buku Nota Kecil', 'kategori_id' => 3, 'kode_kategori' => 'BKU', 'harga' => 2500, 'harga_modal' => 1500, 'stok' => 100, 'satuan' => 'pcs', 'deskripsi' => 'Buku nota kecil untuk pengingat/memo'],
            ['kode_barang' => 'BKU006', 'nama_barang' => 'Buku Tulis Spiral', 'kategori_id' => 3, 'kode_kategori' => 'BKU', 'harga' => 8000, 'harga_modal' => 5000, 'stok' => 30, 'satuan' => 'pcs', 'deskripsi' => 'Buku spiral dengan cover plastik durable'],


            ['kode_barang' => 'PHG001', 'nama_barang' => 'Penghapus Pensil Standar', 'kategori_id' => 4, 'kode_kategori' => 'PHG', 'harga' => 1500, 'harga_modal' => 800, 'stok' => 100, 'satuan' => 'pcs', 'deskripsi' => 'Penghapus pensil merah standar kualitas'],
            ['kode_barang' => 'PHG002', 'nama_barang' => 'Penghapus Pensil Putih', 'kategori_id' => 4, 'kode_kategori' => 'PHG', 'harga' => 2000, 'harga_modal' => 1200, 'stok' => 80, 'satuan' => 'pcs', 'deskripsi' => 'Penghapus pensil putih premium dengan daya hapus kuat'],
            ['kode_barang' => 'PHG003', 'nama_barang' => 'Penghapus Ballpoint', 'kategori_id' => 4, 'kode_kategori' => 'PHG', 'harga' => 3000, 'harga_modal' => 1800, 'stok' => 40, 'satuan' => 'pcs', 'deskripsi' => 'Penghapus khusus untuk tinta ballpoint'],
            ['kode_barang' => 'PHG004', 'nama_barang' => 'Penghapus Papan Tulis', 'kategori_id' => 4, 'kode_kategori' => 'PHG', 'harga' => 5000, 'harga_modal' => 3000, 'stok' => 15, 'satuan' => 'pcs', 'deskripsi' => 'Penghapus spesial untuk whiteboard dan chalkboard'],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }
}
