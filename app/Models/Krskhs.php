<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krskhs extends Model
{
    use HasFactory;

    protected $table = 'krskhs';
    protected $primaryKey = 'idKrs';
    protected $fillable = ['noReg', 'jadwalId', 'nilai'];
    public $timestamps = true;

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class, 'noReg', 'noReg');
    }
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwalId', 'jadwalId');
    }
    
}   
