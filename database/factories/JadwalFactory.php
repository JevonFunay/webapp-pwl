<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Matakuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Jadwal>
 */
class JadwalFactory extends Factory
{
    protected $model = Jadwal::class;

    public function definition(): array
    {
        $faker = fake('id_ID');

        return [
            'hari' => $faker->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']),
            'waktu' => $faker->randomElement(['07.30-10.20', '10.30-13.20', '13.30-16.20']),
            'kodeMK' => Matakuliah::query()->inRandomOrder()->firstOrFail()->kodeMK,
            'grup' => $faker->randomElement(['A', 'B', 'C']),
            'nik' => Dosen::query()->inRandomOrder()->firstOrFail()->nik,
            'ruang' => $faker->randomElement([
                'B.101', 'B.102', 'C.201', 'Lab. Komputer 1', 'Lab. Komputer 2',
            ]),
        ];
    }
}
