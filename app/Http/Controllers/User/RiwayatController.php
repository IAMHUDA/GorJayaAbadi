<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class RiwayatController extends Controller
{
    public function index()
    {
        $pesanan = \App\Models\Pesanan::with('pembayaran')->where('user_id', Auth::id())->get();
        return view('user.riwayat', compact('pesanan'));
    }
}

