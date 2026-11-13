<?php

namespace Database\Factories;

use App\Models\Jadwal;
use App\Models\Krskhs;
use App\Models\Registrasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Krskhs>
 */
class KrskhsFactory extends Factory
{
    protected $model = Krskhs::class;

    public function definition(): array
    {
        return [
            'noReg' => fn () => Registrasi::query()->inRandomOrder()->firstOrFail()->noReg,
            'jadwalId' => fn () => Jadwal::query()->inRandomOrder()->firstOrFail()->jadwalId,
            'nilai' => fake('id_ID')->randomElement(['A', 'B', 'C', 'D', 'E']),
        ];
    }
}
