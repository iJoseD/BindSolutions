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

$fecha        = $_POST['fecha'];
$date         = date_create( $_POST['fecha'] );
$diaTexto     = date_format($date, "l");
$diaNumero    = date_format($date, "d");
$mesTexto     = date_format($date, "M");
$anio         = date_format($date, "Y");
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
$date         = date('Y-m-d H:m:s');

// Variables inventario
$idInventario = $_POST['idInventario'];
$idEvento     = $_POST['idEvento'];
$idProducto   = $_POST['idProducto'];
$cantidad     = $_POST['cantidad'];

$nombrePV   = $_POST['nombrePV'];

if ( $caso == 'crearEvento' ) {
    $sql = "INSERT INTO eventos (nombre, fecha, fechaFormato, lugar, codigoEvento, status, creationDate) VALUES ('$nombre', '$fecha', '$fechaFormato', '$lugar', '$codigoEvento', '1', '$date')";
    
    if ($conn->query($sql) === TRUE) {
        echo 'event_created';
    } else {
        echo 'event_not_created';
    }

    $conn->close();

} elseif ( $caso == 'editarEvento' ) {
    $sql = "UPDATE eventos SET nombre = '$nombre', fecha = '$fecha', fechaFormato = '$fechaFormato', lugar = '$lugar', codigoEvento = '$codigoEvento' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo 'event_edit';
    } else {
        echo 'event_not_edit';
    }

    $conn->close();

} elseif ( $caso == 'eliminarEvento' ) {
    $sql = "UPDATE eventos SET status = '0' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo 'event_deleted';
    } else {
        echo 'event_not_deleted';
    }

    $conn->close();

} elseif ( $caso == 'mostrarPrecios' ) {
    $sql = "SELECT * FROM productos WHERE id = '$idProducto'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $html = '<div class="col-12">
                <p>Precio costo: <span class="badge bg-primary text-wrap">$ '. $row['costo'] .'</span> Precio público: <span class="badge bg-primary text-wrap">$ '. $row['precioPublico'] .'</span></p>
            </div>';

            echo $html;
        }
    }

    $conn->close();

} elseif ( $caso == 'agregarInventario' ) {
    $sql = "INSERT INTO inventario (idEvento, idProducto, cantidad) VALUES ('$idEvento', '$idProducto', '$cantidad')";
    
    if ($conn->query($sql) === TRUE) {
        echo 'inventario_created';
    } else {
        echo 'inventario_not_created';
    }

    $conn->close();

} elseif ( $caso == 'editarInventario' ) {
    $sql = "UPDATE inventario SET cantidad = '$cantidad' WHERE id = $idInventario";

    if ($conn->query($sql) === TRUE) {
        echo 'editarInventario_UPDATE';
    } else {
        echo 'editarInventario_not_UPDATE';
    }

    $conn->close();

} elseif ( $caso == 'eliminarInventario' ) {
    $sql = "DELETE FROM inventario WHERE id = '$idInventario'";

    if ($conn->query($sql) === TRUE) {
        echo 'eliminarInventario_DELETE';
    } else {
        echo 'eliminarInventario_not_DELETE';
    }

    $conn->close();

} elseif ( $caso == 'agregarPuntoVenta' ) {
    $sql = "INSERT INTO puntoVenta (nombre, idEvento) VALUES ('$nombrePV', '$idEvento')";
    
    if ($conn->query($sql) === TRUE) {
        echo 'puntoVenta_created';
    } else {
        echo 'puntoVenta_not_created';
    }

    $conn->close();
}