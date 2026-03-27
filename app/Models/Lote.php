<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'sector_id',
        'cantidad_pollos',
        'edad_dias',
        'etapa',
        'raza',
        'fecha_ingreso',
        'descripcion',
        'user_id', // ✅ agregamos esto
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
