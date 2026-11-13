<?php

namespace Database\Factories;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dosen>
 */
class DosenFactory extends Factory
{
    protected $model = Dosen::class;

    public function definition(): array
    {
        $faker = fake('id_ID');

        do {
            $nik = $faker->unique()->numerify('#######');
        } while (Dosen::whereKey($nik)->exists());

        return [
            'nik' => $nik,
            'namaDosen' => mb_substr($faker->name(), 0, 35),
        ];
    }
}
