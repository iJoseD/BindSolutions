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
$totalFactura = $_POST['totalFactura'];
$date         = date('Y-m-d H:m:s');

if ( $caso == 'nuevaVenta' ) {
    $sql = "INSERT INTO ventas (idUser, idEvento, idPuntoVenta, codeFac, idProducto, cantidad, status, date) VALUES ('$idUser', '$idEvento', '$idPuntoVenta', '$codeFac', '$idProducto', '$cantidad', '$status', '$date')";

    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT p.nombre, p.precioPublico, v.cantidad
        FROM ventas v
        JOIN productos p ON v.idProducto = p.id
        WHERE codeFac = '$codeFac'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $totalFactura = 0;

            $html = '<div class="col-12">
                <h4>Productos agregados</h4>
                <ul class="list-group mt-3">';
                    while($row = $result->fetch_assoc()) {
                        $precioPublico = str_replace( '.', '', $row['precioPublico'] );
                        $cantidad = $row["cantidad"];
                        $totalVenta = $precioPublico * $cantidad;
                        $totalFactura = $totalFactura + $totalVenta;

                        $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'. $row["nombre"] .'<span class="badge bg-secondary rounded-pill">$ '. number_format( $totalVenta, 0, ',', '.' ) .'</span></li>';
                    }
                $html .= '</ul>

                <ul class="list-group mt-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold text-uppercase totalFactura" data-totalFactura="'. $totalFactura .'">Total a pagar<span class="badge bg-success rounded-pill">$ '. number_format( $totalFactura, 0, ',', '.' ) .'</span></li>
                </ul>
            </div>';

            echo $html;
        }
    } else {
        echo 'nuevaVenta_not_created';
    }

    $conn->close();

} elseif ( $caso == 'finalizarPedido' ) {
    $sql = "UPDATE ventas SET status = '$status' WHERE codeFac = '$codeFac'";

    if ($conn->query($sql) === TRUE) {
        echo 'finalizarPedido_Update';
    } else {
        echo 'finalizarPedido_not_Update';
    }

    $conn->close();

} elseif ( $caso == 'totalFactura' ) {
    $sql = "INSERT INTO totalFactura (codeFac, total) VALUES ('$codeFac', '$totalFactura')";

    if ($conn->query($sql) === TRUE) {
        echo 'totalFactura_created';
    } else {
        echo 'totalFactura_not_created';
    }

    $conn->close();

} elseif ( $caso == 'verFactura' ) {
    $sql = "SELECT p.nombre, p.precioPublico, v.cantidad
    FROM ventas v
    JOIN productos p ON v.idProducto = p.id
    WHERE codeFac = '$codeFac'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $totalFactura = 0;

        $html = '<div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" colspan="2" class="fw-bold">Item</th>
                        <th scope="col" colspan="1" class="fw-bold">Cant.</th>
                        <th scope="col" colspan="1" class="fw-bold">V. Total</th>
                    </tr>
                </thead>
                <tbody>';
                    while($row = $result->fetch_assoc()) {
                        $precioPublico = str_replace( '.', '', $row['precioPublico'] );
                        $cantidad = $row["cantidad"];
                        $totalVenta = $precioPublico * $cantidad;
                        $totalFactura = $totalFactura + $totalVenta;

                        $html .= '<tr>';
                            $html .= '<td colspan="2">'. $row["nombre"] .'</td>';
                            $html .= '<td colspan="1" class="text-center">'. $row["cantidad"] .'</td>';
                            $html .= '<td colspan="1" class="text-center">$ '. number_format( $totalVenta, 0, ',', '.' ) .'</td>';
                        $html .= '</tr>';
                    }
                $html .= '</tbody>
            </table>

            <ul class="list-group mt-4">
                <li class="list-group-item d-flex justify-content-between align-items-center fw-bold text-uppercase totalFactura" data-totalFactura="'. $totalFactura .'">Total pagado<span class="badge bg-success rounded-pill fs-6">$ '. number_format( $totalFactura, 0, ',', '.' ) .'</span></li>
            </ul>
        </div>';

        echo $html;
    } else {
        echo 'verFactura_not_Select';
    }

    $conn->close();

}