<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RunPythonModel extends Command
{
    protected $signature = 'model:predict {image}';
    protected $description = 'Ejecutar el modelo de Python para predecir';

    public function handle()
    {
        $imagePath = $this->argument('image');

        if (!file_exists($imagePath)) {
            $this->error("La imagen no existe: $imagePath");
            return 1;
        }

        // Directorio de modelos
        $modelDir = storage_path('app/models');
        $outputFile = tempnam(sys_get_temp_dir(), 'prediction_') . '.json';

        // Comando para ejecutar Python
        $pythonScript = "$modelDir/predict.py";
        $command = "cd \"$modelDir\" && python \"$pythonScript\" \"$imagePath\" \"$outputFile\" 2>&1";

        // Ejecutar comando
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            $this->error("Error ejecutando Python: " . implode("\n", $output));
            return 1;
        }

        // Leer resultado
        if (!file_exists($outputFile)) {
            $this->error("No se generó el archivo de resultados");
            return 1;
        }

        $result = json_decode(file_get_contents($outputFile), true);
        unlink($outputFile); // Limpiar

        $this->info(json_encode($result, JSON_PRETTY_PRINT));
        return 0;
    }
}
