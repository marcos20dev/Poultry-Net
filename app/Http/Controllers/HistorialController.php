<?php

namespace App\Http\Controllers;

use App\Models\Costo;
use App\Models\Deteccion;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
//    public function index(){
//        return view('site.historial.historial');
//    }

    public function index()
    {
        $user = auth()->user();

        // Obtener el costo del usuario (solo uno)
        $costo = Costo::where('user_id', $user->id)->first();
        $gastoDet = $costo ? $costo->gasto_deteccion : 0;
        $inversion = $costo ? $costo->capital_inicial : 0;

        // Obtener todas las detecciones del usuario con sector
        $detecciones = Deteccion::with('sector')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $totalDet = $detecciones->count();
        $retorno = $totalDet * $gastoDet;
        $estado = $retorno >= $inversion ? 'ahorro' : 'recuperacion';
        $ahorro = $estado === 'ahorro' ? $retorno - $inversion : 0;
        $faltante = $estado === 'recuperacion' ? $inversion - $retorno : 0;

        // Resumen por sector
// Resumen por sector
        $sectoresResumen = $detecciones
            ->groupBy('sector_id')
            ->map(function($sectorDet) {
                $cantidad = $sectorDet->count();
                $tiempo_promedio = $sectorDet->avg('tiempo_deteccion');
                $enfermedad = $sectorDet->sortByDesc('created_at')->first()->enfermedad ?? 'N/A';

                return [
                    'id' => $sectorDet->first()->sector->id ?? 0,
                    'nombre' => $sectorDet->first()->sector->nombre ?? 'N/A',
                    'cantidad' => $cantidad,
                    'tiempo_promedio' => $tiempo_promedio,
                    'enfermedad' => $enfermedad,
                ];
            })
            ->values(); // Para resetear keys

        return view('site.historial.historial', compact(
            'costo',
            'totalDet',
            'retorno',
            'estado',
            'ahorro',
            'faltante',
            'gastoDet',
            'inversion',
            'sectoresResumen'
        ));
    }

    public function sectorDetalle($sectorId)
    {
        $user = auth()->user();

        // Obtener todas las detecciones del usuario para ese sector
        $detecciones = Deteccion::where('user_id', $user->id)
            ->where('sector_id', $sectorId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Información del sector
        $sectorNombre = $detecciones->first()->sector->nombre ?? 'N/A';

        // KPIs del sector
        $cantidad = $detecciones->count();
        $tiempo_promedio = $detecciones->avg('tiempo_deteccion');

        return view('site.historial.sector_detalle', compact(
            'detecciones',
            'sectorNombre',
            'cantidad',
            'tiempo_promedio'
        ));
    }


}
