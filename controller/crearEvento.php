<?php

// MySQLi
$servername = "localhost";
$username   = "app_bind";
$password   = "h_Af867w";
$dbname     = "app_bind";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Var
$caso       = $_POST['caso'];
$id         = $_POST['id'];
$nombre     = $_POST['nombre'];
$fecha      = $_POST['fecha'];
$lugar      = $_POST['lugar'];
$linkSocio  = $_POST['linkSocio'];
$date       = date('Y-m-d H:m:s');

if ( $caso == 'crearEvento' ) {
    $sql = "INSERT INTO eventos (nombre, fecha, lugar, linkSocio, status, creationDate) VALUES ('$nombre', '$fecha', '$lugar', '$linkSocio', '1', '$date')";
    
    if ($conn->query($sql) === TRUE) {
        echo 'event_created';
    } else {
        echo 'event_not_created';
    }

    $conn->close();

} elseif ( $caso == 'editarProducto' ) {
    $sql = "UPDATE productos SET nombre = '$nombre', costo = '$costo', precioPublico = '$precioPublico' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo 'product_edit';
    } else {
        echo 'product_not_edit';
    }

    $conn->close();

} elseif ( $caso == 'eliminarProducto' ) {
    $sql = "UPDATE productos SET status = '0' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo 'product_deleted';
    } else {
        echo 'product_not_deleted';
    }

    $conn->close();
}