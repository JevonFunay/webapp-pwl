<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\Registrasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Registrasi>
 */
class RegistrasiFactory extends Factory
{
    protected $model = Registrasi::class;

    public function definition(): array
    {
        return [
            'tanggal' => fake('id_ID')->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'nim' => Mahasiswa::query()->inRandomOrder()->firstOrFail()->nim,
        ];
    }
}
