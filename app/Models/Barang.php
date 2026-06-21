<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = ['kode_barang', 'nama_barang', 'kategori_id', 'kode_kategori', 'harga', 'harga_modal', 'stok', 'satuan', 'deskripsi'];

    protected $casts = [
        'harga' => 'decimal:2',
        'harga_modal' => 'decimal:2',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Kategori::class);
    }

    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(\App\Models\DetailTransaksi::class);
    }
}
