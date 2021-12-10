<?php
    // MySQLi
    $servername = "localhost";
    $username   = "app_bind";
    $password   = "h_Af867w";
    $dbname     = "app_bind";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    $code = 'BSE' . rand(1000, 9999);
    $linkSocio = 'https://' . $_SERVER[HTTP_HOST] . '/ver-evento/?evento=' . $code;
?>

<section class="container">
    <div class="row mt-5">
        <div class="col-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Crear nuevo evento</button>
        </div>
    </div>

    <div class="row mt-5">
        <table id="tableEventos" class="display">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Link para Socios</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM eventos WHERE status = '1'";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $html = '<tr>';
                                $html .= '<th>'. $row['nombre'] .'</th>';
                                $html .= '<th>'. $row['fechaFormato'] .'</th>';
                                $html .= '<th>'. $row['lugar'] .'</th>';
                                $html .= '<th>'. $row['linkSocio'] .'</th>';
                                $html .= '<th>
                                    <button type="button" class="btn btn-primary agregarInventario" data-bs-toggle="modal" data-bs-target="#agregarInventario" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-success agregarPuntoVenta" data-bs-toggle="modal" data-bs-target="#agregarPuntoVenta" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-warning editarEvento" data-bs-toggle="modal" data-bs-target="#editarEvento" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'" data-fecha="'. $row['fecha'] .'" data-lugar="'. $row['lugar'] .'" data-linkSocio="'. $row['linkSocio'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger eliminarEvento" data-bs-toggle="modal" data-bs-target="#eliminarEvento" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'">
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

<!-- Crear evento -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Crear nuevo evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Silvestre en Trucupey">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label class="form-label">Fecha</label>
                            <input type="text" name="fecha" id="fecha" class="form-control datepicker" placeholder="<?php echo date("n/d/Y"); ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Lugar</label>
                            <input type="text" name="lugar" id="lugar" class="form-control" placeholder="Trucupey">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Link para socios</label>
                            <input type="text" name="linkSocio" id="linkSocio" class="form-control" value="<?php echo $linkSocio; ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Evento creado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-crearEvento" class="btn btn-primary">Crear evento</button>
            </div>
        </div>
    </div>
</div>

<!-- Editar evento -->
<div class="modal fade" id="editarEvento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarEventoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarEventoLabel">Editar evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row hide">
                        <div class="col-12">
                            <label class="form-label">Id evento</label>
                            <input type="text" name="edit-id" id="edit-id" class="form-control" readonly>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="edit-nombre" id="edit-nombre" class="form-control" placeholder="Silvestre en Trucupey">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label class="form-label">Fecha</label>
                            <input type="text" name="edit-fecha" id="edit-fecha" class="form-control datepicker" placeholder="<?php echo date("n/d/Y"); ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Lugar</label>
                            <input type="text" name="edit-lugar" id="edit-lugar" class="form-control" placeholder="Trucupey">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Link para socios</label>
                            <input type="text" name="edit-linkSocio" id="edit-linkSocio" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Evento editado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-editarEvento" class="btn btn-warning">Editar evento</button>
            </div>
        </div>
    </div>
</div>

<!-- Eliminar evento -->
<div class="modal fade" id="eliminarEvento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarEventoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarEventoLabel">Eliminar evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row mt-3 hide">
                        <div class="col-12">
                            <label class="form-label">Id evento</label>
                            <input type="text" name="delete-id" id="delete-id" class="form-control" readonly>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>¿Esta seguro que desea eliminar el evento <span class="event"></span>?</h4>
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Evento eliminado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-eliminarEvento" class="btn btn-danger">Eliminar evento</button>
            </div>
        </div>
    </div>
</div>

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
                    <div class="row">
                        <div class="col-2">
                            <label class="form-label">ID</label>
                            <input type="text" name="idEvento" id="idEvento" class="form-control" readonly>
                        </div>
                        <div class="col-10">
                            <label class="form-label">Evento</label>
                            <input type="text" name="nombreEvento" id="nombreEvento" class="form-control" readonly>
                        </div>
                    </div>  
                    <div class="row mt-5">
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
                </div>
                <div class="alert alert-success successful-message hide mt-5" role="alert">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p class="fw-normal">Item agregado correctamente</p>
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

<!-- Agregar punto de venta -->
<div class="modal fade" id="agregarPuntoVenta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="agregarPuntoVentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarPuntoVentaLabel">Agregar inventario</h5>
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
                    <div class="row mt-5">
                        <div class="col-12">
                            <label class="form-label">Nombre punto de venta</label>
                            <input type="text" name="nombrePV" id="nombrePV" class="form-control" placeholder="Barra 1">
                        </div>
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
                            <button type="button" id="btn-agregarSubInventario" class="btn btn-info">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="row hide">
                        <div class="col-12">
                            <p class="text-muted">Unidades disponibles de <span class="product"></span>: <span class="cantidad bd-highlight"></span></p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-success successful-message hide mt-5" role="alert">
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