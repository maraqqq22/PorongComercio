
<?php
try {
    // 1. Obtener todas las categorías de la base de datos
    $consultaCategorias = $conexion->query(
        "SELECT id, nombre FROM categorias ORDER BY nombre"
    );

    $categorias = $consultaCategorias->fetch_all(MYSQLI_ASSOC);

    // 2. Comprobar si el usuario ha seleccionado una categoría
    $categoriaSeleccionada = filter_var(
        $_GET['categoria'] ?? null,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );

    // 3. Comprobar que la categoría seleccionada existe
    $nombreCategoria = null;

    if ($categoriaSeleccionada !== false && $categoriaSeleccionada !== null) {
        foreach ($categorias as $categoria) {
            if ((int)$categoria['id'] === $categoriaSeleccionada) {
                $nombreCategoria = $categoria['nombre'];
                break;
            }
        }
    }

    // 4. Consultar los productos según el filtro seleccionado
    if ($categoriaSeleccionada !== false && $categoriaSeleccionada !== null
        && $nombreCategoria !== null) {

        // Productos pertenecientes a la categoría seleccionada
        $stmt = $conexion->prepare(
            "SELECT p.id, p.referencia, p.nombre, p.precio,
                    p.precio_rebajado, p.descripcion, p.valoracion
             FROM productos p
             INNER JOIN producto_categoria pc
                ON p.id = pc.id_producto
             WHERE pc.id_categoria = ?
             ORDER BY p.id"
        );

        $stmt->bind_param("i", $categoriaSeleccionada);
        $stmt->execute();

        $productos = $stmt->get_result();

    } elseif (!isset($_GET['categoria'])) {

        // Si no se ha seleccionado ninguna categoría, mostrar todo
        $productos = $conexion->query(
            "SELECT id, referencia, nombre, precio,
                    precio_rebajado, descripcion, valoracion
             FROM productos
             ORDER BY id"
        );

    } else {

        // El identificador recibido no corresponde a una categoría válida
        $productos = null;
    }

} catch (mysqli_sql_exception $e) {
    die("Error al consultar los productos: " . $e->getMessage());
}
?>

<!-- Sección del catálogo -->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">

        <!-- Título del catálogo -->
        <h2 class="fw-bolder mb-4">
            <?php if ($nombreCategoria !== null): ?>
                <?= htmlspecialchars($nombreCategoria) ?>
            <?php else: ?>
                Todos los productos
            <?php endif; ?>
        </h2>

        <!-- 5. Filtros de categorías -->
        <div class="d-flex flex-wrap gap-2 mb-4">

            <!-- Mostrar todos los productos -->
            <a
                href="index.php?p=tienda"
                class="btn <?= $categoriaSeleccionada === false
                    || $categoriaSeleccionada === null
                    ? 'btn-dark' : 'btn-outline-dark' ?>">
                Todos
            </a>

            <!-- Mostrar un botón por cada categoría -->
            <?php foreach ($categorias as $categoria): ?>

                <a
                    href="index.php?p=tienda&categoria=<?= (int)$categoria['id'] ?>"
                    class="btn <?= $categoriaSeleccionada === (int)$categoria['id']
                        ? 'btn-dark' : 'btn-outline-dark' ?>">

                    <?= htmlspecialchars($categoria['nombre']) ?>

                </a>

            <?php endforeach; ?>

        </div>

        <!-- 6. Mostrar los productos -->
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php if ($productos === null || $productos->num_rows === 0): ?>

                <div class="col-12 text-center py-5">
                    <p class="lead">
                        No se han encontrado productos para esta categoría.
                    </p>
                    <a href="index.php?p=tienda" class="btn btn-outline-dark">
                        Ver todos los productos
                    </a>
                </div>

            <?php else: ?>

                <?php foreach ($productos as $producto): ?>

                    <?php
                        // Comprobar si el producto está rebajado
                        $esta_rebajado = !is_null($producto['precio_rebajado'])
                            && $producto['precio_rebajado'] > 0;

                        // Calcular las estrellas de valoración
                        $estrellas = max(0, min(5, (int)round($producto['valoracion'])));
                    ?>

                    <div class="col mb-5">
                        <div class="card h-100">

                            <!-- Etiqueta de oferta -->
                            <?php if ($esta_rebajado): ?>
                                <div class="badge bg-dark text-white position-absolute"
                                     style="top: 0.5rem; right: 0.5rem">
                                    Sale
                                </div>
                            <?php endif; ?>

                            <!-- Imagen del producto -->
                            <img
                                class="card-img-top"
                                src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg"
                                alt="<?= htmlspecialchars($producto['nombre']) ?>"
                            />

                            <!-- Información del producto -->
                            <div class="card-body p-4">
                                <div class="text-center">

                                    <!-- Nombre -->
                                    <h5 class="fw-bolder">
                                        <?= htmlspecialchars($producto['nombre']) ?>
                                    </h5>

                                    <!-- Valoración -->
                                    <div class="d-flex justify-content-center small text-warning mb-2">

                                        <?php for ($i = 1; $i <= 5; $i++): ?>

                                            <?php if ($i <= $estrellas): ?>
                                                <div class="bi-star-fill"></div>
                                            <?php else: ?>
                                                <div class="bi-star"></div>
                                            <?php endif; ?>

                                        <?php endfor; ?>

                                    </div>

                                    <!-- Precio -->
                                    <?php if ($esta_rebajado): ?>

                                        <span class="text-muted text-decoration-line-through">
                                            $<?= number_format($producto['precio'], 2) ?>
                                        </span>

                                        $<?= number_format($producto['precio_rebajado'], 2) ?>

                                    <?php else: ?>

                                        $<?= number_format($producto['precio'], 2) ?>

                                    <?php endif; ?>

                                </div>
                            </div>

                            <!-- Acciones del producto -->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">

                                    <a
                                        class="btn btn-outline-dark mt-auto"
                                        href="index.php?p=informacion-producto&id=<?= (int)$producto['id'] ?>">

                                        Ver Producto

                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </div>
</section>
