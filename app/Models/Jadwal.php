<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';
    protected $primaryKey = 'jadwalId';
    protected $fillable = ['hari', 'waktu', 'kodeMK', 'grup', 'nik', 'ruang'];
    public $timestamps = false;

    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'kodeMK', 'kodeMK');
    }
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nik', 'nik');
    }
}
