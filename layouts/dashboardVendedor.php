<?php session_start();
    $fullName     = $_SESSION['fullName'];
    $idEvento     = $_SESSION['idEvento'];
    $idPuntoVenta = $_SESSION['idPuntoVenta'];

    // MySQLi
    $servername = "localhost";
    $username   = "app_bind";
    $password   = "h_Af867w";
    $dbname     = "app_bind";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    $sql = "SELECT * FROM eventos WHERE id = '$idEvento'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $nombreEvento = $row['nombre'];
        }
    }

    $sql2 = "SELECT * FROM puntoVenta WHERE id = '$idPuntoVenta'";
    $result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        while($row = $result2->fetch_assoc()) {
            $nombrePuntoVenta = $row['nombre'];
        }
    }
?>

<section class="container">
    <div class="row mt-5">
        <div class="col-12">
            <h2>Hola, <?php echo $fullName; ?></h2>
        </div>
        <div class="col-12 mt-3">
            <h4>Se te asigno el evento <span class="badge bg-primary"><?php echo $nombreEvento; ?></span> y estaras en el punto de venta <span class="badge bg-primary"><?php echo $nombrePuntoVenta; ?></span></h4>
        </div>
    </div>

    <div class="row mt-5">
        <h3 class="mb-5">Stock disponible en tu punto de venta</h3>
        <table class="DataTable display">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Unidades</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT p.imagen, p.nombre, p.precioPublico, ipv.cantidad
                    FROM inventarioPuntoVenta ipv
                    JOIN productos p ON ipv.idProducto = p.id
                    JOIN puntoVenta pv ON ipv.idPuntoVenta = pv.id
                    WHERE ipv.idEvento = '$idEvento' AND ipv.idPuntoVenta = '$idPuntoVenta'";
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $html = '<tr>';
                                $html .= '<th><img src="'. $row['imagen'] .'" alt="'. $row['nombre'] .'" class="imgProducto"></th>';
                                $html .= '<th>'. $row['nombre'] .'</th>';
                                $html .= '<th>'. $row['cantidad'] .'</th>';
                                $html .= '<th>$ '. $row['precioPublico'] .'</th>';
                            $html .= '</tr>';

                            echo $html;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</section>