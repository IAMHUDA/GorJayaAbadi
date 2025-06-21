<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lapangan;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::where('status', true)->get(); // Ambil semua data
    return view('user.lapangan', compact('lapangans'));
    }
}
