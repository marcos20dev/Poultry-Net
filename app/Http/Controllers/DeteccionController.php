<?php

namespace App\Http\Controllers;

use App\Models\Deteccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeteccionController extends Controller
{
    // Mostrar historial de detecciones del usuario
    public function index()
    {
        $detecciones = Deteccion::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('detecciones.index', compact('detecciones'));
    }


    // Guardar nueva detección
    public function store(Request $request)
    {
        $data = $request->validate([
            'sector_id' => 'required|exists:sectores,id',
            'imagen' => 'required|file|mimes:jpg,jpeg,png,webp|max:10240', // hasta 10MB
            'enfermedad' => 'required|string|max:100',
            'confianza' => 'required|numeric',
            'tiempo_deteccion' => 'required|numeric',
            'observaciones' => 'nullable|string',
        ]);

        // Convertir a base64
        $file = $request->file('imagen');
        $fileData = file_get_contents($file->getRealPath());
        $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode($fileData);

        $deteccion = Deteccion::create([
            'user_id' => Auth::id(),
            'sector_id' => $data['sector_id'],
            'imagen_url' => $base64, // 👈 aquí queda el base64
            'enfermedad' => $data['enfermedad'],
            'confianza' => $data['confianza'],
            'tiempo_deteccion' => $data['tiempo_deteccion'],
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('sectores.lote_detalle', ['sector' => $data['sector_id']])
            ->with('success', 'Detección guardada correctamente ✅');
    }




    // Ver detalle de una detección
    public function show(Deteccion $deteccion)
    {
        return view('detecciones.show', compact('deteccion'));
    }
}
