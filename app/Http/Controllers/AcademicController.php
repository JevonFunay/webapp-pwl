<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\View\View;

class AcademicController extends Controller
{
    public function mahasiswa(): View
    {
        return view('akademik.index', [
            'title' => 'Data Mahasiswa',
            'columns' => ['nim' => 'NIM', 'nama' => 'Nama', 'kota' => 'Kota'],
            'rows' => Mahasiswa::orderBy('nim')->paginate(15),
        ]);
    }

    public function dosen(): View
    {
        return view('akademik.index', [
            'title' => 'Data Dosen',
            'columns' => ['nik' => 'NIK', 'namaDosen' => 'Nama Dosen'],
            'rows' => Dosen::orderBy('nik')->paginate(15),
        ]);
    }

    public function matakuliah(): View
    {
        return view('akademik.index', [
            'title' => 'Data Mata Kuliah',
            'columns' => ['kodeMK' => 'Kode MK', 'namaMK' => 'Mata Kuliah', 'sks' => 'SKS'],
            'rows' => Matakuliah::orderBy('kodeMK')->paginate(15),
        ]);
    }

    public function jadwal(): View
    {
        return view('akademik.index', [
            'title' => 'Data Jadwal',
            'columns' => [
                'hari' => 'Hari', 'waktu' => 'Waktu', 'matakuliah.namaMK' => 'Mata Kuliah',
                'grup' => 'Grup', 'dosen.namaDosen' => 'Dosen', 'ruang' => 'Ruang',
            ],
            'rows' => Jadwal::with(['matakuliah', 'dosen'])->orderBy('jadwalId')->paginate(15),
        ]);
    }
}
