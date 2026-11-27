<!--
  Version   : 1.0
  Autor     : Gabriel S.
  Fecha     : 05 Octubre 2026
-->
<?php
$pagina = $_GET['p'] ?? null;
$idproducto = $_GET['id'] ?? null;
$tipo = $_GET['tipo'] ?? 'todos';  
// Conexión con la bbdd
require_once 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Item - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Mi Tienda</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link <?php if ($pagina != 'tienda') print 'active'; ?>" aria-current="page" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?p=contacta">Conócenos</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php if ($pagina == 'tienda') print 'active'; ?>" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Tienda</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?p=tienda">Todos los Productos</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="index.php?p=tienda&tipo=populares">Productos Populares</a></li>
                            <li><a class="dropdown-item" href="index.php?p=tienda&tipo=ofertas">Productos en Oferta</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Carrito
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <?php include 'breadcrumbs.php'; ?>
    
    <!-- Contenidos propios de la página-->
    <?php
    switch ($pagina) {
        case null:
            include 'presenta-shop.html';
            include 'products-section.php';
            break;
        case 'informacion-producto':
            include 'product-item.php';
            break;
        case 'tienda':
            include 'products-section.php';
            break;
        case 'contacta':
            include 'contact-us.html';
            break;
        case 'solicitud-recibida':
            include 'solicitud-recibida.html';
            break;
        default:
            //include 'error-404.html';
    }
    ?>
  
<!-- Footer -->
<footer class="bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container px-4 px-lg-5">
        <div class="row g-4">
            
            <!-- Columna 1: Conócenos -->
            <div class="col-lg-4 col-md-6">
                <h5 class="text-uppercase fw-bold mb-3">Conócenos</h5>
                <p class="text-white-50 small mb-4">
                    Tu tienda de confianza con los mejores productos seleccionados y ofertas exclusivas durante todo el año.
                </p>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                        Calle Principal 123, Madrid, España
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope-fill text-warning me-2"></i>
                        <a href="mailto:info@example.com" class="text-white text-decoration-none">info@example.com</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone-fill text-warning me-2"></i>
                        +012 345 67890
                    </li>
                </ul>
            </div>

            <!-- Columna 2: Inicio (Quick Shop) -->
            <div class="col-lg-2 col-md-6">
                <h5 class="text-uppercase fw-bold mb-3">Inicio</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="index.php" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="index.php?p=tienda" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Nuestra Tienda
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="index.php?p=tienda&tipo=populares" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Populares
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="index.php?p=tienda&tipo=ofertas" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Ofertas
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Carrito
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="index.php?p=contacta" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Contáctanos
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Columna 3: Mi Cuenta (Preparada para tu compañero) -->
            <div class="col-lg-3 col-md-6">
                <h5 class="text-uppercase fw-bold mb-3">Mi Cuenta</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Iniciar Sesión
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Registrarse
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Mi Perfil
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Mis Pedidos
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Finalizar Compra
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="index.php?p=contacta" class="text-white text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Soporte
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Columna 4: Trabaja con Nosotros y Síguenos -->
            <div class="col-lg-3 col-md-6">
                <h5 class="text-uppercase fw-bold mb-3">Trabaja con Nosotros</h5>
                <p class="text-white-50 small mb-3">
                    ¿Quieres formar parte de nuestro equipo? Envíanos tu candidatura y crece con nosotros.
                </p>
                <a href="index.php?p=contacta" class="btn btn-warning btn-sm fw-bold mb-4">
                    Enviar Currículum
                </a>

                <h6 class="text-uppercase fw-bold mb-3">Síguenos</h6>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-warning btn-square d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" aria-label="Twitter">
                        <i class="bi bi-twitter text-dark"></i>
                    </a>
                    <a href="#" class="btn btn-warning btn-square d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" aria-label="Facebook">
                        <i class="bi bi-facebook text-dark"></i>
                    </a>
                    <a href="#" class="btn btn-warning btn-square d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" aria-label="LinkedIn">
                        <i class="bi bi-linkedin text-dark"></i>
                    </a>
                    <a href="#" class="btn btn-warning btn-square d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" aria-label="Instagram">
                        <i class="bi bi-instagram text-dark"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Barra inferior: Copyright y Métodos de Pago -->
        <div class="row border-top border-secondary pt-4 mt-4 align-items-center">
            <div class="col-md-7 text-center text-md-start small text-white-50 mb-3 mb-md-0">
                <p class="mb-1">
                    Todos los derechos reservados. Copyright &copy; <span class="text-warning">Mi Tienda 2026</span>
                </p>
                <p class="mb-0">
                    Diseñado por: <span class="text-warning fw-semibold">PorongComercio</span>
                </p>
            </div>
            
           <!-- Métodos de pago (Visa, Mastercard, PayPal) -->
<div class="col-md-5 text-center text-md-end d-flex justify-content-center justify-content-md-end gap-2">
    <!-- Visa -->
    <span class="bg-white rounded px-2 py-1 d-inline-flex align-items-center" style="height: 30px;" title="Visa">
        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="14" viewBox="0 0 48 16">
            <text x="0" y="14" fill="#1434CB" font-family="Arial, sans-serif" font-weight="900" font-style="italic" font-size="16" letter-spacing="1">VISA</text>
        </svg>
    </span>

    <!-- Mastercard -->
    <span class="bg-white rounded px-2 py-1 d-inline-flex align-items-center" style="height: 30px;" title="Mastercard">
        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="20" viewBox="0 0 36 22">
            <circle cx="13" cy="11" r="9" fill="#EB001B"/>
            <circle cx="23" cy="11" r="9" fill="#F79E1B" fill-opacity="0.85"/>
        </svg>
    </span>

    <!-- PayPal -->
    <span class="bg-white rounded px-2 py-1 d-inline-flex align-items-center" style="height: 30px;" title="PayPal">
        <svg xmlns="http://www.w3.org/2000/svg" width="52" height="15" viewBox="0 0 60 16">
            <text x="0" y="13" fill="#003087" font-family="Arial, sans-serif" font-weight="900" font-style="italic" font-size="14">Pay<tspan fill="#0079C1">Pal</tspan></text>
        </svg>
    </span>
</div>
        </div>
    </div>
</footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

    <?php
    // Cerramos la conexión al final
    $conexion->close();
    ?>
</body>

</html>