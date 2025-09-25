<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoteController extends Controller
{
    /**
     * Mostrar lista de lotes solo del usuario autenticado.
     */
    public function index()
    {
        $userId = auth()->id();

        // Traer los lotes del usuario con su sector relacionado
        $lotes = Lote::with('sector')
            ->where('user_id', $userId)
            ->get();

        // Solo sectores del usuario autenticado
        $sectores = Sector::where('user_id', $userId)->get();

        return view('site.gestion_lotes.lotes', compact('lotes', 'sectores'));
    }


    public function detectar(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        try {
            $path = $request->file('imagen')->store('uploads', 'public');
            $fullPath = storage_path("app/public/$path");

            $imageData = base64_encode(file_get_contents($fullPath));

            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->post('https://serverless.roboflow.com/chicken-disease-detection-djh8g/5', [
                'api_key' => 'krzCiN6k9G6wZgpL6CI1',
                'image' => $imageData
            ]);

            $result = $response->json();

            if (!empty($result['predictions'])) {
                $firstPrediction = $result['predictions'][0];
                $formatted = [
                    'prediccion' => $firstPrediction['class'] ?? 'Desconocido',
                    'confianza' => isset($firstPrediction['confidence']) ? round($firstPrediction['confidence'] * 100, 2) : 0,
                    'imagen' => asset("storage/$path"),
                ];
            } else {
                $formatted = [
                    'error' => 'No se encontraron predicciones',
                    'imagen' => asset("storage/$path")
                ];
            }

            return response()->json($formatted);

        } catch (\Exception $e) {
            if (isset($fullPath) && file_exists($fullPath)) {
                unlink($fullPath);
            }
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Guardar un nuevo lote con user_id del usuario autenticado.
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

        $data = $request->all();
        $data['user_id'] = auth()->id(); // asignamos el user_id

        Lote::create($data);

        return redirect()->route('lotes.index')
            ->with('success', 'Lote creado correctamente.');
    }

    /**
     * Actualizar un lote (solo se permite si es del usuario autenticado).
     */
    public function update(Request $request, Lote $lote)
    {
        $this->authorize('update', $lote); // opcional: usa policy para seguridad

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
     * Eliminar un lote (solo se permite si es del usuario autenticado).
     */
    public function destroy(Lote $lote)
    {
        $this->authorize('delete', $lote); // opcional: usa policy para seguridad
        $lote->delete();

        return redirect()->route('lotes.index')
            ->with('success', 'Lote eliminado correctamente.');
    }
}
