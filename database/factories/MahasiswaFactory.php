<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    public function definition(): array
    {
        $faker = fake('id_ID');

        do {
            $nim = $faker->unique()->numerify('########');
        } while (Mahasiswa::whereKey($nim)->exists());

        return [
            'nim' => $nim,
            'nama' => mb_substr($faker->name(), 0, 35),
            'kota' => mb_substr($faker->city(), 0, 25),
        ];
    }
}
