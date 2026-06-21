<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $fillable = ['transaksi_id', 'barang_id', 'qty', 'harga', 'subtotal'];

    protected $casts = [
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Transaksi::class);
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Barang::class);
    }
}
