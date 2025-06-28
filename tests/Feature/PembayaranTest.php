<?php

// tests/Feature/PembayaranTest.php
namespace Tests\Feature;

use App\Models\User;
use App\Models\Pesanan;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PembayaranTest extends TestCase
{
    use RefreshDatabase;

    public function test_pembayaran_page_accessible()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/pembayaran');

        $response->assertStatus(200);
    }

   public function test_user_can_store_pembayaran()
{
    $user = User::factory()->create();
    $this->actingAs($user);

    $pesanan = \App\Models\Pesanan::factory()->create([
        'user_id' => $user->id,
        'status' => 'pending',
    ]);

    $data = [
        'pesanan_id' => $pesanan->id,
        'metode' => 'qris',
        'total_bayar' => 50000,
        'status' => 'menunggu',
        'tanggal_bayar' => now()->format('Y-m-d H:i:s'),
    ];

    $response = $this->post('/pembayaran', $data);

    // Sesuaikan dengan response json kamu
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
        'message' => 'Pembayaran berhasil disimpan!',
    ]);

    $this->assertDatabaseHas('pembayarans', [
        'pesanan_id' => $pesanan->id,
        'metode' => 'qris',
        'total_bayar' => 50000,
    ]);
}
}