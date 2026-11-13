<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use App\Models\Krskhs;
use App\Models\Registrasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class KrskhsSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $registrasis = Registrasi::query()->orderByDesc('noReg')->limit(10)->get();
            if ($registrasis->count() < 10) {
                throw new RuntimeException('Siapkan minimal 10 data registrasi terlebih dahulu.');
            }

            foreach ($registrasis as $registrasi) {
                $terpakai = $registrasi->krskhs()->whereNotNull('jadwalId')->pluck('jadwalId');
                $jadwalIds = Jadwal::query()
                    ->whereNotIn('jadwalId', $terpakai)
                    ->inRandomOrder()
                    ->limit(3)
                    ->pluck('jadwalId');

                if ($jadwalIds->count() < 3) {
                    throw new RuntimeException('Tidak tersedia tiga jadwal baru untuk salah satu registrasi.');
                }

                foreach ($jadwalIds as $jadwalId) {
                    Krskhs::factory()->create([
                        'noReg' => $registrasi->noReg,
                        'jadwalId' => $jadwalId,
                    ]);
                }
            }
        });
    }
}
