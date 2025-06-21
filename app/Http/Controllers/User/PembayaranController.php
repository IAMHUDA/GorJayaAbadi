<?php

namespace App\Http\Controllers\User;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembayaranController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Pembayaran yang sudah dilakukan user
        $pembayaran = Pembayaran::with(['pesanan.lapangan'])
            ->whereHas('pesanan', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                ->whereDoesntHave('pembayaran');
            })->latest()->get();

        // Pesanan milik user yang belum dibayar
        $belumDibayar = Pesanan::where('user_id', $userId)
            ->where('status', 'pending') // atau 'menunggu'
            ->with('lapangan')
            ->get();

        return view('user.pembayaran', compact('pembayaran', 'belumDibayar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id',
            'metode' => 'required|in:qris,transfer,tunai',
            'total_bayar' => 'required|numeric|min:1000',
        ]);

        $pesanan = Pesanan::where('id', $request->pesanan_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$pesanan || $pesanan->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak valid atau sudah dibayar.'
            ]);
        }

        // Simpan pembayaran
        Pembayaran::create([
            'pesanan_id' => $pesanan->id,
            'metode' => $request->metode,
            'total_bayar' => $request->total_bayar,
            'status' => 'menunggu', // bisa diganti ke 'sukses' jika langsung dianggap lunas
            'tanggal_bayar' => now(),
        ]);

        // Ubah status pesanan
        $pesanan->update(['status' => 'dibayar']);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil disimpan!'
        ]);
    }
}
