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
$user       = $_POST['user'];
$password   = $encriptar( $_POST['password'] );
$date       = date('Y-m-d H:m:s');

if ( $caso == 'iniciarSesion' ) {
    $sql = "SELECT * FROM usuarios WHERE user = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ( $row['status'] == '1' ) {
                if ( $row['password'] == $password ) {
                    $sql = "UPDATE usuarios SET lastLogin = '$date' WHERE user = '$user'";

                    if ($conn->query($sql) === TRUE) {
                        session_start();
                        $_SESSION['id']           = $row['id'];
                        $_SESSION['fullName']     = $row['fullName'];
                        $_SESSION['user']         = $row['user'];
                        $_SESSION['rol']          = $row['rol'];
                        $_SESSION['idEvento']     = $row['idEvento'];
                        $_SESSION['idPuntoVenta'] = $row['idPuntoVenta'];

                        echo 'successful_login';
                    } else {
                        echo 'login_failed';
                    }
                } else {
                    echo 'password_incorrect';
                }
            } else {
                echo 'user_not_exist';
            }
        }
    } else {
        echo 'user_not_exist';
    }

    $conn->close();
}