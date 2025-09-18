<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costo extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',
        'gasto_deteccion',
        'capital_inicial',
    ];

    /**
     * Relación con el usuario propietario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
