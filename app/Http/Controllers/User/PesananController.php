<?php

namespace App\Http\Controllers\User;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with('lapangan')
            ->where('user_id', auth()->id())
            ->orderBy('tanggal_booking', 'desc')
            ->get();

        return view('user.pesanan', compact('pesanans'));
    }
}

