<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
    public function create(Request $request)
    {
        $lapangan = Lapangan::findOrFail($request->lapangan_id);
        return view('user.booking-form', compact('lapangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_booking' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        Pesanan::create([
            'user_id' => Auth::id(),
            'lapangan_id' => $request->lapangan_id,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Berhasil memesan lapangan!');
    }
}
