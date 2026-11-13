<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class MahasiswaUserSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswas = Mahasiswa::query()->orderBy('nim')->limit(10)->get();
        if ($mahasiswas->isEmpty()) {
            throw new RuntimeException('Data mahasiswa belum tersedia. Jalankan MahasiswaSeeder terlebih dahulu.');
        }

        DB::transaction(function () use ($mahasiswas): void {
            foreach ($mahasiswas as $mahasiswa) {
                $email = $mahasiswa->nim.'@sia.ac.id';
                $user = User::query()->where('nim', $mahasiswa->nim)->first()
                    ?? User::query()->where('email', $email)->first()
                    ?? new User;

                $user->forceFill([
                    'nim' => $mahasiswa->nim,
                    'name' => $mahasiswa->nama,
                    'email' => $user->exists ? $user->email : $email,
                    'password' => Hash::make($mahasiswa->nim),
                    'role' => 'mahasiswa',
                    'email_verified_at' => now(),
                ])->save();
            }

            $dosen = User::firstOrNew(['email' => 'dosen@sia.ac.id']);
            $dosen->forceFill([
                'nim' => null,
                'name' => 'Dosen SIA',
                'password' => Hash::make('Dosen123!'),
                'role' => 'dosen',
                'email_verified_at' => now(),
            ])->save();
        });

        $nim = $mahasiswas->first()->nim;
        $this->command?->info('Akun mahasiswa: login '.$nim.' | password '.$nim);
        $this->command?->info('Akun dosen: dosen@sia.ac.id | password Dosen123!');
    }
}
