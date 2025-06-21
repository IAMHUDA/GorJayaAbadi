<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = ['user_id', 'lapangan_id', 'tanggal_booking', 'jam_mulai', 'jam_selesai', 'harga','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


public function lapangan() {
    return $this->belongsTo(\App\Models\Lapangan::class);
}

public function pembayaran() {
    return $this->hasOne(\App\Models\Pembayaran::class);
}

    

}
