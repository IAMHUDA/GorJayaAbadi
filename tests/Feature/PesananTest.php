<?php

// tests/Feature/PesananTest.php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PesananTest extends TestCase
{
    use RefreshDatabase;

    public function test_pesanan_page_accessible()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/pesanan');

        $response->assertStatus(200);
    }
}
