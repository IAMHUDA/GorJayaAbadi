<?php

// tests/Feature/LapanganTest.php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LapanganTest extends TestCase
{
    use RefreshDatabase;

    public function test_lapangan_page_accessible()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/lapangan');

        $response->assertStatus(200);
    }
}

