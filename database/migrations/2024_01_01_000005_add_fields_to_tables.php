<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->decimal('harga_modal', 12, 2)->nullable()->after('harga');
            $table->string('satuan')->default('pcs')->after('stok');
            $table->text('deskripsi')->nullable()->after('satuan');
            $table->string('kode_kategori')->nullable()->after('kategori_id');
        });

        Schema::table('kategori', function (Blueprint $table) {
            $table->string('kode_kategori')->nullable()->after('id');
            $table->text('deskripsi')->nullable()->after('nama_kategori');
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn(['harga_modal', 'satuan', 'deskripsi', 'kode_kategori']);
        });

        Schema::table('kategori', function (Blueprint $table) {
            $table->dropColumn(['kode_kategori', 'deskripsi']);
        });
    }
};
