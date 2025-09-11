# Poultry Net – Estructura de Base de Datos

## Usuarios (users)

| **id** | **name** | **email** | **password** | **role** | **created_at** | **updated_at** |
|--------|----------|-----------|--------------|----------|----------------|----------------|
| 1 | Marcos Ruiz | marcosruiztandaypan@gmail.com | hashed_password | administrador | 2025-01-01 08:00 | 2025-01-01 08:00 |
| 2 | Ana López | ana.lopez@example.com | hashed_password | granjero | 2025-01-05 09:30 | 2025-01-05 09:30 |

-----

## Sectores (sectores)

| **id** | **nombre** | **temperatura** | **descripcion** | **created_at** | **updated_at** |
|--------|------------|-----------------|-----------------|----------------|----------------|
| 1 | Sector Norte | 32°C | Área principal de crianza | 2025-01-01 08:05 | 2025-01-01 08:05 |
| 2 | Sector Sur | 30°C | Área secundaria | 2025-01-01 08:10 | 2025-01-01 08:10 |

-----

## Lotes (lotes)

| **id** | **sector_id** | **cantidad_pollos** | **edad_dias** | **etapa** | **raza** | **fecha_ingreso** | **created_at** | **updated_at** |
|--------|---------------|---------------------|---------------|-----------|----------|-------------------|----------------|----------------|
| 1 | 1 | 1000 | 1 | Inicio | Ross 308 | 2025-01-02 | 2025-01-02 08:00 | 2025-01-02 08:00 |
| 2 | 1 | 800 | 15 | Intermedio | Cobb 500 | 2025-01-03 | 2025-01-03 08:00 | 2025-01-03 08:00 |
| 3 | 2 | 500 | 1 | Inicio | Ross 308 | 2025-01-04 | 2025-01-04 09:00 | 2025-01-04 09:00 |

-----

## Detecciones (detecciones)

| **id** | **lote_id** | **sector_id** | **fecha** | **hora** | **descripcion** | **estado_pollos** | **created_at** | **updated_at** |
|--------|-------------|---------------|-----------|----------|-----------------|-------------------|----------------|----------------|
| 1 | 1 | 1 | 2025-01-05 | 08:30 | Revisión general | Inicio: 1000 | 2025-01-05 08:30 | 2025-01-05 08:30 |
| 2 | 1 | 1 | 2025-01-06 | 08:45 | Chequeo de crecimiento | Intermedio: 950 | 2025-01-06 08:45 | 2025-01-06 08:45 |
| 3 | 2 | 1 | 2025-01-06 | 09:00 | Control de alimentación | Intermedio: 800 | 2025-01-06 09:00 | 2025-01-06 09:00 |

-----

## Costos (costos)

| **id** | **lote_id** | **inversion_inicial** | **costo_por_deteccion** | **luz_mensual** | **otros_costos** | **created_at** | **updated_at** |
|--------|-------------|-----------------------|-------------------------|-----------------|------------------|----------------|----------------|
| 1 | 1 | 5000 | 10 | 150 | 50 | 2025-01-05 08:30 | 2025-01-05 08:30 |
| 2 | 2 | 4000 | 12 | 140 | 60 | 2025-01-06 09:00 | 2025-01-06 09:00 |
| 3 | 3 | 2500 | 8 | 100 | 30 | 2025-01-07 10:00 | 2025-01-07 10:00 |

-----

## Estados de Pollos (estados_pollos)

| **id** | **nombre** | **descripcion** | **created_at** | **updated_at** |
|--------|------------|-----------------|----------------|----------------|
| 1 | Inicio | Pollos recién ingresados | 2025-01-01 08:00 | 2025-01-01 08:00 |
| 2 | Intermedio | Pollos en etapa de crecimiento | 2025-01-01 08:05 | 2025-01-01 08:05 |
| 3 | Salida | Pollos listos para salida | 2025-01-01 08:10 | 2025-01-01 08:10 |

-----

## Alimentación (alimentacion)

| **id** | **lote_id** | **tipo_alimento** | **cantidad_kg** | **fecha** | **hora** | **created_at** | **updated_at** |
|--------|-------------|-------------------|-----------------|-----------|----------|----------------|----------------|
| 1 | 1 | Starter | 500 | 2025-01-02 | 08:00 | 2025-01-02 08:00 | 2025-01-02 08:00 |
| 2 | 1 | Grower | 400 | 2025-01-03 | 08:00 | 2025-01-03 08:00 | 2025-01-03 08:00 |
| 3 | 2 | Starter | 300 | 2025-01-04 | 09:00 | 2025-01-04 09:00 | 2025-01-04 09:00 |

-----

## Medicamentos (medicamentos)

| **id** | **lote_id** | **nombre** | **dosis** | **fecha** | **hora** | **created_at** | **updated_at** |
|--------|-------------|------------|-----------|-----------|----------|----------------|----------------|
| 1 | 1 | Antibiotico A | 50 mg/kg | 2025-01-02 | 08:00 | 2025-01-02 08:00 | 2025-01-02 08:00 |
| 2 | 1 | Vitaminas B | 30 mg/kg | 2025-01-03 | 08:00 | 2025-01-03 08:00 | 2025-01-03 08:00 |
| 3 | 2 | Desparasitario | 20 mg/kg | 2025-01-04 | 09:00 | 2025-01-04 09:00 | 2025-01-04 09:00 |
