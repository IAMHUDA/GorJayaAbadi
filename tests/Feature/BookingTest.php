<?php
// tests/Feature/BookingTest.php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Lapangan;
use App\Models\Pesanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_access_booking_create_page()
    {
        $user = User::factory()->create();
        $lapangan = Lapangan::factory()->create();

        // Kirim request dengan lapangan_id di query string
        $response = $this->actingAs($user)->get('/booking/create?lapangan_id=' . $lapangan->id);

        $response->assertStatus(200);
        $response->assertViewIs('user.booking-form');
        $response->assertViewHas('lapangan', function ($data) use ($lapangan) {
            return $data->id === $lapangan->id;
        });
    }

    /** @test */
    public function user_can_store_booking()
    {
        $user = User::factory()->create();
        $lapangan = Lapangan::factory()->create();

        $data = [
            'lapangan_id' => $lapangan->id,
            'tanggal_booking' => now()->toDateString(),
            'jam_mulai' => '10:00',
            'jam_selesai' => '11:00',
        ];

        $response = $this->actingAs($user)->post('/booking/store', $data);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('success', 'Berhasil memesan lapangan!');

        // Cek apakah data tersimpan di tabel pesanan
        $this->assertDatabaseHas('pesanans', [
            'user_id' => $user->id,
            'lapangan_id' => $lapangan->id,
            'tanggal_booking' => $data['tanggal_booking'],
            'jam_mulai' => $data['jam_mulai'],
            'jam_selesai' => $data['jam_selesai'],
            'status' => 'pending',
        ]);
    }
}
