<?php

// MySQLi
$servername = "localhost";
$username   = "app_bind";
$password   = "h_Af867w";
$dbname     = "app_bind";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Variables globales
$date = date('Y-m-d H:m:s');
$caso = $_POST['caso'];

// Eventos
$id     = $_POST['id'];
$nombre = $_POST['nombre'];

$fecha     = $_POST['fecha'];
$date      = date_create( $_POST['fecha'] );
$diaTexto  = date_format($date, "l");
$diaNumero = date_format($date, "d");
$mesTexto  = date_format($date, "M");
$anio      = date_format($date, "Y");
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

$lugar        = $_POST['lugar'];
$codigoEvento = $_POST['codigoEvento'];

// Evento
$idEvento   = $_POST['idEvento'];
$lote       = $_POST['lote'];
$idProducto = $_POST['idProducto'];
$cantidad   = $_POST['cantidad'];

$idPuntoVenta = $_POST['idPuntoVenta'];
$cantMesas    = $_POST['cantMesas'];

$idInventario = $_POST['idInventario'];

if ( $caso == 'crearEvento' ) {
    $sql = "INSERT INTO eventos (nombre, fecha, fechaFormato, lugar, codigoEvento, status, creationDate) VALUES ('$nombre', '$fecha', '$fechaFormato', '$lugar', '$codigoEvento', '1', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo 'event_created';
    } else {
        echo 'event_not_created';
    }

    $conn->close();

}