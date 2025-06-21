<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = ['pesanan_id', 'metode', 'total_bayar', 'status', 'tanggal_bayar'];

    public function pesanan()
{
    return $this->belongsTo(\App\Models\Pesanan::class);
}
    public function pembayaran()
{
    return $this->hasOne(Pembayaran::class);
}

}
