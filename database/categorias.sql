
-- =====================================================
-- PorongComercio
-- Funcionalidad: Categorías de productos
-- Descripción: Crea las tablas necesarias para clasificar
--              los productos mediante categorías.
-- =====================================================

-- 1. Crear tabla de categorías
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2. Crear tabla intermedia producto_categoria
-- Permite relacionar varios productos con varias categorías.

CREATE TABLE IF NOT EXISTS producto_categoria (
    id_producto INT(11) NOT NULL,
    id_categoria INT NOT NULL,

    PRIMARY KEY (id_producto, id_categoria),

    CONSTRAINT fk_producto_categoria_producto
        FOREIGN KEY (id_producto)
        REFERENCES productos(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_producto_categoria_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categorias(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 3. Insertar categorías iniciales
INSERT IGNORE INTO categorias (nombre) VALUES
('Electrónica'),
('Periféricos'),
('Accesorios'),
('Oficina');
