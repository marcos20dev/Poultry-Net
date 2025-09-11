<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $table = 'sectores'; // Esto fuerza a usar 'sectores' en lugar de 'sectors'

    protected $fillable = ['nombre', 'temperatura', 'descripcion'];

    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }
    /**
     * Relación con detecciones (si más adelante quieres agregarlas)
     */
    public function detecciones()
    {
        return $this->hasMany(Deteccion::class);
    }
}
