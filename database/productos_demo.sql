
-- =====================================================
-- PorongComercio
-- Funcionalidad: Productos de demostración
-- Descripción: Añade cuatro productos para demostrar
--              el filtrado por categorías.
-- =====================================================

-- 1. Insertar productos si todavía no existen

INSERT INTO productos
    (referencia, nombre, precio, precio_rebajado, descripcion, valoracion)

SELECT
    nuevos.referencia,
    nuevos.nombre,
    nuevos.precio,
    nuevos.precio_rebajado,
    nuevos.descripcion,
    nuevos.valoracion

FROM (
    SELECT
        'TEC-005' AS referencia,
        'Webcam Full HD 1080p' AS nombre,
        39.99 AS precio,
        NULL AS precio_rebajado,
        'Webcam Full HD con resolución 1080p, ideal para videollamadas y reuniones.' AS descripcion,
        4 AS valoracion

    UNION ALL

    SELECT
        'TEC-006',
        'Alfombrilla Gaming XL',
        19.99,
        NULL,
        'Alfombrilla de gran tamaño para teclado y ratón, con superficie antideslizante.',
        5

    UNION ALL

    SELECT
        'TEC-007',
        'Lámpara LED de Escritorio',
        27.50,
        22.99,
        'Lámpara LED de escritorio con iluminación regulable, ideal para estudiar y trabajar.',
        4

    UNION ALL

    SELECT
        'TEC-008',
        'Hub USB-C 7 en 1',
        44.90,
        NULL,
        'Adaptador USB-C multipuerto con siete conexiones para ampliar la conectividad del portátil.',
        5
) AS nuevos

WHERE NOT EXISTS (
    SELECT 1
    FROM productos p
    WHERE p.referencia = nuevos.referencia
);


-- 2. Relacionar los nuevos productos con sus categorías

-- Webcam: Electrónica y Periféricos
INSERT IGNORE INTO producto_categoria (id_producto, id_categoria)
SELECT p.id, c.id
FROM productos p
INNER JOIN categorias c
    ON c.nombre IN ('Electrónica', 'Periféricos')
WHERE p.referencia = 'TEC-005';


-- Alfombrilla: Periféricos y Accesorios
INSERT IGNORE INTO producto_categoria (id_producto, id_categoria)
SELECT p.id, c.id
FROM productos p
INNER JOIN categorias c
    ON c.nombre IN ('Periféricos', 'Accesorios')
WHERE p.referencia = 'TEC-006';


-- Lámpara: Oficina y Accesorios
INSERT IGNORE INTO producto_categoria (id_producto, id_categoria)
SELECT p.id, c.id
FROM productos p
INNER JOIN categorias c
    ON c.nombre IN ('Oficina', 'Accesorios')
WHERE p.referencia = 'TEC-007';


-- Hub USB-C: Electrónica, Periféricos y Accesorios
INSERT IGNORE INTO producto_categoria (id_producto, id_categoria)
SELECT p.id, c.id
FROM productos p
INNER JOIN categorias c
    ON c.nombre IN ('Electrónica', 'Periféricos', 'Accesorios')
WHERE p.referencia = 'TEC-008';
