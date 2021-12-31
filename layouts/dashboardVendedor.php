<?php session_start();
    $idUser       = $_SESSION['id'];
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

    $sql3 = "SELECT MAX(id) AS id FROM totalFactura";
    $result3 = $conn->query($sql3);

    if ($result3->num_rows > 0) {
        while($row = $result3->fetch_assoc()) {
            if ( !empty( $row['id'] ) ) { $maxID = $row['id'] + 1; } else { $maxID = '1'; }
            $codeFac = 'FAC-' . $idEvento . $idPuntoVenta . date("d") . date("m") . $maxID;
        }
    }
?>

<section class="container-fluid text-white text-center bgHeaderEvento">
    <div class="row">
        <div class="col-12">
            <h1 class="text-uppercase nombreEvento"><?php echo $nombreEvento; ?></h1>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <p class="fw-bolder text-uppercase"><?php echo $nombrePuntoVenta; ?></p>
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="row mt-5">
        <div class="col-xl-3 col-md-6 col-6 d-grid">
            <button type="button" class="btn bg-bind-1 fw-bold text-uppercase text-white nuevaVenta" data-bs-toggle="modal" data-bs-target="#nuevaVenta" data-bs-idEvento="<?php echo $idEvento; ?>" data-bs-idPuntoVenta="<?php echo $idPuntoVenta; ?>" data-bs-idUser="<?php echo $idUser; ?>">Generar nueva venta</button>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 mb-5"><h3>Stock disponible en tu punto de venta</h3></div>
        <div class="col-12">
            <table class="DataTable display responsive nowrap">
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
                        $sql = "SELECT p.id, p.imagen, p.nombre, p.precioPublico, ipv.cantidad
                        FROM inventarioPuntoVenta ipv
                        JOIN productos p ON ipv.idProducto = p.id
                        WHERE ipv.idEvento = '$idEvento' AND ipv.idPuntoVenta = '$idPuntoVenta'";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $idProducto = $row['id'];
                                $cantidadInventario = $row['cantidad'];

                                $sql2 = "SELECT SUM(cantidad) AS cantidad FROM ventas WHERE idEvento = '$idEvento' AND idPuntoVenta = '$idPuntoVenta' AND idProducto = '$idProducto' GROUP BY idProducto";
                                $result2 = $conn->query($sql2);

                                if ($result2->num_rows > 0) {
                                    while($row2 = $result2->fetch_assoc()) {
                                        $cantidad = $row2['cantidad'];
                                    }
                                } else { $cantidad = 0; }

                                $cantidadTotal = $cantidadInventario - $cantidad;

                                if ( $cantidadTotal == 0 ) { $class = 'bg-danger text-white'; } else { $class = ''; }

                                $html = '<tr class="'. $class .'">';
                                    $html .= '<th><img src="'. $row['imagen'] .'" alt="'. $row['nombre'] .'" class="imgProducto"></th>';
                                    $html .= '<th>'. $row['nombre'] .'</th>';
                                    $html .= '<th>'. $cantidadTotal .'</th>';
                                    $html .= '<th>$ '. $row['precioPublico'] .'</th>';
                                $html .= '</tr>';

                                echo $html;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 mb-5"><h3>Ventas realizadas</h3></div>
        <div class="col-12">
            <table class="DataTable display responsive nowrap">
                <thead>
                    <tr>
                        <th>Factura</th>
                        <th>Mesa</th>
                        <th>Mesero</th>
                        <th>Productos vendidos</th>
                        <th>Total factura</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT v.codeFac, v.mesa, u.fullName, SUM(v.cantidad) AS 'cantidad', tf.total
                        FROM ventas v
                        JOIN productos p ON v.idProducto = p.id
                        JOIN totalFactura tf ON v.codeFac = tf.codeFac
                        JOIN usuarios u ON v.mesero = u.id
                        WHERE v.idEvento = '$idEvento' AND v.idPuntoVenta = '$idPuntoVenta'
                        GROUP BY v.codeFac";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $html = '<tr>';
                                    $html .= '<th>'. $row['codeFac'] .'</th>';
                                    $html .= '<th>'. $row['mesa'] .'</th>';
                                    $html .= '<th>'. $row['fullName'] .'</th>';
                                    $html .= '<th>'. $row['cantidad'] .'</th>';
                                    $html .= '<th>$ '. number_format( $row['total'], 0, ',', '.' ) .'</th>';
                                    $html .= '<th>
                                        <button type="button" class="btn btn-success verFactura" data-bs-toggle="modal" data-bs-target="#verFactura" data-bs-codeFac="'. $row['codeFac'] .'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-danger editarFactura" data-bs-toggle="modal" data-bs-target="#editarFactura" data-bs-codeFac="'. $row['codeFac'] .'">
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
    </div>
</section>

<!-- Nueva venta -->
<div class="modal fade" id="nuevaVenta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="nuevaVentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevaVentaLabel">Nueva venta</h5>
            </div>
            <div class="modal-body">
                <div class="cortesia mb-5 mt-5">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-center">¿Esta es una venta de cortesía?</h4>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-lg btn-secondary fw-bold text-uppercase ventaCortesia" data-cortesia="Si">SI</button>
                        </div>
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-lg btn-success fw-bold text-uppercase ventaCortesia" data-cortesia="No">NO</button>
                        </div>
                    </div>
                </div>
                <div class="mb-2 mt-2 row alertaCantidad hide">
                    <div class="col-12 text-center">
                        <p class="badge bg-danger text-uppercase text-white">¡No tienes tantas unidades disponibles!</p>
                    </div>
                </div>
                <div class="formulario hide">
                    <div class="row hide">
                        <div class="col-4">
                            <label class="form-label">idUser</label>
                            <input type="text" name="nuevaVenta-idUser" id="nuevaVenta-idUser" class="form-control" readonly>
                        </div>
                        <div class="col-4">
                            <label class="form-label">idEvento</label>
                            <input type="text" name="nuevaVenta-idEvento" id="nuevaVenta-idEvento" class="form-control" readonly>
                        </div>
                        <div class="col-4">
                            <label class="form-label">idPuntoVenta</label>
                            <input type="text" name="nuevaVenta-idPuntoVenta" id="nuevaVenta-idPuntoVenta" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">codeFac</label>
                            <input type="text" name="nuevaVenta-codeFac" id="nuevaVenta-codeFac" class="form-control" value="<?php echo $codeFac; ?>" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">ventaCortesia</label>
                            <input type="text" name="nuevaVenta-ventaCortesia" id="nuevaVenta-ventaCortesia" class="form-control"readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Mesa</label>
                            <select name="nuevaVenta-Mesa" id="nuevaVenta-Mesa" class="form-select">
                                <option selected>---</option>
                                <?php
                                    $sql = "SELECT * FROM puntoVenta WHERE status = 'Approved' AND id = '$idPuntoVenta'";

                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $totalMesas = $row['cantMesas'];
                                            for ($i = 1; $i <= $totalMesas; $i++) {
                                                echo '<option value="Mesa '. $i .'">Mesa '. $i .'</option>';
                                            }
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Mesero</label>
                            <select name="nuevaVenta-Mesero" id="nuevaVenta-Mesero" class="form-select">
                                <option selected>---</option>
                                <?php
                                    $sql = "SELECT * FROM usuarios WHERE rol = '3' AND status = '1' AND idEvento = '$idEvento' AND idPuntoVenta = '$idPuntoVenta'";

                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<option value="'. $row['id'] .'">'. $row['fullName'] .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-8">
                            <label class="form-label">Producto</label>
                            <select name="nuevaVenta-idProducto" id="nuevaVenta-idProducto" class="form-select">
                                <option selected>---</option>
                                <?php
                                    $sql = "SELECT p.id, p.nombre, ipv.cantidad
                                    FROM inventarioPuntoVenta ipv
                                    JOIN productos p ON ipv.idProducto = p.id
                                    WHERE ipv.idEvento = '$idEvento' AND ipv.idPuntoVenta = '$idPuntoVenta'";

                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $idProducto = $row['id'];
                                            $cantidadInventario = $row['cantidad'];

                                            $sql2 = "SELECT SUM(cantidad) AS cantidad FROM ventas WHERE idEvento = '$idEvento' AND idPuntoVenta = '$idPuntoVenta' AND idProducto = '$idProducto' GROUP BY idProducto";
                                            $result2 = $conn->query($sql2);

                                            if ($result2->num_rows > 0) {
                                                while($row2 = $result2->fetch_assoc()) {
                                                    $cantidad = $row2['cantidad'];
                                                }
                                            } else { $cantidad = 0; }

                                            $cantidadTotal = $cantidadInventario - $cantidad;

                                            if ( $cantidadTotal == 0 ) { $class = 'bg-danger text-white'; } else { $class = ''; }

                                            echo '<option value="'. $row['id'] .'" data-cantidad="'. $cantidadTotal .'">'. $row['nombre'] .'</option>';
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
                    <div class="row mt-3 infoCantidades"></div>
                    <div class="row mt-5 mb-3 preOrden"></div>
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
                <button type="button" class="btn btn-secondary cerrarModal" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-nuevaVenta" class="btn btn-primary" disabled>Finalizar pedido</button>
            </div>
        </div>
    </div>
</div>

<!-- Ver venta -->
<div class="modal fade" id="verFactura" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verFacturaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verFacturaLabel">Factura <span class="codeFac badge bg-primary"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2 mt-2 row">
                    <div class="col-12 text-center">
                        <p class="badge bg-success text-uppercase text-white">Resumen de la venta</p>
                    </div>
                </div>
                <div class="formulario">
                    <div class="row mt-3 detalleFactura"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Ver venta -->
<div class="modal fade" id="editarFactura" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarFacturaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarFacturaLabel">Factura <span class="codeFac badge bg-primary"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="pin">
                    <div class="row">
                        <label class="col-3 col-form-label fw-bold text-uppercase">PIN DE SEGURIDAD</label>
                        <div class="col-7">
                            <input type="password" name="editarFactura-Pin" id="editarFactura-Pin" class="form-control form-control-lg fw-bold text-center" oninput="checkNumberFieldLength(this);">
                        </div>
                        <div class="col-2 d-grid">
                            <button type="button" id="validarPin" class="btn btn-lg bg-bind-1 fw-bold text-uppercase text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="detalleFactura hide">
                    <div class="mb-2 mt-2 row">
                        <div class="col-12 text-center">
                            <p class="badge bg-success text-uppercase text-white">Resumen de la venta</p>
                        </div>
                    </div>
                    <div class="row mt-3 data"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>