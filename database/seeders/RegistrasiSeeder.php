<?php

namespace Database\Seeders;

use App\Models\Registrasi;
use Illuminate\Database\Seeder;

class RegistrasiSeeder extends Seeder
{
    public function run(): void
    {
        Registrasi::factory()->count(10)->create();
    }
}
