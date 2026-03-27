<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestaSatisfaccion extends Model
{
    protected $table = 'respuestas_satisfaccion'; // Nombre real de la tabla

    protected $fillable = ['user_id','pregunta_id','puntuacion'];

    public function pregunta()
    {
        return $this->belongsTo(PreguntaSatisfaccion::class, 'pregunta_id');
    }
}
