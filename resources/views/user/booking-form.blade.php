@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="page-title title-sec text-3xl mb-6 stroke-blue">Booking
            Lapangan</h2>
        <div class="cardLap container max-w-md mx-auto !p-6 bg-white rounded shadow">
            <h2 class="form-title title-sec mb-[40px]">{{ $lapangan->nama }}</h2>

            <form method="POST" action="{{ route('booking.store') }}">
                @csrf

                <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

                <div class="mb-[50px] form-container">
                    <label class="form-label">Tanggal:</label>
                    <input type="date" name="tanggal_booking" class="form-input-b smooth-type" required>
                </div>

                <div class="mb-[50px] form-container">
                    <label class="form-label">Jam Mulai:</label>
                    <input type="time" name="jam_mulai" class="form-input-b smooth-type" required>
                </div>

                <div class="mb-[50px] form-container">
                    <label class="form-label">Jam Selesai:</label>
                    <input type="time" name="jam_selesai" class="form-input-b smooth-type" required>
                </div>

                <button type="submit" class="btn-glitch title-sec">Booking</button>
            </form>
        </div>
    </div>
@endsection
