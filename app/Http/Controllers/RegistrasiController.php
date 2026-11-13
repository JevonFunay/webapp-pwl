<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Registrasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrasiController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        abort_unless($user && in_array($user->role, ['dosen', 'mahasiswa'], true), 403);

        if ($user->role === 'dosen') {
            return view('registrasi.overview', [
                'registrasis' => Registrasi::with('mahasiswa')->withCount('krskhs')
                    ->orderByDesc('noReg')->paginate(15),
            ]);
        }

        if (! filled($user->nim) || ! Mahasiswa::whereKey($user->nim)->exists()) {
            return redirect()->route('profile.edit')->withErrors([
                'nim' => 'Akun belum terhubung dengan data mahasiswa. Hubungi dosen untuk mengaktifkan akses registrasi.',
            ]);
        }

        $registrasi = Registrasi::where('nim', $user->nim)->orderByDesc('noReg')->first();
        if (! $registrasi) {
            $registrasi = Registrasi::create(['nim' => $user->nim, 'tanggal' => now()]);
        }

        $request->session()->put('noReg', $registrasi->noReg);

        return $this->detail($registrasi, false);
    }

    public function show(Request $request, Registrasi $registrasi): View
    {
        $user = $request->user();
        abort_unless($user && ($user->role === 'dosen' || (
            $user->role === 'mahasiswa' && filled($user->nim)
            && (string) $registrasi->nim === (string) $user->nim
        )), 403, 'Akses registrasi ditolak.');

        return $this->detail($registrasi, $user->role === 'dosen');
    }

    private function detail(Registrasi $registrasi, bool $readOnly): View
    {
        $registrasi->load('mahasiswa');
        $krskhs = $registrasi->krskhs()->with([
            'jadwal.matakuliah', 'jadwal.dosen',
        ])->orderBy('idKrs')->get();

        return view('registrasi.index', compact('registrasi', 'krskhs', 'readOnly'));
    }
}
