<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestaSatisfaccion extends Model
{
    protected $fillable = ['user_id','pregunta_id','valor','comentario'];

    public function pregunta()
    {
        return $this->belongsTo(PreguntaSatisfaccion::class, 'pregunta_id');
    }
}
