@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6">
    <h1 class="page-title text-black">Riwayat Pesanan Anda</h1>
    
    @if ($pesanans->count())
        @foreach ($pesanans as $pesanan)
            <div class="pesanan-card">
                <h2 class="pesanan-title">{{ $pesanan->lapangan->nama }} ({{ ucfirst($pesanan->lapangan->jenis) }})</h2>
                
                <p class="pesanan-text">
                    Tanggal: {{ $pesanan->tanggal_booking }} <br>
                    Jam: {{ $pesanan->jam_mulai }} - {{ $pesanan->jam_selesai }}
                </p>
                
                <p class="status-label">Status:
                    @if ($pesanan->status === 'pending')
                        <span class="status-badge status-pending">Belum Dibayar</span>
                    @elseif ($pesanan->status === 'dibayar')
                        <span class="status-badge status-paid">Dibayar</span>
                    @else
                        <span class="status-badge status-completed">Selesai</span>
                    @endif
                </p>
                
                <p class="price-text">
                    Estimasi Total Bayar: Rp {{ number_format((\Carbon\Carbon::parse($pesanan->jam_mulai)->diffInHours(\Carbon\Carbon::parse($pesanan->jam_selesai))) * $pesanan->lapangan->harga, 0, ',', '.') }}
                </p>
            </div>
        @endforeach
    @else
        <div class="pesanan-card text-center">
            <p class="pesanan-text">Anda belum memiliki riwayat pesanan.</p>
        </div>
    @endif
</div>
@endsection