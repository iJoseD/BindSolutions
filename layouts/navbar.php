<?php session_start();
    $fullName = $_SESSION['fullName'];
?>
<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <img src="/dist/img/logoBind.png" width="20%" alt="Logotipo">
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/" class="nav-link px-2 text-white">Dashboard</a></li>
                <li><a href="/productos" class="nav-link px-2 text-white">Productos</a></li>
                <li><a href="/eventos" class="nav-link px-2 text-white">Eventos</a></li>
                <li><a href="/puntos-de-venta" class="nav-link px-2 text-white">Puntos de Venta</a></li>
                <li><a href="/usuarios" class="nav-link px-2 text-white">Usuarios</a></li>
            </ul>

            <div class="text-end">
                <span class="btn btn-outline-light me-2">Hola, <?php echo $fullName; ?></span>
                <button type="button" class="btn btn-warning">Cerrar sesión</button>
            </div>
        </div>
    </div>
</header>