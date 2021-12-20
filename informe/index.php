<!doctype html>
<html lang="en">
    <!-- Head -->
    <?php require_once('../dist/requireHead.php'); ?>

    <body>
        <!-- Navbar -->
        <?php
            if ( $rol == '4' ) {
                require_once('layouts/navbarVendedor.php');
            } else {
                require_once('layouts/navbar.php');
            }
        ?>

        <!-- Profile -->
        <?php require_once('../layouts/informe.php'); ?>

        <!-- Bootstrap Bundle with Popper -->
        <?php require_once('../dist/requireFooter.php'); ?>
    </body>
</html>