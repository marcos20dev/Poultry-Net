<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectorController extends Controller
{
    public function loteDetalle(Sector $sector)
    {
        // Mostrar solo lotes del user logueado
        $lotes = $sector->lotes()
            ->where('user_id', auth()->id())
            ->get();

        return view('site.gestion_lotes.lote-detalle', compact('sector', 'lotes'));
    }

    public function index(Request $request)
    {
        $query = Sector::where('user_id', auth()->id()); // ✅ filtro por usuario

        // 🔍 Filtro búsqueda (nombre o descripción)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // 🌡️ Filtro temperatura
        if ($request->temp == 'low') {
            $query->where('temperatura', '<', 18);
        } elseif ($request->temp == 'normal') {
            $query->whereBetween('temperatura', [18, 25]);
        } elseif ($request->temp == 'high') {
            $query->where('temperatura', '>', 25);
        }

        // 📌 Ordenar resultados
        if ($request->sort == 'recent') {
            $query->latest();
        } elseif ($request->sort == 'oldest') {
            $query->oldest();
        } elseif ($request->sort == 'name') {
            $query->orderBy('nombre', 'asc');
        }

        // 📄 Paginación con filtros conservados
        $sectores = $query->paginate(12)->withQueryString();

        return view('site.gestion_sectores.sectores', compact('sectores'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                Rule::unique('sectores')->where(fn ($query) => $query->where('user_id', auth()->id())),
            ],
            'temperatura' => 'required|numeric',
            'descripcion' => 'nullable|string',
        ]);

        Sector::create([
            'nombre' => $request->nombre,
            'temperatura' => $request->temperatura,
            'descripcion' => $request->descripcion,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('sectores.index')
            ->with('success', 'Sector creado correctamente.');
    }


    public function update(Request $request, Sector $sector)
    {
        if ($sector->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'nombre' => [
                'required',
                Rule::unique('sectores')->ignore($sector->id)->where(fn ($query) => $query->where('user_id', auth()->id())),
            ],
            'temperatura' => 'required|numeric',
            'descripcion' => 'nullable|string',
        ]);

        $sector->update($request->only('nombre', 'temperatura', 'descripcion'));

        return redirect()->route('sectores.index')
            ->with('success', 'Sector actualizado correctamente.');
    }



    public function destroy(Sector $sector)
    {
        // ✅ asegurar que solo el dueño lo pueda eliminar
        if ($sector->user_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        $sector->delete();

        return redirect()->route('sectores.index')
            ->with('success', 'Sector eliminado correctamente.');
    }
}
