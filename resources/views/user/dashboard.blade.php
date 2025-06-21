@extends('layouts.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

@section('content')



    <!-- Konten Utama -->
    <main class="main">
        <div class="container">
            <div class="welcome-section">
                <h1 class="welcome-title">GOR JAYA ABADI</h1>
                <p class="welcome-text">Selamat Datang <span class="user-name">{{ Auth::user()->name }}</span>!</p>
                <div class="welcome-decoration"></div>
            </div>

            <div class="cards-grid">
                <a href="{{ route('user.lapangan') }}">
                    <div class="card" data-category="lapangan">
                        <div class="card-icon">
                            <i class="fas fa-futbol"></i>
                        </div>
                        <div class="card-content">
                            <h2 class="card-title">CYBER FIELD</h2>
                            <p class="card-description">Akses instant ke lapangan futuristik dengan teknologi hologram dan
                                sistem booking AI terdepan.</p>
                            <a href="{{ route('user.lapangan') }}" class="card-link">
                                <span>INITIALIZE BOOKING</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </a>

                <a href="{{ route('user.pesanan') }}">
                    <div class="card" data-category="pesanan">
                        <div class="card-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="card-content">
                            <h2 class="card-title">ORDER MATRIX</h2>
                            <p class="card-description">Pantau dan kelola semua reservasi Anda melalui sistem neural network
                                terintegrasi.</p>
                            <a href="{{ route('user.pesanan') }}" class="card-link">
                                <span>ACCESS MATRIX</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </a>

                <a href="{{ route('user.pembayaran') }}">
                    <div class="card" data-category="pembayaran">
                        <div class="card-icon">
                            <i class="fas fa-gem"></i>
                        </div>
                        <div class="card-content">
                            <h2 class="card-title">QUANTUM PAY</h2>
                            <p class="card-description">Sistem pembayaran quantum yang aman dengan enkripsi galaksi untuk
                                semua transaksi Anda.</p>
                            <a href="{{ route('user.pembayaran') }}" class="card-link">
                                <span>QUANTUM TRANSFER</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main>
