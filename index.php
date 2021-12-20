<?php session_start();
    
    $rol      = $_SESSION['rol'];
    $idEvento = $_SESSION['idEvento'];

    // MySQLi
    $servername = "localhost";
    $username   = "app_bind";
    $password   = "h_Af867w";
    $dbname     = "app_bind";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    
    $sql = "SELECT * FROM eventos WHERE id = '$idEvento'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $codigoEvento = $row['codigoEvento'];
        }
    }

    if ( $rol == 4 ) {
        header( 'location: /informe/?codigoEvento='.$codigoEvento );
    } else { ?>
        <!doctype html>
        <html lang="en">
            <!-- Head -->
            <?php require_once('dist/requireHead.php'); ?>

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
                        require_once('dist/requireFooter.php');
                        require_once('layouts/dashboard.php');
                    } elseif ( $rol == '2' ) {
                        require_once('layouts/dashboardVendedor.php');
                        require_once('dist/requireFooter.php');
                    }
                ?>
            </body>
        </html>
    <?php }
?>