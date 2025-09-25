<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $table = 'sectores';

    // Ahora sí permite llenar user_id
    protected $fillable = ['nombre', 'temperatura', 'descripcion', 'user_id'];

    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

    public function detecciones()
    {
        return $this->hasMany(Deteccion::class);
    }
}
