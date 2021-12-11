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
$caso         = $_POST['caso'];
$fullName     = $_POST['fullName'];
$user         = $_POST['user'];
$password     = $encriptar( $_POST['password'] );
$rol          = $_POST['rol'];
$date         = date('Y-m-d H:m:s');
$idEvento     = $_POST['idEvento'];
$idPuntoVenta = $_POST['idPuntoVenta'];

if ( $caso == 'crearUsuario' ) {
    $sql = "INSERT INTO usuarios (fullName, user, password, rol, idEvento, idPuntoVenta, status, lastLogin) VALUES ('$fullName', '$user', '$password', '$rol', '$idEvento', '$idPuntoVenta', '1', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo 'user_created';
    } else {
        echo 'user_not_created';
    }

    $conn->close();

} elseif ( $caso == 'editarUsuario' ) {
    $sql = "UPDATE usuarios SET fullName = '$fullName', password = '$password', rol = '$rol' WHERE user = '$user'";

    if ($conn->query($sql) === TRUE) {
        echo 'user_created';
    } else {
        echo 'user_not_created';
    }

    $conn->close();

} elseif ( $caso == 'eliminarUsuario' ) {
    $sql = "UPDATE usuarios SET status = '0' WHERE user = '$user'";

    if ($conn->query($sql) === TRUE) {
        echo 'successful_login';
    } else {
        echo 'login_failed';
    }

    $conn->close();
} elseif ( $caso == 'SelectPuntoVenta' ) {
    $sql = "SELECT * FROM puntoVenta WHERE idEvento = '$idEvento'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $html = '<option selected>---</option>';
        
        while($row = $result->fetch_assoc()) {
            $html .= '<option value="'. $row['id'] .'">'. $row['nombre'] .'</option>';
        }

        echo $html;
    }

    $conn->close();

}