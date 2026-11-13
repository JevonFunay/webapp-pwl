<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliahs';
    protected $primaryKey = 'kodeMK';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kodeMK', 'namaMK', 'sks'];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'kodeMK', 'kodeMK');
    }
}
