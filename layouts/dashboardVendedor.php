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

<section class="container mb-5">
    <div class="row mt-5">
        <div class="col-xl-12 col-12">
            <h2>Hola, <?php echo $fullName; ?>!</h2>
        </div>
        <div class="col-12 mt-3">
            <h4>Se te asigno el evento <span class="badge bg-primary"><?php echo $nombreEvento; ?></span> y estaras en el punto de venta <span class="badge bg-primary"><?php echo $nombrePuntoVenta; ?></span></h4>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-xl-3 col-md-6 col-6 d-grid">
            <button type="button" class="btn btn-primary nuevaVenta" data-bs-toggle="modal" data-bs-target="#nuevaVenta" data-idEvento="<?php echo $idEvento; ?>" data-idPuntoVenta="<?php echo $idPuntoVenta; ?>" data-idUser="<?php echo $idUser; ?>">Generar nueva venta</button>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 mb-5"><h3>Stock disponible en tu punto de venta</h3></div>
        <div class="col-12">
            <table id="dashboardVendedor-table1" class="table table-striped table-sm">
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

                                $sql2 = "SELECT SUM(cantidad) AS cantidad FROM ventas WHERE idProducto = '$idProducto' GROUP BY idProducto";
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
            <table id="dashboardVendedor-table2" class="display responsive nowrap">
                <thead>
                    <tr>
                        <th>Factura</th>
                        <th>Productos vendidos</th>
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
                                    $html .= '<th>$ '. number_format( $row['total'], 0, ',', '.' ) .'</th>';
                                    $html .= '<th>
                                        <button type="button" class="btn btn-warning verFactura" data-bs-toggle="modal" data-bs-target="#verFactura" data-codeFac="'. $row['codeFac'] .'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-check" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2 mt-2 row alertaCantidad hide">
                    <div class="col-12 text-center">
                        <p class="badge bg-danger text-uppercase text-white">¡No tienes tantas unidades disponibles!</p>
                    </div>
                </div>
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
                                    $sql = "SELECT p.id, p.nombre, ipv.cantidad
                                    FROM inventarioPuntoVenta ipv
                                    JOIN productos p ON ipv.idProducto = p.id
                                    WHERE ipv.idEvento = '$idEvento' AND ipv.idPuntoVenta = '$idPuntoVenta'";
                                    
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $idProducto = $row['id'];
                                            $cantidadInventario = $row['cantidad'];

                                            $sql2 = "SELECT SUM(cantidad) AS cantidad FROM ventas WHERE idProducto = '$idProducto' GROUP BY idProducto";
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