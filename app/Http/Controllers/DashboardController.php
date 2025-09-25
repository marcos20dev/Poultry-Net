<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deteccion;
use App\Models\Costo;
use App\Models\Sector;
use App\Models\PreguntaSatisfaccion; // Solo si lo usas para el modal, si no, también se puede eliminar

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // Usuario logueado

        // Total de detecciones solo del usuario
        $totalDetecciones = Deteccion::where('user_id', $userId)->count();

        // Tiempo promedio de detección solo del usuario
        $tiempoPromedio = Deteccion::where('user_id', $userId)->avg('tiempo_deteccion');

        // Costos solo del usuario
        $costos = (object)[
            'total_gasto' => Costo::where('user_id', $userId)->sum('gasto_deteccion'),
            'promedio_gasto' => Costo::where('user_id', $userId)->avg('gasto_deteccion')
        ];

        // Detecciones por enfermedad solo del usuario
        $deteccionesPorEnfermedad = Deteccion::where('user_id', $userId)
            ->select('enfermedad')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('enfermedad')
            ->pluck('total', 'enfermedad');

        // Eficiencia por sector solo del usuario
        $eficienciaPorSector = Deteccion::where('user_id', $userId)
            ->select('sector_id')
            ->selectRaw('AVG(confianza) as eficiencia')
            ->groupBy('sector_id')
            ->with('sector')
            ->get()
            ->pluck('eficiencia', 'sector_id');

        // Distribución de costos solo del usuario
        $distribucionCostos = [
            'Alimentación' => $costos->total_gasto * 0.45,
            'Medicamentos' => $costos->total_gasto * 0.25,
            'Mano de Obra' => $costos->total_gasto * 0.20,
            'Equipamiento' => $costos->total_gasto * 0.10,
        ];

        // Últimas detecciones solo del usuario
        $ultimasDetecciones = Deteccion::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get();
        $preguntasSatisfaccion = PreguntaSatisfaccion::all();

        return view('dashboard.dashboard', compact(
            'totalDetecciones',
            'tiempoPromedio',
            'costos',
            'deteccionesPorEnfermedad',
            'eficienciaPorSector',
            'distribucionCostos',
            'ultimasDetecciones',
            'preguntasSatisfaccion' // 👈 pasamos las preguntas

        ));
    }


}
