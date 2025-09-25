<?php

namespace App\Http\Controllers;

use App\Models\RespuestaSatisfaccion;
use App\Models\Satisfaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SatisfaccionController extends Controller
{
    // Guardar feedback
    public function store(Request $request)
    {
        Log::info('✅ Store: request recibido', $request->all());

        $request->validate([
            'ratings' => 'required|array',
            'ratings.*' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        $userId = auth()->id();
        Log::info('User ID: ' . $userId);

        foreach ($request->ratings as $pregunta_id => $puntuacion) {
            Log::info('Guardando respuesta', ['pregunta_id' => $pregunta_id, 'puntuacion' => $puntuacion]);

            \App\Models\RespuestaSatisfaccion::create([
                'user_id' => $userId,
                'pregunta_id' => $pregunta_id,
                'puntuacion' => $puntuacion
            ]);
        }

        Log::info('Encuesta guardada correctamente');

        return response()->json([
            'message' => 'Encuesta guardada correctamente'
        ]);
    }

}
