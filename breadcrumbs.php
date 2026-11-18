
<?php
/*
 * Componente de migas de pan.
 * Determina la ruta según la página que estamos visitando.
 */

$migas = [];

switch ($pagina) {

    case 'tienda':

        $migas = [
            ['nombre' => 'Inicio', 'url' => 'index.php'],
            ['nombre' => 'Tienda', 'url' => null]
        ];

        break;

    case 'contacta':

        $migas = [
            ['nombre' => 'Inicio', 'url' => 'index.php'],
            ['nombre' => 'Conócenos', 'url' => null]
        ];

        break;

    case 'solicitud-recibida':

        $migas = [
            ['nombre' => 'Inicio', 'url' => 'index.php'],
            ['nombre' => 'Conócenos', 'url' => 'index.php?p=contacta'],
            ['nombre' => 'Solicitud recibida', 'url' => null]
        ];

        break;

    case 'informacion-producto':

        $idValido = filter_var(
            $idproducto,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        $nombreProducto = 'Producto no encontrado';

        if ($idValido !== false) {

            $stmt = $conexion->prepare(
                "SELECT nombre FROM productos WHERE id = ?"
            );

            if ($stmt) {

                $stmt->bind_param("i", $idValido);
                $stmt->execute();

                // Recuperamos el nombre del producto.
                $stmt->bind_result($nombreEncontrado);

                if ($stmt->fetch()) {
                    $nombreProducto = $nombreEncontrado;
                }

                $stmt->close();
            }
        }

        $migas = [
            ['nombre' => 'Inicio', 'url' => 'index.php'],
            ['nombre' => 'Tienda', 'url' => 'index.php?p=tienda'],
            ['nombre' => $nombreProducto, 'url' => null]
        ];

        break;

    default:

        break;
}


if (!empty($migas)):
?>

<nav aria-label="breadcrumb" class="container px-4 px-lg-5 mt-4">

    <ol class="breadcrumb">

        <?php foreach ($migas as $miga): ?>

            <?php if ($miga['url'] !== null): ?>

                <li class="breadcrumb-item">
                    <a href="<?= htmlspecialchars($miga['url'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($miga['nombre'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </li>

            <?php else: ?>

                <li class="breadcrumb-item active" aria-current="page">
                    <?= htmlspecialchars($miga['nombre'], ENT_QUOTES, 'UTF-8') ?>
                </li>

            <?php endif; ?>

        <?php endforeach; ?>

    </ol>

</nav>

<?php endif; ?>
