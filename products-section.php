<?php

// Recogemos el tipo por si se accede de forma independiente, por defecto 'todos'
$tipo = $_GET['tipo'] ?? 'todos';

try {
  
    if ($tipo === 'populares') {
        $titulo_seccion = "Productos Más Populares";
        $sql = "SELECT id, referencia, nombre, precio, precio_rebajado, descripcion, valoracion, es_original, ranking_popular 
                FROM productos 
                WHERE ranking_popular IS NOT NULL 
                ORDER BY ranking_popular ASC 
                LIMIT 3";
    
    
    } elseif ($tipo === 'ofertas') {
        $titulo_seccion = "Productos en Oferta";
        $sql = "SELECT id, referencia, nombre, precio, precio_rebajado, descripcion, valoracion, ranking_popular 
                FROM productos 
                WHERE precio_rebajado IS NOT NULL AND precio_rebajado > 0";
    
    }else {
        $titulo_seccion = "Todos los productos";
        $sql = "SELECT id, referencia, nombre, precio, precio_rebajado, descripcion, valoracion, es_original, ranking_popular 
                FROM productos";
    }

    $productos = $conexion->query($sql);
} catch (PDOException $e) {
    die("Error al consultar productos: " . $e->getMessage());
}
?>
<!-- Related items section-->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4"><?= htmlspecialchars($titulo_seccion) ?></h2>
        <!-- 3. Contenedor HTML donde se renderizarán los productos -->
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php foreach ($productos as $producto): ?>
                <?php 
                    // Evaluamos si el producto está rebajado (si tiene un valor en precio_rebajado)
                    $esta_rebajado = !is_null($producto['precio_rebajado']) && $producto['precio_rebajado'] > 0;
                    // Redondeamos la valoración para pintar las estrellas enteras
                    $estrellas = round($producto['valoracion']);
                ?>
                
                <div class="col mb-5">
                    <div class="card h-100">
                        
                        <!-- Podio badge (Solo se muestra en la sección de populares) -->
                        <?php if ($tipo === 'populares' && !is_null($producto['ranking_popular'])): ?>
                            <?php 
                                $podio = [
                                    1 => ['texto' => '#1 Más Popular', 'clase' => 'bg-warning text-dark'],
                                    2 => ['texto' => '#2 Popular',     'clase' => 'bg-secondary text-white'],
                                    3 => ['texto' => '#3 Popular',     'clase' => 'bg-danger text-white']
                                ];
                                $puesto = (int)$producto['ranking_popular'];
                            ?>
                            <?php if (isset($podio[$puesto])): ?>
                                <div class="badge <?= $podio[$puesto]['clase'] ?> position-absolute" style="top: 0.5rem; left: 0.5rem">
                                    <?= $podio[$puesto]['texto'] ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- Sale badge (Solo se muestra si está rebajado) -->
                        <?php if ($esta_rebajado): ?>
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                        <?php endif; ?>
                        
                        <!-- Product image (De momento estática como tu ejemplo) -->
                        <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="<?= htmlspecialchars($producto['nombre']) ?>" />
                        
                        <!-- Product details -->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name -->
                                <h5 class="fw-bolder"><?= htmlspecialchars($producto['nombre']) ?></h5>
                                
                                <!-- Product reviews (Estrellas dinámicas usando Bootstrap Icons) -->
                                <div class="d-flex justify-content-center small text-warning mb-2">
                                    <?php 
                                    // Pintamos tantas estrellas rellenas como marque su valoración (máximo 5)
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $estrellas) {
                                            echo '<div class="bi-star-fill"></div>';
                                        } else {
                                            // Opcional: estrella vacía si no llega a la puntuación
                                            echo '<div class="bi-star"></div>'; 
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <!-- Product price -->
                                <?php if ($esta_rebajado): ?>
                                    <!-- Si está rebajado, muestra el precio original tachado y el de oferta -->
                                    <span class="text-muted text-decoration-line-through">$<?= number_format($producto['precio'], 2) ?></span>
                                    $<?= number_format($producto['precio_rebajado'], 2) ?>
                                <?php else: ?>
                                    <!-- Si no está rebajado, solo muestra el precio normal -->
                                    $<?= number_format($producto['precio'], 2) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Product actions -->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <!-- Pasamos el ID del producto por la URL para poder capturarlo en la página de detalles -->
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto" href="index.php?p=informacion-producto&id=<?= $producto['id'] ?>">
                                    Ver Producto
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>