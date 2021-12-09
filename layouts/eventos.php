<?php
    // MySQLi
    $servername = "localhost";
    $username   = "app_bind";
    $password   = "h_Af867w";
    $dbname     = "app_bind";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
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
                    <th>Link Socios</th>
                    <th>Puntos de venta</th>
                    <th>Unidades en stock</th>
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
                                $html .= '<th>'. $row['fecha'] .'</th>';
                                $html .= '<th>'. $row['lugar'] .'</th>';
                                $html .= '<th>'. $row['linkSocio'] .'</th>';
                                $html .= '<th>5</th>';
                                $html .= '<th>120</th>';
                                $html .= '<th>
                                    <button type="button" class="btn btn-warning editarEvento" data-bs-toggle="modal" data-bs-target="#editarEvento" data-id="'. $row['id'] .'" data-nombre="'. $row['nombre'] .'" data-fecha="'. $row['fecha'] .'" data-lugar="'. $row['lugar'] .'">
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

                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Crear producto -->
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
                        <div class="col-6">
                            <div class="input-append datepicker" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
                                <input class="datepicker" size="16" type="text" value="12-02-2012" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Nombre producto</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Old Parr 750ml">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label class="form-label">Costo</label>
                            <input type="text" name="costo" id="costo" class="form-control" placeholder="90.000" onkeyup="separadorMiles(this,this.value.charAt(this.value.length-1))">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Precio al público</label>
                            <input type="text" name="precioPublico" id="precioPublico" class="form-control" placeholder="120.000" onkeyup="separadorMiles(this,this.value.charAt(this.value.length-1))">
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Producto creado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-crearProducto" class="btn btn-primary">Crear producto</button>
            </div>
        </div>
    </div>
</div>

<!-- Editar producto -->
<div class="modal fade" id="editarEvento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarEventoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarEventoLabel">Editar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row mt-3 hide">
                        <div class="col-12">
                            <label class="form-label">Id producto</label>
                            <input type="text" name="edit-id" id="edit-id" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="#" enctype="multipart/form-data">
                                <div class="card">
                                    <img class="edit-card-img-top" src="/dist/img/empty.jpg">
                                    <!-- <div class="card-body d-grid">
                                        <input type="file" class="form-control" name="edit-img--profile" id="edit-img--profile">
                                    </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Nombre producto</label>
                            <input type="text" name="edit-nombre" id="edit-nombre" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label class="form-label">Costo</label>
                            <input type="text" name="edit-costo" id="edit-costo" class="form-control" onkeyup="separadorMiles(this,this.value.charAt(this.value.length-1))">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Precio al público</label>
                            <input type="text" name="edit-precioPublico" id="edit-precioPublico" class="form-control" onkeyup="separadorMiles(this,this.value.charAt(this.value.length-1))">
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Producto editado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-editarEvento" class="btn btn-warning">Editar producto</button>
            </div>
        </div>
    </div>
</div>

<!-- Eliminar producto -->
<div class="modal fade" id="eliminarEvento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarEventoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarEventoLabel">Eliminar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row mt-3 hide">
                        <div class="col-12">
                            <label class="form-label">Id producto</label>
                            <input type="text" name="delete-id" id="delete-id" class="form-control" readonly>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>¿Esta seguro que desea eliminar el producto <span class="product"></span>?</h4>
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Producto eliminado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-eliminarEvento" class="btn btn-danger">Eliminar producto</button>
            </div>
        </div>
    </div>
</div>