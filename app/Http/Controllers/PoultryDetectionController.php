<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PoultryDetectionController extends Controller
{
    private $confidenceThreshold = 0.75;

    public function showUploadForm()
    {
        return view('poultry.upload');
    }

    public function processImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        try {
            // Guardar imagen temporalmente
            $imagePath = $request->file('image')->store('temp', 'public');
            $fullImagePath = storage_path('app/public/' . $imagePath);

            // Ejecutar predicción
            $prediction = $this->runPrediction($fullImagePath);

            // Limpiar
            Storage::disk('public')->delete($imagePath);

            return response()->json([
                'success' => true,
                'prediction' => $prediction,
                'confidence_threshold' => $this->confidenceThreshold
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing image: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Error procesando la imagen: ' . $e->getMessage()
            ], 500);
        }
    }

    private function runPrediction($imagePath)
    {
        $modelDir = storage_path('app/models');
        $outputFile = tempnam(sys_get_temp_dir(), 'prediction_') . '.json';

        // Ejecutar Python
        $pythonScript = "$modelDir/predict.py";
        $command = "cd \"$modelDir\" && python \"$pythonScript\" \"$imagePath\" \"$outputFile\" 2>&1";

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \Exception("Error en modelo: " . implode("\n", $output));
        }

        if (!file_exists($outputFile)) {
            throw new \Exception("No se generaron resultados");
        }

        $result = json_decode(file_get_contents($outputFile), true);
        unlink($outputFile);

        // Añadir información de confianza
        foreach ($result['predictions'] as &$prediction) {
            $prediction['is_above_threshold'] = $prediction['confidence'] >= $this->confidenceThreshold;
        }

        $result['is_reliable'] = $result['max_confidence'] >= $this->confidenceThreshold;

        return $result;
    }
}
