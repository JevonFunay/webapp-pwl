<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Krskhs;
use App\Models\Mahasiswa;
use App\Models\Registrasi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KrskhsController extends Controller
{
    public function create(Request $request): View
    {
        $registrasi = $this->currentRegistrasi($request);
        $terpilih = $registrasi->krskhs()->whereNotNull('jadwalId')->select('jadwalId');
        $jadwal = Jadwal::with(['dosen', 'matakuliah'])
            ->whereNotIn('jadwalId', $terpilih)->orderBy('jadwalId')->get();

        return view('krskhs.create', compact('jadwal', 'registrasi'));
    }

    public function store(Request $request): RedirectResponse
    {
        $registrasi = $this->currentRegistrasi($request);
        $data = $request->validate([
            'jadwalId' => ['required', 'integer', 'exists:jadwals,jadwalId'],
        ]);

        $krskhs = Krskhs::firstOrCreate([
            'noReg' => $registrasi->noReg,
            'jadwalId' => $data['jadwalId'],
        ], ['nilai' => 'E']);

        return redirect()->route('registrasi.index')->with('status',
            $krskhs->wasRecentlyCreated ? 'Jadwal berhasil ditambahkan.' : 'Jadwal sudah ada di KRS.'
        );
    }

    public function destroy(Request $request, Krskhs $krskhs): RedirectResponse
    {
        $user = $this->requireStudent($request);
        $krskhs->loadMissing('registrasi');
        abort_unless($krskhs->registrasi && (string) $krskhs->registrasi->nim === (string) $user->nim,
            403, 'Anda hanya dapat menghapus jadwal pada KRS sendiri.');

        $krskhs->delete();

        return redirect()->route('registrasi.index')->with('status', 'Jadwal berhasil dihapus.');
    }

    public function pdf(Request $request)
    {
        $user = $request->user();
        abort_unless($user && in_array($user->role, ['dosen', 'mahasiswa'], true), 403);
        $data = $request->validate([
            'noReg' => ['nullable', 'integer', 'exists:registrasis,noReg'],
        ]);

        if ($user->role === 'dosen') {
            if (! isset($data['noReg'])) {
                return redirect()->route('registrasi.index')->withErrors([
                    'noReg' => 'Pilih registrasi mahasiswa yang akan dicetak.',
                ]);
            }
            $registrasi = Registrasi::findOrFail($data['noReg']);
        } else {
            $this->requireStudent($request);
            $registrasi = isset($data['noReg'])
                ? Registrasi::findOrFail($data['noReg'])
                : $this->currentRegistrasi($request);
            abort_unless((string) $registrasi->nim === (string) $user->nim,
                403, 'Anda hanya dapat mencetak KRS sendiri.');
        }

        $registrasi->load('mahasiswa');
        $krskhs = $registrasi->krskhs()->with([
            'jadwal.matakuliah', 'jadwal.dosen',
        ])->orderBy('idKrs')->get();

        return Pdf::loadView('krskhs.pdf', compact('registrasi', 'krskhs'))
            ->setPaper('a4', 'landscape')->stream('KRS_'.$registrasi->nim.'.pdf');
    }

    private function currentRegistrasi(Request $request): Registrasi
    {
        $user = $this->requireStudent($request);
        $registrasi = Registrasi::where('nim', $user->nim)->orderByDesc('noReg')->first();
        if (! $registrasi) {
            $registrasi = Registrasi::create(['nim' => $user->nim, 'tanggal' => now()]);
        }

        $request->session()->put('noReg', $registrasi->noReg);

        return $registrasi;
    }

    private function requireStudent(Request $request): User
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'mahasiswa', 403, 'Akses ini hanya untuk mahasiswa.');
        abort_unless(filled($user->nim) && Mahasiswa::whereKey($user->nim)->exists(), 403,
            'Akun belum terhubung dengan data mahasiswa. Hubungi dosen.');

        return $user;
    }
}
