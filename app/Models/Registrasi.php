<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registrasi extends Model
{
    use HasFactory;

    protected $table = 'registrasis';
    protected $primaryKey = 'noReg';
    protected $fillable = ['tanggal', 'nim'];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date:Y-m-d',
        ];
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
    public function krskhs()
    {
        return $this->hasMany(Krskhs::class, 'noReg', 'noReg');
    }
}
