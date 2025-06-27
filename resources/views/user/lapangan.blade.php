@extends('layouts.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">


@section('content')
    <style>
        /* Root variables for theme colors */
        :root {
            --card-bg-light: linear-gradient(135deg, rgba(245, 245, 250, 0.95), rgba(255, 255, 255, 0.9));
            --card-bg-dark: linear-gradient(135deg, rgba(15, 15, 35, 0.9), rgba(25, 25, 50, 0.8));
            --card-border-light: rgba(0, 123, 255, 0.3);
            --card-border-dark: rgba(0, 255, 255, 0.3);
            --card-border-hover-light: rgba(0, 123, 255, 0.6);
            --card-border-hover-dark: rgba(0, 255, 255, 0.6);
            --text-primary-light: #1a1a1a;
            --text-primary-dark: #ffffff;
            --text-secondary-light: #4a5568;
            --text-secondary-dark: #a0a0a0;
            --text-shadow-light: 0 1px 3px rgba(0, 123, 255, 0.3);
            --text-shadow-dark: 0 0 10px rgba(0, 255, 255, 0.5);
            --status-bg-light: rgba(248, 250, 252, 0.8);
            --status-bg-dark: rgba(0, 0, 0, 0.3);
            --status-border-light: rgba(203, 213, 225, 0.5);
            --status-border-dark: rgba(255, 255, 255, 0.1);
            --btn-primary-light: linear-gradient(135deg, #007bff, #0056b3);
            --btn-primary-dark: linear-gradient(135deg, #00ffff, #0066ff);
            --btn-shadow-light: 0 4px 15px rgba(0, 123, 255, 0.3);
            --btn-shadow-dark: 0 4px 15px rgba(0, 255, 255, 0.3);
            --btn-hover-light: linear-gradient(135deg, #0056b3, #004085);
            --btn-hover-dark: linear-gradient(135deg, #00cccc, #0044cc);
            --btn-shadow-hover-light: 0 8px 25px rgba(0, 123, 255, 0.4);
            --btn-shadow-hover-dark: 0 8px 25px rgba(0, 255, 255, 0.4);
            --unavailable-bg-light: rgba(248, 113, 113, 0.1);
            --unavailable-bg-dark: rgba(255, 68, 68, 0.1);
            --unavailable-border-light: rgba(239, 68, 68, 0.3);
            --unavailable-border-dark: rgba(255, 68, 68, 0.3);
            --unavailable-text-light: #dc2626;
            --unavailable-text-dark: #ff4444;
            --sweep-light: linear-gradient(90deg, transparent, rgba(0, 123, 255, 0.1), transparent);
            --sweep-dark: linear-gradient(90deg, transparent, rgba(0, 255, 255, 0.1), transparent);
            --card-shadow-light: 0 8px 32px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.8);
            --card-shadow-dark: 0 8px 32px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            --card-shadow-hover-light: 0 20px 60px rgba(0, 123, 255, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.9);
            --card-shadow-hover-dark: 0 20px 60px rgba(0, 255, 255, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .card {
            background: var(--card-bg-light);
            backdrop-filter: blur(20px);
            border: 1px solid var(--card-border-light);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: var(--card-shadow-light);
        }

        /* Dark mode styles */
        [data-theme="dark"] .card,
        .dark .card,
        body.dark .card {
            background: var(--card-bg-dark);
            border-color: var(--card-border-dark);
            box-shadow: var(--card-shadow-dark);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--sweep-light);
            transition: left 0.6s;
        }

        [data-theme="dark"] .card::before,
        .dark .card::before,
        body.dark .card::before {
            background: var(--sweep-dark);
        }

        .card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: var(--card-border-hover-light);
            box-shadow: var(--card-shadow-hover-light);
        }

        [data-theme="dark"] .card:hover,
        .dark .card:hover,
        body.dark .card:hover {
            border-color: var(--card-border-hover-dark);
            box-shadow: var(--card-shadow-hover-dark);
        }

        .card:hover::before {
            left: 100%;
        }

        .card h3 {
            color: var(--text-primary-light);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: var(--text-shadow-light);
            letter-spacing: 0.5px;
            transition: color 0.3s ease;
        }

        [data-theme="dark"] .card h3,
        .dark .card h3,
        body.dark .card h3 {
            color: var(--text-primary-dark);
            text-shadow: var(--text-shadow-dark);
        }

        .card p {
            color: var(--text-secondary-light);
            font-size: 1rem;
            margin-bottom: 1.5rem;
            padding: 0.8rem 1.2rem;
            background: var(--status-bg-light);
            border-radius: 8px;
            border: 1px solid var(--status-border-light);
            transition: all 0.3s ease;
        }

        [data-theme="dark"] .card p,
        .dark .card p,
        body.dark .card p {
            color: var(--text-secondary-dark);
            background: var(--status-bg-dark);
            border-color: var(--status-border-dark);
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--btn-primary-light);
            color: white;
            box-shadow: var(--btn-shadow-light);
        }

        [data-theme="dark"] .btn-primary,
        .dark .btn-primary,
        body.dark .btn-primary {
            background: var(--btn-primary-dark);
            box-shadow: var(--btn-shadow-dark);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--btn-shadow-hover-light);
            background: var(--btn-hover-light);
        }

        [data-theme="dark"] .btn-primary:hover,
        .dark .btn-primary:hover,
        body.dark .btn-primary:hover {
            box-shadow: var(--btn-shadow-hover-dark);
            background: var(--btn-hover-dark);
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .text-red-500 {
            color: var(--unavailable-text-light) !important;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.8rem 1.2rem;
            background: var(--unavailable-bg-light);
            border: 1px solid var(--unavailable-border-light);
            border-radius: 8px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            transition: all 0.3s ease;
        }

        [data-theme="dark"] .text-red-500,
        .dark .text-red-500,
        body.dark .text-red-500 {
            color: var(--unavailable-text-dark) !important;
            background: var(--unavailable-bg-dark);
            border-color: var(--unavailable-border-dark);
        }

        .text-red-500::before {
            content: '🚫';
            margin-right: 0.5rem;
        }

        /* Container responsive adjustments */
        .container {
            transition: all 0.3s ease;
        }

        /* Media queries for responsive design */
        @media (max-width: 768px) {
            .card {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }

            .card h3 {
                font-size: 1.3rem;
            }

            .btn {
                padding: 0.7rem 1.5rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .card {
                padding: 1rem;
            }

            .card h3 {
                font-size: 1.2rem;
            }

            .card p {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }

            .text-red-500 {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }
        }

        /* Smooth theme transition */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>




    <div class="container mx-auto px-4 py-6">
  <h1 class="page-title">Daftar Lapangan</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($lapangans as $lapangan)
              <div class="pesanan-card">
                  <!-- Tampilkan Gambar -->
                      @if ($lapangan->gambar)
                          <img src="{{ asset('storage/' . $lapangan->gambar) }}" alt="{{ $lapangan->nama }}" class="w-full h-88 object-cover rounded mb-4">
                      @else
                          <div class="w-full h-88 bg-gray-200 flex items-center justify-center mb-4 rounded">
                              <span class="text-gray-500">Gambar tidak tersedia</span>
                          </div>
                      @endif
                <h3 class="pesanan-title">{{ $lapangan->nama }} ({{ ucfirst($lapangan->jenis) }})</h3>
                <p class="pesanan-text">
                  Status: 
                  @if ($lapangan->status)
                    <span class="text-green-400 font-semibold">Aktif</span>
                  @else
                    <span class="text-red-500 font-semibold">Tidak Aktif</span>
                  @endif
                </p>
          
                @if ($lapangan->status)
                  <a href="{{ route('booking.create', ['lapangan_id' => $lapangan->id]) }}" 
                     class="glitch-button text-[var(--text-light)] inline-block mt-3 px-5 py-2 rounded text-white font-bold border border-purple-500 
                     shadow-[5px_5px_0_#000] bg-gradient-to-br from-[#00f5ff1a] via-[#8b5cf61a] to-[#ff14931a] 
                     hover:shadow-[0_0_10px_#00fff7] hover:border-pink-400 transition-all duration-200">
                    Booking Sekarang
                  </a>
                @else
                  <span class="block mt-3 text-sm text-red-400 font-mono">Lapangan tidak tersedia</span>
                @endif
              </div>
            @endforeach
        </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function bookingLapangan(id, nama) {
            Swal.fire({
                title: 'Booking Lapangan?',
                text: 'Anda akan diarahkan untuk booking lapangan: ' + nama,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Booking!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/pesanans/create?lapangan_id=${id}`;
                }
            });
        }
    </script>
@endsection
