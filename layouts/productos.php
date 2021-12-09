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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Añadir nuevo producto</button>
        </div>
    </div>

    <div class="row mt-5">
        <table id="tableProductos" class="display">
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
                
            </tbody>
        </table>
    </div>
</section>

<!-- Crear producto -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Crear nuevo producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="#" enctype="multipart/form-data">
                                <div class="card">
                                    <img class="card-img-top" src="/dist/img/empty.jpg">
                                    <div class="card-body d-grid">
                                        <input type="file" class="form-control" name="img--profile" id="img--profile">
                                        <!-- <input type="button" class="btn btn-primary upload mt-3" value="Subir imagen"> -->
                                    </div>
                                </div>
                            </form>
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
<div class="modal fade" id="editarProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarProductoLabel">Editar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="edit-fullName" id="edit-fullName" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Rol</label>
                            <select name="edit-rol" id="edit-rol" class="form-select">
                                <option selected>---</option>
                                <?php
                                    $sql = "SELECT * FROM rol";
                                    $result = $conn->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<option value="'. $row['id'] .'">'. $row['rol'] .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <label class="form-label">Usuario</label>
                            <input type="text" name="edit-user" id="edit-user" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="edit-password" id="edit-password" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Usuario editado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-editarProducto" class="btn btn-warning">Editar usuario</button>
            </div>
        </div>
    </div>
</div>

<!-- Eliminar producto -->
<div class="modal fade" id="eliminarProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarProductoLabel">Eliminar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>¿Esta seguro que desea eliminar el usuario <span class="user"></span>?</h4>
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Usuario eliminado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-eliminarProducto" class="btn btn-danger">Eliminar usuario</button>
            </div>
        </div>
    </div>
</div>