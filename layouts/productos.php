<?php
    // MySQLi
    $servername = "localhost";
    $username   = "app_bind";
    $password   = "h_Af867w";
    $dbname     = "app_bind";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
?>

<section class="container mb-5">
    <div class="row mt-5">
        <div class="col-xl-3 col-md-6 col-12">
            <button type="button" class="btn bg-bind-1 fw-bold text-uppercase text-white" data-bs-toggle="modal" data-bs-target="#crearProducto">Añadir nuevo producto</button>
        </div>
    </div>

    <div class="row mt-5">
        <table class="DataTable display responsive nowrap">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Costo</th>
                    <th>Precio al público</th>
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
                                $html .= '<th>$ '. $row['costo'] .'</th>';
                                $html .= '<th>$ '. $row['precioPublico'] .'</th>';
                                $html .= '<th>
                                    <button type="button" class="btn btn-warning editarProducto" data-bs-toggle="modal" data-bs-target="#editarProducto" data-bs-id="'. $row['id'] .'" data-bs-imagen="'. $row['imagen'] .'" data-bs-nombre="'. $row['nombre'] .'" data-bs-costo="'. $row['costo'] .'" data-bs-precioPublico="'. $row['precioPublico'] .'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn btn-danger eliminarProducto" data-bs-toggle="modal" data-bs-target="#eliminarProducto" data-bs-id="'. $row['id'] .'" data-bs-nombre="'. $row['nombre'] .'">
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

<!-- Crear producto -->
<div class="modal fade" id="crearProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="crearProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearProductoLabel">Crear nuevo producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="#" enctype="multipart/form-data">
                                <div class="d-grid">
                                    <input type="file" class="form-control" name="crearProducto-Imagen" id="crearProducto-Imagen">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Nombre producto</label>
                            <input type="text" name="crearProducto-Nombre" id="crearProducto-Nombre" class="form-control" placeholder="Old Parr 750ml">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label class="form-label">Costo</label>
                            <input type="text" name="crearProducto-Costo" id="crearProducto-Costo" class="form-control" placeholder="90.000" onkeyup="separadorMiles(this,this.value.charAt(this.value.length-1))">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Precio al público</label>
                            <input type="text" name="crearProducto-PrecioPublico" id="crearProducto-PrecioPublico" class="form-control" placeholder="120.000" onkeyup="separadorMiles(this,this.value.charAt(this.value.length-1))">
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
<div class="modal fade" id="editarProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarProductoLabel">Editar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row mt-3 hide">
                        <div class="col-12">
                            <label class="form-label">Id producto</label>
                            <input type="text" name="editarProducto-ID" id="editarProducto-ID" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="#" enctype="multipart/form-data">
                                <div class="card">
                                    <img id="editarProducto-Imagen" class="edit-card-img-top" src="/dist/img/empty.jpg">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Nombre producto</label>
                            <input type="text" name="editarProducto-Nombre" id="editarProducto-Nombre" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label class="form-label">Costo</label>
                            <input type="text" name="editarProducto-Costo" id="editarProducto-Costo" class="form-control" onkeyup="separadorMiles(this,this.value.charAt(this.value.length-1))">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Precio al público</label>
                            <input type="text" name="editarProducto-PrecioPublico" id="editarProducto-PrecioPublico" class="form-control" onkeyup="separadorMiles(this,this.value.charAt(this.value.length-1))">
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
                <button type="button" id="btn-editarProducto" class="btn btn-warning">Editar producto</button>
            </div>
        </div>
    </div>
</div>

<!-- Eliminar producto -->
<div class="modal fade" id="eliminarProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarProductoLabel">Eliminar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row mt-3 hide">
                        <div class="col-12">
                            <label class="form-label">Id producto</label>
                            <input type="text" name="eliminarProducto-ID" id="eliminarProducto-ID" class="form-control" readonly>
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
                            <h4 class="mt-4">Producto eliminado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-eliminarProducto" class="btn btn-danger">Eliminar producto</button>
            </div>
        </div>
    </div>
</div>