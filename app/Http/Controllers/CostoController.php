<?php

namespace App\Http\Controllers;

use App\Models\Costo;
use Illuminate\Http\Request;

class CostoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Traer el costo del usuario (si existe)
        $costo = Costo::where('user_id', $user->id)->first();

        $gasto_det = $costo ? $costo->gasto_deteccion : 0;
        $inversion = $costo ? $costo->capital_inicial : 0;

        // Contar todas las detecciones del usuario
        $detecciones = \App\Models\Deteccion::where('user_id', $user->id)->count();

        // Cálculos
        $retorno = $gasto_det * $detecciones;
        $estado = $retorno >= $inversion ? 'ahorro' : 'recuperacion';
        $ahorro = $estado === 'ahorro' ? $retorno - $inversion : 0;
        $faltante = $estado === 'recuperacion' ? $inversion - $retorno : 0;
        $porcentaje = $inversion > 0 ? min(100, ($retorno / $inversion) * 100) : 0;

        return view('site.costos.costos', compact(
            'costo',
            'detecciones',
            'retorno',
            'estado',
            'ahorro',
            'faltante',
            'gasto_det',
            'inversion',
            'porcentaje'
        ));
    }

    public function costos_form (){
        $user = auth()->user();

        // Buscar si el usuario ya tiene un registro de costo
        $costo = Costo::where('user_id', $user->id)->first();

        // Pasar el costo (o null) a la vista
        return view('site.costos.costo_form', compact('costo'));
}
    public function store(Request $request)
    {
        $user = auth()->user();

        // Verificar si ya tiene un registro
        if (Costo::where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Ya tienes un registro de costos.');
        }

        // Validación de los campos
        $request->validate([
            'gasto_deteccion' => 'required|numeric|min:0',
            'capital_inicial' => 'required|numeric|min:0',
        ]);

        // Crear nuevo registro
        Costo::create([
            'user_id' => $user->id,
            'gasto_deteccion' => $request->gasto_deteccion,
            'capital_inicial' => $request->capital_inicial,
        ]);

        return redirect()->back()->with('success', 'Costos registrados correctamente.');
    }
    public function update(Request $request, Costo $costo)
    {
        $user = auth()->user();

        // Verificar que el costo pertenezca al usuario
        if ($costo->user_id !== $user->id) {
            return redirect()->back()->with('error', 'No tienes permiso para editar este registro.');
        }

        // Validación
        $request->validate([
            'gasto_deteccion' => 'required|numeric|min:0',
            'capital_inicial' => 'required|numeric|min:0',
        ]);

        // Actualizar
        $costo->update([
            'gasto_deteccion' => $request->gasto_deteccion,
            'capital_inicial' => $request->capital_inicial,
        ]);

        return redirect()->back()->with('success', 'Costos actualizados correctamente.');
    }


}
