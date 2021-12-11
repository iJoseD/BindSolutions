<?php

// MySQLi
$servername = "localhost";
$username   = "app_bind";
$password   = "h_Af867w";
$dbname     = "app_bind";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Var
$caso         = $_POST['caso'];
$idUser       = $_POST['idUser'];
$idEvento     = $_POST['idEvento'];
$idPuntoVenta = $_POST['idPuntoVenta'];
$codeFac      = $_POST['codeFac'];
$idProducto   = $_POST['idProducto'];
$cantidad     = $_POST['cantidad'];
$status       = $_POST['status'];
$date         = date('Y-m-d H:m:s');

if ( $caso == 'nuevaVenta' ) {
    $sql = "INSERT INTO ventas (idUser, idEvento, idPuntoVenta, codeFac, idProducto, cantidad, status, date) VALUES ('$idUser', '$idEvento', '$idPuntoVenta', '$codeFac', '$idProducto', '$cantidad', '$status', '$date')";

    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT p.nombre, p.precioPublico, v.cantidad
        FROM ventas v
        JOIN productos p ON v.idProducto = p.id
        WHERE codeFac = '$codeFac'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $html = '<ul class="list-group">';
                while($row = $result->fetch_assoc()) {
                    $precioPublico = str_replace( '.', '', $row['precioPublico'] );
                    $cantidad = $row["cantidad"];
                    $totalVenta = $precioPublico * $cantidad;

                    $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'. $row["nombre"] .'<span class="badge bg-primary rounded-pill">$ '. number_format( $totalVenta, 0, ',', '.' ) .'</span></li>';
                }
            $html .= '</ul>';

            echo $html;
        }
    } else {
        echo 'nuevaVenta_not_created';
    }

    $conn->close();

}