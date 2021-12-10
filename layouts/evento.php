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
            <button type="button" class="btn btn-primary agregarPuntoVenta" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Agregar punto de venta</button>
        </div>
    </div>

    <!-- Inventario disponible -->
    <div class="row mt-5">
        <h3 class="mb-5">Inventario disponible</h3>
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
                    $sql = "SELECT i.id, p.imagen, p.nombre, p.costo, p.precioPublico, i.cantidad FROM inventario i JOIN productos p ON i.idProducto = p.id WHERE i.idEvento = '$id'";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            
                            $ganancia = str_replace( '.', '', $row['precioPublico'] ) - str_replace( '.', '', $row['costo'] );
                            $ganancia = $ganancia * $row['cantidad'];
                            
                            $html = '<tr>';
                                $html .= '<th><img src="'. $row['imagen'] .'" alt="'. $row['nombre'] .'" class="imgProducto"></th>';
                                $html .= '<th>'. $row['nombre'] .'</th>';
                                $html .= '<th>$ '. $row['costo'] .'</th>';
                                $html .= '<th>$ '. $row['precioPublico'] .'</th>';
                                $html .= '<th>'. $row['cantidad'] .'</th>';
                                $html .= '<th>$ '. number_format( $ganancia, 0, ',', '.' ) .'</th>';
                                $html .= '<th>
                                    <button type="button" class="btn btn-warning editarInventario" data-bs-toggle="modal" data-bs-target="#editarInventario" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'" data-cantidad="'. $row['cantidad'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger eliminarProducto" data-bs-toggle="modal" data-bs-target="#eliminarProducto" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'">
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
        <table id="tablePuntosVenta" class="display">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Costo</th>
                    <th>Precio al público</th>
                    <th>Ganancia estimada</th>
                    <th>Unidades disponibles</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM productos WHERE status = '1'";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $html = '<tr>';
                                $html .= '<th><img src="'. $row['imagen'] .'" alt="'. $row['nombre'] .'" class="imgProducto"></th>';
                                $html .= '<th>'. $row['nombre'] .'</th>';
                                $html .= '<th>'. $row['costo'] .'</th>';
                                $html .= '<th>'. $row['precioPublico'] .'</th>';
                                $html .= '<th>'. $row['precioPublico'] .'</th>';
                                $html .= '<th>'. $row['precioPublico'] .'</th>';
                                $html .= '<th>
                                    <button type="button" class="btn btn-warning editarProducto" data-bs-toggle="modal" data-bs-target="#editarProducto" data-id="'. $row['id'] .'" data-imagen="'. $row['imagen'] .'" data-nombre="'. $row['nombre'] .'" data-costo="'. $row['costo'] .'" data-precioPublico="'. $row['precioPublico'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger eliminarProducto" data-bs-toggle="modal" data-bs-target="#eliminarProducto" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'">
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
                    <div class="row">
                        <div class="col-2">
                            <label class="form-label">ID</label>
                            <input type="text" name="pv-idEvento" id="pv-idEvento" class="form-control" readonly>
                        </div>
                        <div class="col-10">
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
                <div class="sub-inventario hide">
                    <div class="row">
                        <div class="col-12">
                            <p class="fs-4">Asignar inventario</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
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
                        <div class="col-3">
                            <label class="form-label">Cantidad</label>
                            <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="50">
                        </div>
                        <div class="col-3 d-grid">
                            <label class="form-label text-white">Button</label>
                            <button type="button" id="btn-agregarSubInventario" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="row mt-5 hide">
                        <div class="col-12">
                            <p class="text-muted">Unidades disponibles de <span class="product fw-bolder"></span>: <span class="cantidad badge bg-primary text-wrap"></span></p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-success successful-alert hide mt-5" role="alert">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p class="fw-normal">Item agregado correctamente</p>
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