@extends('layouts.app')

@section('content')


 
    <div class="container-pembayaran mx-auto px-4 py-6">
    <h1 class="page-title">Pembayaran Yang Harus Anda Bayar</h1>

    {{-- Jika ada pesanan belum dibayar --}}
    @if ($belumDibayar->count())
        <div class="pesanan-card">
            <h2 class="pesanan-title">Pesanan yang Belum Dibayar</h2>
            @foreach ($belumDibayar as $item)
                <div class="pesanan-card">
                    <div>
                        <p class="pesanan-title">{{ $item->lapangan->nama }} ({{ ucfirst($item->lapangan->jenis) }})</p>
                        <p class="pesanan-text">Tanggal: {{ $item->tanggal_booking }} | Jam: {{ $item->jam_mulai }} - {{ $item->jam_selesai }}</p>
                        <p class="price-text">Harga: Rp {{ number_format($item->lapangan->harga, 0, ',', '.') }}</p>
                    </div>

                    <button
                        onclick="window.formPembayaran({{ $item->id }}, '{{ $item->lapangan->nama }}', {{ $item->lapangan->harga }})"
                        class="btn-glitch mt-4">
                        Bayar
                    </button>
                </div>
            @endforeach
        </div>
    @else
        <div class="pesanan-card text-center">
            <p class="pesanan-text">Tidak ada pesanan yang harus dibayar.</p>
        </div>
    @endif
</div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.formPembayaran = function(pesananId, lapanganNama, harga) {

            Swal.fire({
                title: `Pembayaran untuk ${lapanganNama}`,
                html: `
            <form id="formBayar">
                <input type="hidden" name="pesanan_id" value="${pesananId}" />
                <label for="metode">Metode Pembayaran</label>
                <select id="metode" name="metode" class="swal2-input" onchange="window.updateInfoPembayaran(this.value)">
                    <option value="qris">QRIS</option>
                    <option value="transfer">Transfer</option>
                    <option value="tunai">Tunai</option>
                </select>
                <div id="metode-info" class="text-sm text-left mt-2"></div>

                <label>Total Bayar (Rp)</label>
<div class="swal2-input" style="line-height: 2.5rem; background-color: #eee;" readonly>
    Rp ${harga.toLocaleString('id-ID')}
</div>
<input type="hidden" id="total_bayar" name="total_bayar" value="${harga}" />


                
            </form>
            <p class="text-sm text-gray-600 mt-2">Harga yang harus dibayar: <strong>Rp ${Number(harga).toLocaleString('id-ID')}</strong></p>
            `,
                confirmButtonText: 'Bayar Sekarang',
                focusConfirm: false,
                didOpen: () => {
                    window.updateInfoPembayaran('qris');
                },
                preConfirm: () => {
                    const metode = Swal.getPopup().querySelector('#metode').value;
                    const total = Swal.getPopup().querySelector('#total_bayar').value;

                    if (!total) {
                        Swal.showValidationMessage('Total bayar harus diisi');
                        return false;
                    }

                    return {
                        pesanan_id: pesananId,
                        metode: metode,
                        total_bayar: total
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/pembayaran', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify(result.value)
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Sukses!', data.message, 'success').then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire('Gagal', data.message || 'Terjadi kesalahan', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                        });
                }
            });
        }

        window.updateInfoPembayaran = function(metode) {
            const infoEl = document.getElementById('metode-info');
            if (!infoEl) return;

            if (metode === 'qris') {
                infoEl.innerHTML = `
            <p class="mb-2 text-center">Silakan scan QR berikut:</p>
            <img src="https://ijobas.pelnus.ac.id/download/Qr.png" class="mx-auto rounded shadow" width="150">
        `;
            } else if (metode === 'transfer') {
                infoEl.innerHTML = `
            <p class="mb-2">Transfer ke rekening berikut:</p>
            <p><strong>Bank BNI</strong><br>No Rek: <strong>1234567890</strong><br>a.n. GOR Elite</p>
        `;
            } else {
                infoEl.innerHTML = `<p>Pembayaran akan dilakukan secara tunai saat ke lokasi.</p>`;
            }
        }
    </script>
@endsection
