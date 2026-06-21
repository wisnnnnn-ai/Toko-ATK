<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = ['kode_transaksi', 'tanggal', 'total', 'user_id'];

    protected $casts = [
        'tanggal' => 'date',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(\App\Models\DetailTransaksi::class);
    }
}
