<?php session_start(); $rol = $_SESSION['rol']; ?>

<!doctype html>
<html lang="en">
    <!-- Head -->
    <?php require_once('dist/requireHead.php'); ?>

    <!-- Bootstrap Bundle with Popper -->
    <?php require_once('dist/requireFooter.php'); ?>

    <body>
        <!-- Navbar -->
        <?php
            if ( $rol == '1' ) {
                require_once('layouts/navbar.php');
            } elseif ( $rol == '2' ) {
                require_once('layouts/navbarVendedor.php');
            }
        ?>

        <!-- Dashboard -->
        <?php
            if ( $rol == '1' ) {
                require_once('layouts/dashboard.php');
            } elseif ( $rol == '2' ) {
                require_once('layouts/dashboardVendedor.php');
            }
        ?>
    </body>
</html>