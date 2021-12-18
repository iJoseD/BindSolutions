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

} elseif ( $caso == 'addBodega' ) {
    $sql = "INSERT INTO inventario (idEvento, idProducto, lote, status, cantidad) VALUES ('$idEvento', '$idProducto', '$lote', 'Pending', '$cantidad')";

    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT p.nombre, i.cantidad
        FROM inventario i
        JOIN productos p ON i.idProducto = p.id
        WHERE lote = '$lote'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $totalFactura = 0;
            
            $html = '<div class="col-12">
                <h4>Productos agregados</h4>
                <ul class="list-group mt-3">';
                    while($row = $result->fetch_assoc()) {
                        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'. $row["nombre"] .'<span class="badge bg-secondary rounded-pill">'. $row['cantidad'] .' Und.</span></li>';
                    }
                $html .= '</ul>
            </div>';

            echo $html;
        }
    } else {
        echo 'inventario_not_created';
    }

    $conn->close();

} elseif ( $caso == 'agregarInventario' ) {
    $sql = "UPDATE inventario SET status = 'Approved' WHERE lote = '$lote'";

    if ($conn->query($sql) === TRUE) {
        echo 'agregarInventario_Update';
    } else {
        echo 'agregarInventario_not_Update';
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

} elseif ( $caso == 'addPuntos' ) {
    $sql = "INSERT INTO puntoVenta (nombre, cantMesas, lote, status, idEvento) VALUES ('$nombre', '$cantMesas', '$lote', 'Pending', '$idEvento')";

    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT * FROM puntoVenta WHERE lote = '$lote'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $totalFactura = 0;
            
            $html = '<div class="col-12">
                <h4>Zonas agregadas</h4>
                <ul class="list-group mt-3">';
                    while($row = $result->fetch_assoc()) {
                        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'. $row["nombre"] .'<span class="badge bg-secondary rounded-pill">'. $row['cantMesas'] .' Mesas</span></li>';
                    }
                $html .= '</ul>
            </div>';

            echo $html;
        }
    } else {
        echo 'puntoVenta_not_created';
    }

    $conn->close();
} elseif ( $caso == 'agregarPuntoVenta' ) {
    $sql = "UPDATE puntoVenta SET status = 'Approved' WHERE lote = '$lote'";

    if ($conn->query($sql) === TRUE) {
        echo 'agregarPuntoVenta_Update';
    } else {
        echo 'agregarPuntoVenta_not_Update';
    }

    $conn->close();

} elseif ( $caso == 'editarPuntoV' ) {
    $sql = "UPDATE puntoVenta SET nombre = '$nombre', cantMesas = '$cantMesas' WHERE id = $idPuntoVenta";

    if ($conn->query($sql) === TRUE) {
        echo 'editarPuntoV_UPDATE';
    } else {
        echo 'editarPuntoV_not_UPDATE';
    }

    $conn->close();

} elseif ( $caso == 'eliminarPuntoV' ) {
    $sql = "DELETE FROM puntoVenta WHERE id = '$idPuntoVenta'";

    if ($conn->query($sql) === TRUE) {
        echo 'eliminarInventario_DELETE';
    } else {
        echo 'eliminarInventario_not_DELETE';
    }

    $conn->close();

} elseif ( $caso == 'eliminarPuntoV2' ) {
    $sql = "DELETE FROM inventarioPuntoVenta WHERE idPuntoVenta = '$idPuntoVenta'";

    if ($conn->query($sql) === TRUE) {
        echo 'eliminarInventario_DELETE';
    } else {
        echo 'eliminarInventario_not_DELETE';
    }

    $conn->close();

} elseif ( $caso == 'infoCantidades' ) {
    $sql = "SELECT * FROM inventario WHERE idProducto = '$idProducto' AND idEvento = '$idEvento'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cantidadInventario = $row['cantidad'];
            
            $sql2 = "SELECT * FROM inventarioPuntoVenta WHERE idEvento = '$idEvento' AND idProducto = '$idProducto'";
            $result2 = $conn->query($sql2);

            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    $cantidad = $row2['cantidad'];
                }
            } else { $cantidad = 0; }

            $cantidadTotal = $cantidadInventario - $cantidad;

            $html = '<div class="col-12">
                <p>Este producto cuenta con <span class="badge bg-primary text-wrap">'. $cantidadTotal .'</span> unidades disponibles.</p>
            </div>';

            echo $html;
        }
    }

    $conn->close();

} elseif ( $caso == 'addSubBodega' ) {
    $sql = "INSERT INTO inventarioPuntoVenta (idPuntoVenta, idEvento, idProducto, cantidad, lote, status) VALUES ('$idPuntoVenta', '$idEvento', '$idProducto', '$cantidad', '$lote', 'Pending')";

    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT p.nombre, ipv.cantidad
        FROM inventarioPuntoVenta ipv
        JOIN productos p ON ipv.idProducto = p.id
        WHERE lote = '$lote'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $totalFactura = 0;
            
            $html = '<div class="col-12">
                <h4>Productos agregados</h4>
                <ul class="list-group mt-3">';
                    while($row = $result->fetch_assoc()) {
                        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'. $row["nombre"] .'<span class="badge bg-secondary rounded-pill">'. $row['cantidad'] .' Und.</span></li>';
                    }
                $html .= '</ul>
            </div>';

            echo $html;
        }
    } else {
        echo 'SubInventario_not_created';
    }

    $conn->close();

} elseif ( $caso == 'agregarSubInventario' ) {
    $sql = "UPDATE inventarioPuntoVenta SET status = 'Approved' WHERE lote = '$lote'";

    if ($conn->query($sql) === TRUE) {
        echo 'agregarSubInventario_Update';
    } else {
        echo 'agregarSubInventario_not_Update';
    }

    $conn->close();

} elseif ( $caso == 'editarSubInventario' ) {
    $sql = "UPDATE inventarioPuntoVenta SET cantidad = '$cantidad' WHERE id = $idInventario";

    if ($conn->query($sql) === TRUE) {
        echo 'editarSubInventario_UPDATE';
    } else {
        echo 'editarSubInventario_not_UPDATE';
    }

    $conn->close();

} elseif ( $caso == 'eliminarSubInventario' ) {
    $sql = "DELETE FROM inventarioPuntoVenta WHERE id = '$idInventario'";

    if ($conn->query($sql) === TRUE) {
        echo 'eliminarSubInventario_DELETE';
    } else {
        echo 'eliminarSubInventario_not_DELETE';
    }

    $conn->close();
}