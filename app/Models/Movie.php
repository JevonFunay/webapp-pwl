<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = "movies_tables";
    protected $primaryKey = "id_movie";
    public $incrementing = false;
    protected $keyType = "string";
    protected $fillable = [
        'id_movie',
        'judul_movie',
        'id_gendre',
        'year',
        'poster'
    ];
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'id_gendre', 'id_gendre');
    }
}
