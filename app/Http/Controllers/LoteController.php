<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Sector;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    /**
     * Mostrar lista de lotes.
     */
    public function index()
    {
        // Traer todos los lotes con su sector relacionado
        $lotes = Lote::with('sector')->get();
        $sectores = Sector::all(); // Para seleccionar sector al crear/editar

        return view('site.gestion_lotes.lotes', compact('lotes', 'sectores'));
    }

    /**
     * Guardar un nuevo lote.
     */
    public function store(Request $request)
    {
        $request->validate([
            'raza' => 'required|string',
            'cantidad_pollos' => 'required|integer|min:0',
            'edad_dias' => 'required|integer|min:0',
            'etapa' => 'required|string',
            'sector_id' => 'required|exists:sectores,id',
            'fecha_ingreso' => 'required|date',
        ]);

        Lote::create($request->all());

        return redirect()->route('lotes.index')
            ->with('success', 'Lote creado correctamente.');
    }

    /**
     * Actualizar un lote.
     */
    public function update(Request $request, Lote $lote)
    {
        $request->validate([
            'raza' => 'required|string',
            'cantidad_pollos' => 'required|integer|min:0',
            'edad_dias' => 'required|integer|min:0',
            'etapa' => 'required|string',
            'sector_id' => 'required|exists:sectores,id',
            'fecha_ingreso' => 'required|date',
        ]);

        $lote->update($request->only('raza', 'cantidad_pollos', 'edad_dias', 'etapa', 'sector_id', 'fecha_ingreso'));

        return redirect()->route('lotes.index')
            ->with('success', 'Lote actualizado correctamente.');
    }
    /**
     * Eliminar un lote.
     */
    public function destroy(Lote $lote)
    {
        $lote->delete();

        return redirect()->route('lotes.index')
            ->with('success', 'Lote eliminado correctamente.');
    }
}
