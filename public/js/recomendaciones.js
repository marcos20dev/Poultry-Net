const recomendaciones = {
    "Healthy": ["Todo normal. Mantener higiene y control regular."],
    "Sano": ["Todo normal. Mantener higiene y control regular."],
    "Coccidiosis": [
        "Aplicar coccidiostáticos en el agua y mejorar higiene del galpón.",
        "Aumentar frecuencia de limpieza de bebederos y comederos.",
        "Mantener seco el suelo del galpón.",
        "Revisar temperatura y ventilación.",
        "Evitar sobrepoblación en el sector.",
        "Asegurar buena calidad del agua.",
        "Controlar insectos vectores.",
        "Vacunar aves jóvenes según protocolo.",
        "Revisar estado nutricional.",
        "Separar aves enfermas inmediatamente."
        // repetir/adaptar hasta tener 1000 recomendaciones distintas
    ]
};

// Función para obtener recomendaciones aleatorias
function obtenerRecomendaciones(enfermedad, cantidad = 5) {
    if (!recomendaciones[enfermedad]) return ["No hay recomendaciones disponibles para esta enfermedad."];
    const lista = recomendaciones[enfermedad];
    const resultado = [];
    for (let i = 0; i < cantidad; i++) {
        const aleatorio = lista[Math.floor(Math.random() * lista.length)];
        resultado.push(aleatorio);
    }
    return resultado;
}

export { obtenerRecomendaciones };
