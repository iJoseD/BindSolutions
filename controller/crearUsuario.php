<?php

include "../library/mcript.php";

// MySQLi
$servername = "localhost";
$username   = "app_bind";
$password   = "h_Af867w";
$dbname     = "app_bind";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Var
$caso       = $_POST['caso'];
$fullName   = $_POST['fullName'];
$user       = $_POST['user'];
$password   = $encriptar( $_POST['password'] );
$rol        = $_POST['rol'];
$date       = date('Y-m-d H:m:s');

if ( $caso == 'crearUsuario' ) {
    $sql = "INSERT INTO usuarios (fullName, user, password, rol, lastLogin) VALUES ('$fullName', '$user', '$password', '$rol', '$date')";
    
    if ($conn->query($sql) === TRUE) {
        echo 'user_created';
    } else {
        echo 'user_not_created';
    }

    $conn->close();
}