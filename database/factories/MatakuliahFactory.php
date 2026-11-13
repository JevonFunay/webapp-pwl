<?php

namespace Database\Factories;

use App\Models\Matakuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Matakuliah>
 */
class MatakuliahFactory extends Factory
{
    protected $model = Matakuliah::class;

    public function definition(): array
    {
        $faker = fake('id_ID');

        do {
            $kodeMK = $faker->unique()->numerify('MK####');
        } while (Matakuliah::whereKey($kodeMK)->exists());

        return [
            'kodeMK' => $kodeMK,
            'namaMK' => $faker->randomElement([
                'Pemrograman Web Lanjut',
                'Basis Data',
                'Algoritma dan Pemrograman',
                'Pemrograman Berorientasi Objek',
                'Jaringan Komputer',
                'Sistem Operasi',
                'Rekayasa Perangkat Lunak',
                'Interaksi Manusia dan Komputer',
                'Kecerdasan Buatan',
                'Keamanan Sistem Informasi',
            ]),
            'sks' => $faker->numberBetween(2, 4),
        ];
    }
}
