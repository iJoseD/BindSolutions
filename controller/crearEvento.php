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

$fecha        = date_create( $_POST['fecha'] );
$diaTexto     = date_format($fecha, "l");
$diaNumero    = date_format($fecha, "d");
$mesTexto     = date_format($fecha, "M");
$anio         = date_format($fecha, "Y");
switch ( $diaTexto ) {
    case 'Monday'    : $diaTexto = "Lunes";     break;
    case 'Tuesday'   : $diaTexto = "Martes";    break;
    case 'Wednesday' : $diaTexto = "Miércoles"; break;
    case 'Thursday'  : $diaTexto = "Jueves";    break;
    case 'Friday'    : $diaTexto = "Viernes";   break;
    case 'Saturday'  : $diaTexto = "Sábado";    break;
    case 'Sunday'    : $diaTexto = "Domingo";   break;
}
switch ( $mesTexto ) {
    case 'Jan': $mesTexto = "Ene"; break;
    case 'Apr': $mesTexto = "Abr"; break;
    case 'Aug': $mesTexto = "Ago"; break;
    case 'Dec': $mesTexto = "Dic"; break;
}
$fechaFormato = $diaTexto . ', ' . $diaNumero . ' ' . $mesTexto . ' ' . $anio;

$lugar      = $_POST['lugar'];
$linkSocio  = $_POST['linkSocio'];
$date       = date('Y-m-d H:m:s');

if ( $caso == 'crearEvento' ) {
    $sql = "INSERT INTO eventos (nombre, fecha, lugar, linkSocio, status, creationDate) VALUES ('$nombre', '$fechaFormato', '$lugar', '$linkSocio', '1', '$date')";
    
    if ($conn->query($sql) === TRUE) {
        echo 'event_created';
    } else {
        echo 'event_not_created';
    }

    $conn->close();

} elseif ( $caso == 'editarEvento' ) {
    $sql = "UPDATE productos SET nombre = '$nombre', fecha = '$fechaFormato', lugar = '$lugar', linkSocio = '$linkSocio' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo 'event_edit';
    } else {
        echo 'event_not_edit';
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