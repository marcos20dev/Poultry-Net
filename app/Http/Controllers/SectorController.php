<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function loteDetalle(Sector $sector)
    {
        $lotes = $sector->lotes()->get(); // Relación one-to-many en Sector
        return view('site.gestion_lotes.lote-detalle', compact('sector', 'lotes'));
    }

    public function index(Request $request)
    {
        $query = Sector::query();

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



    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:sectores,nombre',
            'temperatura' => 'required',
            'descripcion' => 'nullable',
        ]);

        Sector::create($request->all());

        return redirect()->route('sectores.index')
            ->with('success', 'Sector creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sector $sector)
    {
        $request->validate([
            'nombre' => 'required|unique:sectores,nombre,' . $sector->id,
            'temperatura' => 'required|numeric',
            'descripcion' => 'nullable|string',
        ]);

        $sector->update($request->only('nombre', 'temperatura', 'descripcion'));

        return redirect()->route('sectores.index')
            ->with('success', 'Sector actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector)
    {
        $sector->delete();

        return redirect()->route('sectores.index')
            ->with('success', 'Sector eliminado correctamente.');
    }
}
