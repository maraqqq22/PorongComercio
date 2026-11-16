<?php
try {
    // Consultar el productos de la ficha
    $stmt = $conexion->query("SELECT * FROM productos WHERE id=" . $idproducto);
    // Seleccionamos solo el primero
    $producto = $stmt->fetch_assoc();
} catch (PDOException $e) {
    die("Error al consultar productos: " . $e->getMessage());
}
?>
<?php
// Evaluamos si el producto está rebajado (si tiene un valor en precio_rebajado)
$esta_rebajado = !is_null($producto['precio_rebajado']) && $producto['precio_rebajado'] > 0;
// Redondeamos la valoración para pintar las estrellas enteras
$estrellas = round($producto['valoracion']);
?>
<!-- Product section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="https://dummyimage.com/600x700/dee2e6/6c757d.jpg" alt="..." /></div>
            <div class="col-md-6">
                <div class="small mb-1"><?= htmlspecialchars($producto['referencia']) ?></div>
                <h1 class="display-5 fw-bolder"><?= htmlspecialchars($producto['nombre']) ?></h1>
                <div class="fs-5 mb-5">
                    <!-- Product price -->
                    <?php if ($esta_rebajado): ?>
                        <!-- Si está rebajado, muestra el precio original tachado y el de oferta -->
                        <span class="text-decoration-line-through">$<?= number_format($producto['precio'], 2) ?></span>
                        <span>$<?= number_format($producto['precio_rebajado'], 2) ?></span>
                    <?php else: ?>
                        <!-- Si no está rebajado, solo muestra el precio normal -->
                        <span>$<?= number_format($producto['precio'], 2) ?></span>
                    <?php endif; ?>
                </div>
                <p class="lead"><?= htmlspecialchars($producto['descripcion']) ?></p>
                <div class="d-flex">
                    <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" />
                    <button class="btn btn-outline-dark flex-shrink-0" type="button">
                        <i class="bi-cart-fill me-1"></i>
                        Añadir al carrito
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>