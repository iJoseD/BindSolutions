<?php
    $codigoEvento = $_GET['codigoEvento'];

    // MySQLi
    $servername = "localhost";
    $username   = "app_bind";
    $password   = "h_Af867w";
    $dbname     = "app_bind";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    $sql = "SELECT * FROM eventos WHERE codigoEvento = '$codigoEvento'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id           = $row['id'];
            $nombre       = $row['nombre'];
            $fechaFormato = $row['fechaFormato'];
            $lugar        = $row['lugar'];
        }
    }

    $lote = 'LOTE' . rand(1000, 9999);
?>

<section class="container-fluid text-white text-center bgHeaderEvento">
    <div class="row">
        <div class="col-12">
            <h1 class="text-uppercase nombreEvento"><?php echo $nombre; ?></h1>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <p class="fw-bolder text-uppercase"><?php echo $fechaFormato; ?> • <?php echo $lugar; ?></p>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-xl-4 col-md-12 col-12"></div>
        <div class="col-xl-2 col-md-6 col-6 d-grid">
            <button type="button" class="btn-dark gestionarEvento btn btn-outline-info fw-bold text-uppercase text-white">Gestionar</button>
        </div>
        <div class="col-xl-2 col-md-6 col-6 d-grid">
            <button type="button" class="btn-dark verInforme btn btn-outline-info fw-bold text-uppercase text-white">Informes</button>
        </div>
        <div class="col-xl-4 col-md-12 col-12"></div>
    </div>
</section>

<section class="s-gestionarEvento container mb-5">
    <div class="row mt-5">
        <div class="col-xl-3 col-md-6 col-6 d-grid">
            <button type="button" class="btn btn-primary agregarInventario" data-bs-toggle="modal" data-bs-target="#agregarInventario" data-bs-id="<?php echo $id; ?>" data-bs-nombre="<?php echo $nombre; ?>">Asignar inventario</button>
        </div>
        <div class="col-xl-3 col-md-6 col-6 d-grid">
            <button type="button" class="btn btn-primary agregarPuntoVenta" data-bs-toggle="modal" data-bs-target="#agregarPuntoVenta" data-bs-id="<?php echo $id; ?>" data-bs-nombre="<?php echo $nombre; ?>">Crear zona</button>
        </div>
    </div>

    <!-- Inventario disponible -->
    <div class="row mt-5">
        <h3 class="mb-5">Productos asignados</h3>
        <table class="DataTable display responsive nowrap">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio Público</th>
                    <th>Und. Asignadas</th>
                    <th>Und. Usadas</th>
                    <th>Und. Disponibles</th>
                    <th>Ganancia estimada</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT i.id, p.id AS idProducto, p.imagen, p.nombre, p.costo, p.precioPublico, i.cantidad FROM inventario i JOIN productos p ON i.idProducto = p.id WHERE i.idEvento = '$id' AND i.status = 'Approved'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {

                            $idProducto = $row['idProducto'];
                            $cantidadInventario = $row['cantidad'];

                            $ganancia = str_replace( '.', '', $row['precioPublico'] ) - str_replace( '.', '', $row['costo'] );
                            $ganancia = $ganancia * $row['cantidad'];

                            $sql2 = "SELECT SUM(cantidad) AS 'cantidad' FROM inventarioPuntoVenta WHERE idEvento = '$id' AND idProducto = '$idProducto'";
                            $result2 = $conn->query($sql2);

                            if ($result2->num_rows > 0) {
                                while($row2 = $result2->fetch_assoc()) {
                                    $cantidad = $row2['cantidad'];
                                }
                            } else { $cantidad = 0; }

                            $cantidadTotal = $cantidadInventario - $cantidad;

                            $html = '<tr>';
                                $html .= '<th><img src="'. $row['imagen'] .'" alt="'. $row['nombre'] .'" class="imgProducto"></th>';
                                $html .= '<th>'. $row['nombre'] .'</th>';
                                $html .= '<th>$ '. $row['precioPublico'] .'</th>';
                                $html .= '<th>'. $cantidadInventario .'</th>';
                                $html .= '<th>'. $cantidad .'</th>';
                                $html .= '<th>'. $cantidadTotal .'</th>';
                                $html .= '<th>$ '. number_format( $ganancia, 0, ',', '.' ) .'</th>';
                                $html .= '<th>
                                    <button type="button" class="btn btn-warning editarInventario" data-bs-toggle="modal" data-bs-target="#editarInventario" data-bs-id="'. $row['id'] .'" data-bs-nombre="'. $row['nombre'] .'" data-bs-cantidad="'. $row['cantidad'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger eliminarInventario" data-bs-toggle="modal" data-bs-target="#eliminarInventario" data-bs-id="'. $row['id'] .'" data-bs-nombre="'. $row['nombre'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
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

    <!-- Puntos de venta -->
    <div class="row mt-5">
        <h3 class="mb-5">Zonas de venta</h3>
        <div class="col-xl-6 col-md-12 col-12">
            <table class="DataTable display responsive nowrap">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cant. Mesas</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM puntoVenta WHERE idEvento = '$id' AND status = 'Approved'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $html = '<tr>';
                                    $html .= '<th>'. $row['nombre'] .'</th>';
                                    $html .= '<th>'. $row['cantMesas'] .'</th>';
                                    $html .= '<th>
                                        <button type="button" class="btn btn-success agregarSubInventario" data-bs-toggle="modal" data-bs-target="#agregarSubInventario" data-bs-idEvento="'. $id .'" data-bs-idPuntoVenta="'. $row['id'] .'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16">
                                                <path d="M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z"/>
                                                <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z"/>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-warning editarPuntoV" data-bs-toggle="modal" data-bs-target="#editarPuntoV" data-bs-id="'. $row['id'] .'" data-bs-nombre="'. $row['nombre'] .'" data-bs-cantMesas="'. $row['cantMesas'] .'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-danger eliminarPuntoV" data-bs-toggle="modal" data-bs-target="#eliminarPuntoV" data-bs-id="'. $row['id'] .'" data-bs-nombre="'. $row['nombre'] .'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
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

    <!-- Sub-inventario punto de venta -->
    <div class="row mt-5">
        <h3 class="mb-5">Productos por zona</h3>
        <table id="evento-table3" class="display responsive nowrap">
            <thead>
                <tr>
                    <th>Zona</th>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Unidades</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT p.id AS 'idProducto', pv.id AS 'idPuntoVenta', ipv.id, pv.nombre AS nombrePV, p.imagen, p.nombre, ipv.cantidad
                    FROM inventarioPuntoVenta ipv
                    JOIN productos p ON ipv.idProducto = p.id
                    JOIN puntoVenta pv ON ipv.idPuntoVenta = pv.id
                    WHERE ipv.idEvento = '$id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $idPuntoVenta       = $row['idPuntoVenta'];
                            $idProducto         = $row['idProducto'];
                            $cantidadInventario = $row['cantidad'];

                            $sql2 = "SELECT SUM(cantidad) AS cantidad FROM ventas WHERE idEvento = '$id' AND idPuntoVenta = '$idPuntoVenta' AND idProducto = '$idProducto' GROUP BY idProducto";
                            $result2 = $conn->query($sql2);

                            if ($result2->num_rows > 0) {
                                while($row2 = $result2->fetch_assoc()) {
                                    $cantidad = $row2['cantidad'];
                                }
                            } else { $cantidad = 0; }

                            $cantidadTotal = $cantidadInventario - $cantidad;

                            if ( $cantidadTotal == 0 ) { $class = 'bg-danger text-white'; } else { $class = ''; }

                            $html = '<tr class="'. $class .'">';
                                $html .= '<th>'. $row['nombrePV'] .'</th>';
                                $html .= '<th><img src="'. $row['imagen'] .'" alt="'. $row['nombre'] .'" class="imgProducto"></th>';
                                $html .= '<th>'. $row['nombre'] .'</th>';
                                $html .= '<th>'. $cantidadTotal .'</th>';
                                $html .= '<th>
                                    <button type="button" class="btn btn-warning editarSubInventario" data-bs-toggle="modal" data-bs-target="#editarSubInventario" data-bs-idEvento="'. $id .'" data-bs-idProducto="'. $row['idProducto'] .'" data-bs-id="'. $row['id'] .'" data-bs-nombre="'. $row['nombre'] .'" data-bs-cantidad="'. $row['cantidad'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger eliminarSubInventario" data-bs-toggle="modal" data-bs-target="#eliminarSubInventario" data-bs-id="'. $row['id'] .'" data-bs-nombre="'. $row['nombre'] .'" data-bs-nombrePV="'. $row['nombrePV'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
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

<section class="s-verInforme container mb-5">
    <div class="row mt-5">
        <div class="col-xl-4 col-md-6 col-12 d-grid">
            <div class="card mb-3 text-center text-white MoonlitAsteroid">
                <div class="card-body d-grid align-content-center">
                    <?php
                        $sql = "SELECT tf.codeFac, tf.total
                        FROM ventas v
                        JOIN totalFactura tf ON v.codeFac = tf.codeFac
                        WHERE v.idEvento = '$id'
                        GROUP BY v.codeFac";
                        $result = $conn->query($sql);

                        $totalVendido = 0;

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $totalVendido = $totalVendido + $row['total']; ?>
                            <?php }
                        }
                    ?>
                    <span style="font-size: 3em;font-weight: bolder;">$ <?php echo number_format( $totalVendido, 0, ',', '.' ); ?></span>
                </div>
                <div class="card-footer">
                    <div class="text-uppercase fw-bold">Total vendido</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-12 d-grid">
            <div class="card mb-3 text-center text-white DarkOcean">
                <div class="card-body d-grid align-content-center">
                    <?php
                        $sql = "SELECT pv.nombre, tfpv.total
                        FROM totalFacturaPV tfpv
                        JOIN puntoVenta pv ON tfpv.idPuntoVenta = pv.id
                        WHERE tfpv.idEvento = '$id'
                        ORDER BY total DESC
                        LIMIT 1";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                                <span style="font-size: 2em;font-weight: bolder;"><?php echo $row['nombre']; ?></span>
                                <span style="font-size: 1.5em;font-weight: bolder;">$ <?php echo number_format( $row['total'], 0, ',', '.' ); ?></span>
                            <?php }
                        }
                    ?>
                </div>
                <div class="card-footer">
                    <div class="text-uppercase fw-bold">Zona con más ventas</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-12 d-grid">
            <div class="card mb-3 text-center text-white Amin">
                <div class="card-body d-grid align-content-center">
                    <?php
                        $sql = "SELECT p.nombre, SUM(v.cantidad) AS 'cantidad'
                        FROM ventas v
                        JOIN productos p ON v.idProducto = p.id
                        WHERE v.idEvento = '$id'
                        GROUP BY v.idProducto
                        ORDER BY cantidad DESC
                        LIMIT 1";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                                <span style="font-size: 2em;font-weight: bolder;"><?php echo $row['nombre']; ?></span>
                                <span style="font-size: 1.5em;font-weight: bolder;"><?php echo $row['cantidad']; ?> Unidades</span>
                            <?php }
                        }
                    ?>
                </div>
                <div class="card-footer">
                    <div class="text-uppercase fw-bold">Producto más vendido</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-12 d-grid">
            <div class="card mb-3 text-center text-white SinCityRed">
                <div class="card-body d-grid align-content-center">
                    <?php
                        $fechaActual = strtotime( date( 'm/d/Y', time() ) );
                        $cont = 0;

                        $sql = "SELECT tfm.mesa, pv.nombre, tfm.total
                        FROM totalFacturaMesa tfm
                        JOIN puntoVenta pv ON tfm.idPuntoVenta = pv.id
                        WHERE tfm.idEvento = '$id'
                        ORDER BY tfm.total DESC
                        LIMIT 1";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                                <span style="font-size: 2em;font-weight: bolder;"><?php echo $row['mesa']; ?></span>
                                <span style="font-size: 1.5em;font-weight: bolder;">Zona: <?php echo $row['nombre']; ?></span>
                                <span style="font-size: 1.5em;font-weight: bolder;">$ <?php echo number_format( $row['total'], 0, ',', '.' ); ?></span>
                            <?php }
                        }
                    ?>
                </div>
                <div class="card-footer">
                    <div class="text-uppercase fw-bold">Mejor mesa</div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-12 d-grid">
            <div class="card mb-3 text-center text-white LearningLeading">
                <div class="card-body d-grid align-content-center">
                    <?php
                        $fechaActual = strtotime( date( 'm/d/Y', time() ) );
                        $cont = 0;

                        $sql = "SELECT u.fullName, pv.nombre, tfu.total
                        FROM totalFacturaUsers tfu
                        JOIN usuarios u ON tfu.idUsuario = u.id
                        JOIN puntoVenta pv ON tfu.idPuntoVenta = pv.id
                        WHERE tfu.idEvento = '$id'
                        ORDER BY tfu.total DESC
                        LIMIT 1";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                                <span style="font-size: 2em;font-weight: bolder;"><?php echo $row['fullName']; ?></span>
                                <span style="font-size: 1.5em;font-weight: bolder;">Zona: <?php echo $row['nombre']; ?></span>
                                <span style="font-size: 1.5em;font-weight: bolder;">$ <?php echo number_format( $row['total'], 0, ',', '.' ); ?></span>
                            <?php }
                        }
                    ?>
                </div>
                <div class="card-footer">
                    <div class="text-uppercase fw-bold">Mejor mesero</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 mb-5">
            <h3>Ventas generales</h3>
        </div>
        <div class="col-12">
            <table id="informes-table1" class="display responsive nowrap">
                <thead>
                    <tr>
                        <th>Zona</th>
                        <th>Factura</th>
                        <th>Mesa</th>
                        <th>Mesero</th>
                        <th>Total vendido</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT pv.nombre AS 'puntoVenta', v.codeFac, v.mesa, u.fullName AS 'mesero', tf.total
                        FROM ventas v
                        JOIN puntoVenta pv ON v.idPuntoVenta = pv.id
                        JOIN usuarios u ON v.mesero = u.id
                        JOIN totalFactura tf ON v.codeFac = tf.codeFac
                        WHERE v.idEvento = '$id' AND v.status = 'approved'
                        GROUP BY v.codeFac";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $html = '<tr>';
                                    $html .= '<th>'. $row['puntoVenta'] .'</th>';
                                    $html .= '<th>'. $row['codeFac'] .'</th>';
                                    $html .= '<th>'. $row['mesa'] .'</th>';
                                    $html .= '<th>'. $row['mesero'] .'</th>';
                                    $html .= '<th>$ '. number_format( $row['total'], 0, ',', '.' ) .'</th>';
                                    $html .= '<th>
                                        <button type="button" class="btn btn-warning verFactura" data-bs-toggle="modal" data-bs-target="#verFactura" data-bs-codeFac="'. $row['codeFac'] .'">
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

    <div class="row mt-5">
        <div class="col-xl-6 col-md-6 col-12">
            <h3 class="mb-3">Total ventas por Zona</h3>
            <table id="informes-table1" class="display responsive nowrap">
                <thead>
                    <tr>
                        <th>Zona</th>
                        <th>Total vendido</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT pv.nombre, tfpv.total
                        FROM totalFacturaPV tfpv
                        JOIN puntoVenta pv ON tfpv.idPuntoVenta = pv.id
                        WHERE tfpv.idEvento = '$id'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $html = '<tr>';
                                    $html .= '<th>'. $row['nombre'] .'</th>';
                                    $html .= '<th>$ '. number_format( $row['total'], 0, ',', '.' ) .'</th>';
                                $html .= '</tr>';

                                echo $html;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="col-xl-6 col-md-6 col-12">
            <h3 class="mb-3">Total ventas por Mesa</h3>
            <table id="informes-table1" class="display responsive nowrap">
                <thead>
                    <tr>
                        <th>Zona</th>
                        <th>Mesa</th>
                        <th>Total vendido</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT pv.nombre, tfm.mesa, tfm.total
                        FROM totalFacturaMesa tfm
                        JOIN puntoVenta pv ON tfm.idPuntoVenta = pv.id
                        WHERE tfm.idEvento = '$id'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $html = '<tr>';
                                    $html .= '<th>'. $row['nombre'] .'</th>';
                                    $html .= '<th>'. $row['mesa'] .'</th>';
                                    $html .= '<th>$ '. number_format( $row['total'], 0, ',', '.' ) .'</th>';
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

<!-- Agregar inventario -->
<div class="modal fade" id="agregarInventario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="agregarInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarInventarioLabel">Agregar inventario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-2">
                            <label class="form-label">ID</label>
                            <input type="text" name="agregarInventario-idEvento" id="agregarInventario-idEvento" class="form-control" readonly>
                        </div>
                        <div class="col-10">
                            <label class="form-label">Evento</label>
                            <input type="text" name="agregarInventario-nombreEvento" id="agregarInventario-nombreEvento" class="form-control" readonly>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label">Lote</label>
                            <input type="text" name="agregarInventario-Lote" id="agregarInventario-Lote" class="form-control" value="<?php echo $lote; ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <label class="form-label">Producto</label>
                            <select name="agregarInventario-Producto" id="agregarInventario-Producto" class="form-select">
                                <option selected>---</option>
                                <?php
                                    $sql = "SELECT * FROM productos WHERE status = '1' ORDER BY nombre ASC";
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
                            <input type="text" name="agregarInventario-Cantidad" id="agregarInventario-Cantidad" class="form-control" placeholder="50">
                        </div>
                        <div class="col-12 mt-3 d-grid">
                            <button type="button" id="addBodega" class="btn btn-warning fw-bold text-uppercase">Agregar y continuar</button>
                        </div>
                    </div>
                    <div class="row mt-5 mb-3 productosAgregados"></div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Productos agregados correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-agregarInventario" class="btn btn-primary">Confirmar Inventario</button>
            </div>
        </div>
    </div>
</div>

<!-- Editar inventario -->
<div class="modal fade" id="editarInventario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarInventarioLabel">Editar item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-12">
                            <label class="form-label">ID</label>
                            <input type="text" name="editarInventario-idInventario" id="editarInventario-idInventario" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-8">
                            <label class="form-label">Producto</label>
                            <input type="text" name="editarInventario-Nombre" id="editarInventario-Nombre" class="form-control" readonly>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Cantidad</label>
                            <input type="text" name="editarInventario-Cantidad" id="editarInventario-Cantidad" class="form-control" placeholder="50">
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Item editado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-editarInventario" class="btn btn-primary">Editar item</button>
            </div>
        </div>
    </div>
</div>

<!-- Eliminar producto -->
<div class="modal fade" id="eliminarInventario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarInventarioLabel">Eliminar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-12">
                            <label class="form-label">Id producto</label>
                            <input type="text" name="eliminarInventario-idInventario" id="eliminarInventario-idInventario" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mt-5 mb-5">
                        <div class="col-12 text-center">
                            <h4>¿Esta seguro que desea eliminar el producto <span class="product badge bg-primary"></span>?</h4>
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Item eliminado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-eliminarInventario" class="btn btn-danger">Eliminar item</button>
            </div>
        </div>
    </div>
</div>

<!-- Agregar punto de venta -->
<div class="modal fade" id="agregarPuntoVenta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="agregarPuntoVentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarPuntoVentaLabel">Crear zona de venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-6">
                            <label class="form-label">ID</label>
                            <input type="text" name="agregarPuntoVenta-idEvento" id="agregarPuntoVenta-idEvento" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Evento</label>
                            <input type="text" name="agregarPuntoVenta-nombreEvento" id="agregarPuntoVenta-nombreEvento" class="form-control" readonly>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label">Lote</label>
                            <input type="text" name="agregarPuntoVenta-Lote" id="agregarPuntoVenta-Lote" class="form-control" value="<?php echo $lote; ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="agregarPuntoVenta-Nombre" id="agregarPuntoVenta-Nombre" class="form-control" placeholder="Barra 1">
                        </div>
                        <div class="col-4">
                            <label class="form-label"># Mesas</label>
                            <input type="text" name="agregarPuntoVenta-cantMesas" id="agregarPuntoVenta-cantMesas" class="form-control" placeholder="10">
                        </div>
                        <div class="col-12 mt-3 d-grid">
                            <button type="button" id="addPuntos" class="btn btn-warning fw-bold text-uppercase">Agregar y continuar</button>
                        </div>
                    </div>
                    <div class="row mt-5 mb-3 zonasVenta"></div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Zona de venta creada correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-agregarPuntoVenta" class="btn btn-primary">Crear zona de venta</button>
            </div>
        </div>
    </div>
</div>

<!-- Editar punto de venta -->
<div class="modal fade" id="editarPuntoV" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarPuntoVLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarPuntoVLabel">Editar zona de venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-12">
                            <label class="form-label">ID</label>
                            <input type="text" name="editarPuntoV-ID" id="editarPuntoV-ID" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-8">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="editarPuntoV-Nombre" id="editarPuntoV-Nombre" class="form-control" placeholder="Barra 1">
                        </div>
                        <div class="col-4">
                            <label class="form-label"># Mesas</label>
                            <input type="text" name="editarPuntoV-cantMesas" id="editarPuntoV-cantMesas" class="form-control" placeholder="10">
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Zona de venta editada correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-editarPuntoV" class="btn btn-primary">Editar zona de venta</button>
            </div>
        </div>
    </div>
</div>

<!-- Eliminar punto de venta -->
<div class="modal fade" id="eliminarPuntoV" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarPuntoVLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarPuntoVLabel">Eliminar zona de venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-12">
                            <label class="form-label">ID Punto de venta</label>
                            <input type="text" name="eliminarPuntoV-ID" id="eliminarPuntoV-ID" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mt-5 mb-5">
                        <div class="col-12 text-center">
                            <h4>¿Esta seguro que desea eliminar la zona de venta <span class="name badge bg-primary"></span> y todo el contenido asociado?</h4>
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Zona de venta eliminada correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-eliminarPuntoV" class="btn btn-danger">Eliminar zona de venta</button>
            </div>
        </div>
    </div>
</div>

<!-- Agregar inventario a punto de venta -->
<div class="modal fade" id="agregarSubInventario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="agregarSubInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarSubInventarioLabel">Asignar item al PV</h5>
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
                        <div class="col-6">
                            <label class="form-label">ID Punto Venta</label>
                            <input type="text" name="agregarSubInventario-IDpuntoVenta" id="agregarSubInventario-IDpuntoVenta" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">ID Evento</label>
                            <input type="text" name="agregarSubInventario-IDevento" id="agregarSubInventario-IDevento" class="form-control" readonly>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label">Lote</label>
                            <input type="text" name="agregarSubInventario-Lote" id="agregarSubInventario-Lote" class="form-control" value="<?php echo $lote; ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <label class="form-label">Producto</label>
                            <select name="agregarSubInventario-Producto" id="agregarSubInventario-Producto" class="form-select">
                                <option selected>---</option>
                                <?php
                                    $sql = "SELECT p.id, p.nombre FROM inventario i JOIN productos p ON i.idProducto = p.id WHERE i.idEvento = '$id' ORDER BY p.nombre ASC";
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
                            <input type="number" name="agregarSubInventario-Cantidad" id="agregarSubInventario-Cantidad" class="form-control" placeholder="50">
                        </div>
                        <div class="col-12 mt-3 d-grid">
                            <button type="button" id="addSubBodega" class="btn btn-warning fw-bold text-uppercase">Agregar y continuar</button>
                        </div>
                    </div>
                    <div class="row mt-3 infoCantidades"></div>
                    <div class="row mt-5 addSubBodega"></div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Item asignado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-agregarSubInventario" class="btn btn-primary">Asignar item al PV</button>
            </div>
        </div>
    </div>
</div>

<!-- Editar Sub-inventario punto de venta -->
<div class="modal fade" id="editarSubInventario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarSubInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarSubInventarioLabel">Editar item</h5>
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
                        <div class="col-12">
                            <label class="form-label">ID</label>
                            <input type="text" name="editarSubInventario-IDItem" id="editarSubInventario-IDItem" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <label class="form-label">Producto</label>
                            <input type="text" name="editarSubInventario-Nombre" id="editarSubInventario-Nombre" class="form-control" readonly>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Cantidad</label>
                            <input type="text" name="editarSubInventario-Cantidad" id="editarSubInventario-Cantidad" class="form-control" placeholder="50">
                        </div>
                    </div>
                    <div class="row mt-3 mb-5 infoCantidades"></div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Item editado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-editarSubInventario" class="btn btn-primary">Editar item</button>
            </div>
        </div>
    </div>
</div>

<!-- Eliminar Sub-inventario punto de venta -->
<div class="modal fade" id="eliminarSubInventario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarSubInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarSubInventarioLabel">Eliminar item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-12">
                            <label class="form-label">ID</label>
                            <input type="text" name="eliminarSubInventario-IDItem" id="eliminarSubInventario-IDItem" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mt-5 mb-5">
                        <div class="col-12 text-center">
                            <h4>¿Esta seguro que desea eliminar el item <span class="product badge bg-primary"></span> de la zona <span class="zona badge bg-primary"></span>?</h4>
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Item eliminado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-eliminarSubInventario" class="btn btn-danger">Eliminar item</button>
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