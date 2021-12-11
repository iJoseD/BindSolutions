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
?>

<section class="container-fluid text-white bgHeaderEvento">
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
</section>

<section class="container">
    <div class="row mt-5">
        <div class="col-3 d-grid">
            <button type="button" class="btn btn-primary agregarInventario" data-bs-toggle="modal" data-bs-target="#agregarInventario" data-id="<?php echo $id; ?>" data-nombre="<?php echo $nombre; ?>">Agregar inventario</button>
        </div>
        <div class="col-3 d-grid">
            <button type="button" class="btn btn-primary agregarPuntoVenta" data-bs-toggle="modal" data-bs-target="#agregarPuntoVenta" data-id="<?php echo $id; ?>" data-nombre="<?php echo $nombre; ?>">Agregar punto de venta</button>
        </div>
    </div>

    <!-- Inventario disponible -->
    <div class="row mt-5">
        <h3 class="mb-5">Productos asignados</h3>
        <table id="tableProductos" class="display">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Costo</th>
                    <th>Precio al público</th>
                    <th>Unidades disponibles</th>
                    <th>Ganancia estimada</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT i.id, p.id AS idProducto, p.imagen, p.nombre, p.costo, p.precioPublico, i.cantidad FROM inventario i JOIN productos p ON i.idProducto = p.id WHERE i.idEvento = '$id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {

                            $idProducto = $row['idProducto'];
                            $cantidadInventario = $row['cantidad'];
                            
                            $ganancia = str_replace( '.', '', $row['precioPublico'] ) - str_replace( '.', '', $row['costo'] );
                            $ganancia = $ganancia * $row['cantidad'];

                            $sql2 = "SELECT * FROM inventarioPuntoVenta WHERE idEvento = '$id' AND idProducto = '$idProducto'";
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
                                $html .= '<th>$ '. $row['costo'] .'</th>';
                                $html .= '<th>$ '. $row['precioPublico'] .'</th>';
                                $html .= '<th>'. $cantidadTotal .'</th>';
                                $html .= '<th>$ '. number_format( $ganancia, 0, ',', '.' ) .'</th>';
                                $html .= '<th>
                                    <button type="button" class="btn btn-warning editarInventario" data-bs-toggle="modal" data-bs-target="#editarInventario" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'" data-cantidad="'. $row['cantidad'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger eliminarInventario" data-bs-toggle="modal" data-bs-target="#eliminarInventario" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'">
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
        <h3 class="mb-5">Puntos de venta</h3>
        <div class="col-6">
            <table id="tablePuntosVenta" class="display">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM puntoVenta WHERE idEvento = '$id'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $html = '<tr>';
                                    $html .= '<th>'. $row['nombre'] .'</th>';
                                    $html .= '<th>
                                        <button type="button" class="btn btn-success agregarSubInventario" data-bs-toggle="modal" data-bs-target="#agregarSubInventario" data-idEvento="'. $id .'" data-idPV="'. $row['id'] .'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-warning editarPuntoV" data-bs-toggle="modal" data-bs-target="#editarPuntoV" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-danger eliminarPuntoV" data-bs-toggle="modal" data-bs-target="#eliminarPuntoV" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'">
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
        <h3 class="mb-5">Productos por punto de venta</h3>
        <table id="tableSubInventario" class="display">
            <thead>
                <tr>
                    <th>Punto de venta</th>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Unidades</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT ipv.id, pv.nombre AS nombrePV, p.imagen, p.nombre, ipv.cantidad FROM inventarioPuntoVenta ipv JOIN productos p ON ipv.idProducto = p.id JOIN puntoVenta pv ON ipv.idPuntoVenta = pv.id WHERE ipv.idEvento = '$id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $html = '<tr>';
                                $html .= '<th>'. $row['nombrePV'] .'</th>';
                                $html .= '<th><img src="'. $row['imagen'] .'" alt="'. $row['nombre'] .'" class="imgProducto"></th>';
                                $html .= '<th>'. $row['nombre'] .'</th>';
                                $html .= '<th>'. $row['cantidad'] .'</th>';
                                $html .= '<th>
                                    <button type="button" class="btn btn-warning editarSubInventario" data-bs-toggle="modal" data-bs-target="#editarSubInventario" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'" data-cantidad="'. $row['cantidad'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger eliminarSubInventario" data-bs-toggle="modal" data-bs-target="#eliminarSubInventario" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'">
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
                            <input type="text" name="idEvento" id="idEvento" class="form-control" readonly>
                        </div>
                        <div class="col-10">
                            <label class="form-label">Evento</label>
                            <input type="text" name="nombreEvento" id="nombreEvento" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-8">
                            <label class="form-label">Producto</label>
                            <select name="idProducto" id="idProducto" class="form-select">
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
                            <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="50">
                        </div>
                    </div>
                    <div class="row mt-3 tablePrecios"></div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Item agregado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-agregarInventario" class="btn btn-primary">Agregar al inventario</button>
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
                            <input type="text" name="idInventario" id="idInventario" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-8">
                            <label class="form-label">Producto</label>
                            <input type="text" name="ei-nombre" id="ei-nombre" class="form-control" readonly>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Cantidad</label>
                            <input type="text" name="ei-cantidad" id="ei-cantidad" class="form-control" placeholder="50">
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
                    <div class="row mt-3 hide">
                        <div class="col-12">
                            <label class="form-label">Id producto</label>
                            <input type="text" name="delete-idInventario" id="delete-idInventario" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
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
                <h5 class="modal-title" id="agregarPuntoVentaLabel">Agregar punto de venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-6">
                            <label class="form-label">ID</label>
                            <input type="text" name="pv-idEvento" id="pv-idEvento" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Evento</label>
                            <input type="text" name="pv-nombreEvento" id="pv-nombreEvento" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Nombre punto de venta</label>
                            <input type="text" name="nombrePV" id="nombrePV" class="form-control" placeholder="Barra 1">
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Punto de venta agregado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-agregarPuntoVenta" class="btn btn-primary">Agregar punto de venta</button>
            </div>
        </div>
    </div>
</div>
<!-- Editar punto de venta -->
<div class="modal fade" id="editarPuntoV" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarPuntoVLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarPuntoVLabel">Editar punto de venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-12">
                            <label class="form-label">ID</label>
                            <input type="text" name="editarPuntoV-IDPuntoV" id="editarPuntoV-IDPuntoV" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Nombre punto de venta</label>
                            <input type="text" name="editarPuntoV-nombrePV" id="editarPuntoV-nombrePV" class="form-control" placeholder="Barra 1">
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Punto de venta editado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-editarPuntoV" class="btn btn-primary">Editar punto de venta</button>
            </div>
        </div>
    </div>
</div>
<!-- Eliminar punto de venta -->
<div class="modal fade" id="eliminarPuntoV" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarPuntoVLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarPuntoVLabel">Eliminar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row mt-3 hide">
                        <div class="col-12">
                            <label class="form-label">ID Punto de venta</label>
                            <input type="text" name="eliminarPuntoV-IDPuntoV" id="eliminarPuntoV-IDPuntoV" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>¿Esta seguro que desea eliminar el punto de venta <span class="name badge bg-primary"></span> y todo el contenido asociado?</h4>
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Punto de venta eliminado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-eliminarPuntoV" class="btn btn-danger">Eliminar punto de venta</button>
            </div>
        </div>
    </div>
</div>
<!-- Agregar Sub-inventario punto de venta -->
<div class="modal fade" id="agregarSubInventario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="agregarSubInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarSubInventarioLabel">Asignar item al PV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-6">
                            <label class="form-label">ID Punto Venta</label>
                            <input type="text" name="pv-IDPV" id="pv-IDPV" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">ID Evento</label>
                            <input type="text" name="pv-IDEvento-Sub" id="pv-IDEvento-Sub" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-8">
                            <label class="form-label">Producto</label>
                            <select name="SubInventario-idProducto" id="SubInventario-idProducto" class="form-select">
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
                            <input type="number" name="SubInventario-Cantidad" id="SubInventario-Cantidad" class="form-control" placeholder="50">
                        </div>
                    </div>
                    <div class="row mt-3 infoCantidades"></div>
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
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-12">
                            <label class="form-label">ID</label>
                            <input type="text" name="editarSubInventario-IDItem" id="editarSubInventario-IDItem" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-8">
                            <label class="form-label">Producto</label>
                            <input type="text" name="editarSubInventario-Nombre" id="editarSubInventario-Nombre" class="form-control" readonly>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Cantidad</label>
                            <input type="text" name="editarSubInventario-Cantidad" id="editarSubInventario-Cantidad" class="form-control" placeholder="50">
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
                    <div class="row mt-3 hide">
                        <div class="col-12">
                            <label class="form-label">ID</label>
                            <input type="text" name="eliminarSubInventario-IDItem" id="eliminarSubInventario-IDItem" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>¿Esta seguro que desea eliminar el item <span class="product badge bg-primary"></span>?</h4>
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