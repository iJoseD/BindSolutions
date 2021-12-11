<?php session_start(); $rol = $_SESSION['rol']; ?>

<!doctype html>
<html lang="en">
    <!-- Head -->
    <?php require_once('dist/requireHead.php'); ?>

    <body id="dashboard">
        <!-- Navbar -->
        <?php require_once('layouts/navbar.php'); ?>

        <!-- Dashboard -->
        <?php
            if ( $rol == '1' ) {
                require_once('layouts/dashboard.php');
            } elseif ( $rol == '2' ) {
                require_once('layouts/dashboardVendedor.php');
            }
        ?>
        
        <!-- Bootstrap Bundle with Popper -->
        <?php require_once('dist/requireFooter.php'); ?>
    </body>
</html>