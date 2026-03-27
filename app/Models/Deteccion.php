<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deteccion extends Model
{
    use HasFactory;
    protected $table = 'deteccion'; // 👈 Forzamos el nombre correcto

    protected $fillable = [
        'user_id',
        'sector_id',
        'imagen_url',
        'enfermedad',
        'confianza',
        'tiempo_deteccion',
        'observaciones',
        'recomendacion',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con sector
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
