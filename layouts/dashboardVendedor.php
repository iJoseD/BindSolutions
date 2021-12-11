<?php session_start();
    $idUser       = $_SESSION['id'];
    $fullName     = $_SESSION['fullName'];
    $idEvento     = $_SESSION['idEvento'];
    $idPuntoVenta = $_SESSION['idPuntoVenta'];

    $codeFac = 'E' . $idEvento. 'PV' . $idPuntoVenta . 'FAC' . rand(1000, 9999);

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
        <div class="col-xl-12 col-12">
            <h2>Hola, <?php echo $fullName; ?>!</h2>
        </div>
        <div class="col-12 mt-3">
            <h4>Se te asigno el evento <span class="badge bg-primary"><?php echo $nombreEvento; ?></span> y estaras en el punto de venta <span class="badge bg-primary"><?php echo $nombrePuntoVenta; ?></span></h4>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-3 d-grid">
            <button type="button" class="btn btn-primary nuevaVenta" data-bs-toggle="modal" data-bs-target="#nuevaVenta" data-idEvento="<?php echo $idEvento; ?>" data-idPuntoVenta="<?php echo $idPuntoVenta; ?>" data-idUser="<?php echo $idUser; ?>">Generar nueva venta</button>
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

    <div class="row mt-5">
        <h3 class="mb-5">Ventas realizadas</h3>
        <table class="DataTable display">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Unidades vendidas</th>
                    <th>Total factura</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT v.codeFac, SUM(v.cantidad) AS 'cantidad', tf.total
                    FROM ventas v
                    JOIN productos p ON v.idProducto = p.id
                    JOIN totalFactura tf ON v.codeFac = tf.codeFac
                    WHERE v.idEvento = '$idEvento'
                    GROUP BY v.codeFac";
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $html = '<tr>';
                                $html .= '<th>'. $row['codeFac'] .'</th>';
                                $html .= '<th>'. $row['cantidad'] .'</th>';
                                $html .= '<th>$ 9.000</th>';
                                $html .= '<th>
                                    <button type="button" class="btn btn-warning verFactura" data-bs-toggle="modal" data-bs-target="#editarInventario" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'" data-cantidad="'. $row['cantidad'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                </th>';
                            $html .= '</tr>';

                            echo $html;
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Nueva venta -->
<div class="modal fade" id="nuevaVenta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="nuevaVentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevaVentaLabel">Nueva venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-3">
                            <label class="form-label">idUser</label>
                            <input type="text" name="nuevaVenta-idUser" id="nuevaVenta-idUser" class="form-control" readonly>
                        </div>
                        <div class="col-3">
                            <label class="form-label">idEvento</label>
                            <input type="text" name="nuevaVenta-idEvento" id="nuevaVenta-idEvento" class="form-control" readonly>
                        </div>
                        <div class="col-3">
                            <label class="form-label">idPuntoVenta</label>
                            <input type="text" name="nuevaVenta-idPuntoVenta" id="nuevaVenta-idPuntoVenta" class="form-control" readonly>
                        </div>
                        <div class="col-3">
                            <label class="form-label">codeFac</label>
                            <input type="text" name="nuevaVenta-codeFac" id="nuevaVenta-codeFac" class="form-control" value="<?php echo $codeFac; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-8">
                            <label class="form-label">Producto</label>
                            <select name="nuevaVenta-idProducto" id="nuevaVenta-idProducto" class="form-select">
                                <option selected>---</option>
                                <?php
                                    $sql = "SELECT p.id, p.nombre
                                    FROM inventarioPuntoVenta ipv
                                    JOIN productos p ON ipv.idProducto = p.id
                                    JOIN puntoVenta pv ON ipv.idPuntoVenta = pv.id
                                    WHERE ipv.idEvento = '$idEvento' AND ipv.idPuntoVenta = '$idPuntoVenta'
                                    ORDER BY p.nombre ASC";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<option value="'. $row['id'] .'">'. $row['nombre'] .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Cantidad</label>
                            <input type="text" name="nuevaVenta-cantidad" id="nuevaVenta-cantidad" class="form-control" placeholder="50">
                        </div>
                        <div class="col-12 mt-3 d-grid">
                            <button type="button" id="addCart" class="btn btn-warning fw-bold text-uppercase">Agregar al carrito</button>
                        </div>
                    </div>
                    <div class="row mt-3 preOrden"></div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Venta realizada correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-nuevaVenta" class="btn btn-primary">Finalizar pedido</button>
            </div>
        </div>
    </div>
</div>