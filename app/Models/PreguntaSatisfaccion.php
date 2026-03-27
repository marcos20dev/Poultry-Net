<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaSatisfaccion extends Model
{
    protected $table = 'preguntas_satisfaccion'; // nombre correcto de la tabla
    protected $fillable = ['numero','pregunta'];

    public function respuestas()
    {
        return $this->hasMany(RespuestaSatisfaccion::class, 'pregunta_id');
    }
}
