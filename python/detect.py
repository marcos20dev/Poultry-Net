import sys
import json
import numpy as np
from PIL import Image
import tensorflow as tf
import traceback

def main():
    try:
        MODEL_PATH = "chicken_model.tflite"
        LABELS_PATH = "labels.txt"
        IMG_SIZE = (224, 224)

        # Verificar que los archivos existen
        import os
        if not os.path.exists(MODEL_PATH):
            print(json.dumps({
                "error": f"Modelo no encontrado: {MODEL_PATH}",
                "prediccion": "error",
                "confianza": 0
            }))
            return

        if not os.path.exists(LABELS_PATH):
            print(json.dumps({
                "error": f"Labels no encontrados: {LABELS_PATH}",
                "prediccion": "error",
                "confianza": 0
            }))
            return

        # Cargar labels
        with open(LABELS_PATH, "r") as f:
            labels = [line.strip() for line in f.readlines()]

        # Verificar argumentos
        if len(sys.argv) < 2:
            print(json.dumps({
                "error": "No se proporcionó ruta de imagen",
                "prediccion": "error",
                "confianza": 0
            }))
            return

        img_path = sys.argv[1]

        if not os.path.exists(img_path):
            print(json.dumps({
                "error": f"Imagen no encontrada: {img_path}",
                "prediccion": "error",
                "confianza": 0
            }))
            return

        # Procesar imagen
        image = Image.open(img_path).convert('RGB')
        image = image.resize(IMG_SIZE)
        image_array = np.array(image, dtype=np.float32)
        image_array = (image_array / 127.5) - 1.0
        image_array = np.expand_dims(image_array, axis=0)

        # Cargar y ejecutar modelo
        interpreter = tf.lite.Interpreter(model_path=MODEL_PATH)
        interpreter.allocate_tensors()

        input_details = interpreter.get_input_details()
        output_details = interpreter.get_output_details()

        interpreter.set_tensor(input_details[0]['index'], image_array)
        interpreter.invoke()

        output_data = interpreter.get_tensor(output_details[0]['index'])[0]
        pred_index = int(np.argmax(output_data))
        pred_conf = float(np.max(output_data))

        result = {
            "prediccion": labels[pred_index],
            "confianza": pred_conf
        }

        print(json.dumps(result))

    except Exception as e:
        error_info = {
            "error": str(e),
            "traceback": traceback.format_exc(),
            "prediccion": "error",
            "confianza": 0
        }
        print(json.dumps(error_info))

if __name__ == "__main__":
    main()
