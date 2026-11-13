<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = "genre_tables";
    protected $primaryKey = "id_gendre";
    public $incrementing = false;
    protected $keyType = "string";  
    protected $fillable = ['id_gendre', 'nama_genre'];
    
    public function movies()
    {
        return $this->hasMany(Movie::class, 'id_gendre', 'id_gendre');
    }

}
