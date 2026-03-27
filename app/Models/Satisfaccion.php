<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satisfaccion extends Model
{
    use HasFactory;
    protected $table = 'satisfacciones'; // <- esto indica la tabla correcta

    protected $fillable = [
        'user_id',
        'puntuacion',
        'comentario',
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
