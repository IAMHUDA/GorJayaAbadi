<?php

namespace Database\Factories;

use App\Models\Pesanan;
use App\Models\User;
use App\Models\Lapangan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesananFactory extends Factory
{
    protected $model = Pesanan::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'lapangan_id' => Lapangan::factory(),
            'tanggal_booking' => $this->faker->date(),
            'jam_mulai' => '08:00',
            'jam_selesai' => '09:00',
            'status' => 'pending',
        ];
    }
}
