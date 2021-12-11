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

if ( $caso == 'crearEvento' ) {
    $sql = "INSERT INTO ventas (idUser, idEvento, idPuntoVenta, codeFac, idProducto, cantidad, status, date) VALUES ('$idUser', '$idEvento', '$idPuntoVenta', '$codeFac', '$idProducto', '$cantidad', '$status', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo 'nuevaVenta_created';
    } else {
        echo 'nuevaVenta_not_created';
    }

    $conn->close();

}