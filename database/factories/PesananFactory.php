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
            'jam_mulai' => $this->faker->time('H:i'),
            'jam_selesai' => $this->faker->time('H:i'),
            'status' => 'pending',
        ];
    }
}
