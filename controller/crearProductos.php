<?php

// MySQLi
$servername = "localhost";
$username   = "app_bind";
$password   = "h_Af867w";
$dbname     = "app_bind";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Var
$caso          = $_POST['caso'];
$id            = $_POST['id'];
$nombre        = $_POST['nombre'];
$costo         = $_POST['costo'];
$precioPublico = $_POST['precioPublico'];

if ( $caso == 'crearProductos' ) {
    $sql = "INSERT INTO productos (imagen, nombre, costo, precioPublico, status) VALUES ('', '$nombre', '$costo', '$precioPublico', '1')";
    
    if ($conn->query($sql) === TRUE) {
        echo 'product_created';
    } else {
        echo 'product_not_created';
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