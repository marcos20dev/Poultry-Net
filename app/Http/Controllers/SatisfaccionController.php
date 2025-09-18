<?php

namespace App\Http\Controllers;

use App\Models\Satisfaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SatisfaccionController extends Controller
{
    // Guardar feedback
    public function store(Request $request)
    {
        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
        ]);

        Satisfaccion::create([
            'user_id' => Auth::id(),
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);

        return back()->with('success', '¡Gracias por tu retroalimentación!');
    }

    // Mostrar promedio general (ejemplo para dashboard)
    public function promedio()
    {
        $promedio = Satisfaccion::avg('puntuacion');
        $total = Satisfaccion::count();

        return view('dashboard', compact('promedio', 'total'));
    }
}
