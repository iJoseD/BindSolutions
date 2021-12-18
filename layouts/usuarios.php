<?php
    include "../library/mcript.php";

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
        <div class="col-xl-3 col-md-6 col-6">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearUsuario">Crear nuevo usuario</button>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 mb-5"><h3>Usuarios activos</h3></div>
        <div class="col-12">
            <table class="DataTable display responsive nowrap">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Último acceso</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM usuarios WHERE status = '1'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                switch ( $row['rol'] ) {
                                    case '1':
                                        $rol = 'Administrador';
                                    break;
                                    case '2':
                                        $rol = 'Vendedor';
                                    break;
                                }
                                $html = '<tr>';
                                    $html .= '<th>'. $row['fullName'] .'</th>';
                                    $html .= '<th>'. $row['user'] .'</th>';
                                    $html .= '<th>'. $rol .'</th>';
                                    $html .= '<th>'. $row['lastLogin'] .'</th>';
                                    $html .= '<th>
                                        <button type="button" class="btn btn-warning editarUsuario" data-bs-toggle="modal" data-bs-target="#editarUsuario" data-bs-fullName="'. $row['fullName'] .'" data-bs-user="'. $row['user'] .'" data-bs-rol="'. $row['rol'] .'" data-bs-password="'. $desencriptar( $row['password'] ) .'" data-bs-idEvento="'. $row['idEvento'] .'" data-bs-idPuntoVenta="'. $row['idPuntoVenta'] .'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-danger eliminarUsuario" data-bs-toggle="modal" data-bs-target="#eliminarUsuario" data-bs-user="'. $row['user'] .'">
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

    <div class="row mt-5">
        <div class="col-12 mb-5"><h3>Usuarios inactivos</h3></div>
        <div class="col-12">
            <table class="DataTable display responsive nowrap">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Último acceso</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM usuarios WHERE status = '0'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                switch ( $row['rol'] ) {
                                    case '1':
                                        $rol = 'Administrador';
                                    break;
                                    case '2':
                                        $rol = 'Vendedor';
                                    break;
                                }
                                $html = '<tr>';
                                    $html .= '<th>'. $row['fullName'] .'</th>';
                                    $html .= '<th>'. $row['user'] .'</th>';
                                    $html .= '<th>'. $rol .'</th>';
                                    $html .= '<th>'. $row['lastLogin'] .'</th>';
                                    $html .= '<th>
                                        <button type="button" class="btn btn-success activarUsuario" data-bs-toggle="modal" data-bs-target="#activarUsuario" data-bs-fullName="'. $row['fullName'] .'" data-bs-user="'. $row['user'] .'" data-bs-rol="'. $row['rol'] .'" data-bs-password="'. $desencriptar( $row['password'] ) .'" data-bs-idEvento="'. $row['idEvento'] .'" data-bs-idPuntoVenta="'. $row['idPuntoVenta'] .'">Activar</button>
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

<!-- Crear usuario -->
<div class="modal fade" id="crearUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="crearUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearUsuarioLabel">Crear nuevo usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="crearUsuario-Nombre" id="crearUsuario-Nombre" class="form-control" placeholder="Joan Alonso Rivero">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Rol</label>
                            <select name="crearUsuario-Rol" id="crearUsuario-Rol" class="form-select">
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
                            <input type="text" name="crearUsuario-Usuario" id="crearUsuario-Usuario" class="form-control" placeholder="JoanAlonso">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="crearUsuario-Contrasena" id="crearUsuario-Contrasena" class="form-control" placeholder="Contraseña">
                        </div>
                    </div>
                    <div class="row mt-3 asignarEvento hide">
                        <div class="col-12 mb-3">
                            <h4>Asignar evento</h4>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Evento</label>
                            <select name="crearUsuario-SelectEvento" id="crearUsuario-SelectEvento" class="form-select">
                                <option selected>---</option>
                                <?php
                                    $sql = "SELECT * FROM eventos ORDER BY nombre ASC";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<option value="'. $row['id'] .'">'. $row['nombre'] .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Zona</label>
                            <select name="crearUsuario-SelectPV" id="crearUsuario-SelectPV" class="form-select">
                                <option selected>---</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Usuario creado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-crearUsuario" class="btn btn-primary">Crear usuario</button>
            </div>
        </div>
    </div>
</div>

<!-- Editar usuario -->
<div class="modal fade" id="editarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarUsuarioLabel">Editar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="editarUsuario-Nombre" id="editarUsuario-Nombre" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Rol</label>
                            <select name="editarUsuario-Rol" id="editarUsuario-Rol" class="form-select">
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
                            <input type="text" name="editarUsuario-Usuario" id="editarUsuario-Usuario" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="editarUsuario-Contrasena" id="editarUsuario-Contrasena" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3 asignarEvento hide">
                        <div class="col-12 mb-3">
                            <h4>Asignar evento</h4>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Evento</label>
                            <select name="editarUsuario-SelectEvento" id="editarUsuario-SelectEvento" class="form-select">
                                <option selected>---</option>
                                <?php
                                    $sql = "SELECT * FROM eventos ORDER BY nombre ASC";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<option value="'. $row['id'] .'">'. $row['nombre'] .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Punto de venta</label>
                            <select name="editarUsuario-SelectPV" id="editarUsuario-SelectPV" class="form-select">
                                <option selected>---</option>
                            </select>
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
                <button type="button" id="btn-editarUsuario" class="btn btn-warning">Editar usuario</button>
            </div>
        </div>
    </div>
</div>

<!-- Eliminar usuario -->
<div class="modal fade" id="eliminarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarUsuarioLabel">Eliminar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>¿Esta seguro que desea eliminar el usuario <span class="user badge bg-primary"></span>?</h4>
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
                <button type="button" id="btn-eliminarUsuario" class="btn btn-danger">Eliminar usuario</button>
            </div>
        </div>
    </div>
</div>

<!-- Activar usuario -->
<div class="modal fade" id="activarUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="activarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activarUsuarioLabel">Activar y confirmar datos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="activarUsuario-Nombre" id="activarUsuario-Nombre" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Rol</label>
                            <select name="activarUsuario-Rol" id="activarUsuario-Rol" class="form-select">
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
                            <input type="text" name="activarUsuario-Usuario" id="activarUsuario-Usuario" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="activarUsuario-Contrasena" id="activarUsuario-Contrasena" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3 asignarEvento hide">
                        <div class="col-12 mb-3">
                            <h4>Asignar evento</h4>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Evento</label>
                            <select name="activarUsuario-SelectEvento" id="activarUsuario-SelectEvento" class="form-select">
                                <option selected>---</option>
                                <?php
                                    $sql = "SELECT * FROM eventos ORDER BY nombre ASC";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<option value="'. $row['id'] .'">'. $row['nombre'] .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Punto de venta</label>
                            <select name="activarUsuario-SelectPV" id="activarUsuario-SelectPV" class="form-select">
                                <option selected>---</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" width="25%" alt="Tick">
                            <h4 class="mt-4">Usuario activado correctamente</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-activarUsuario" class="btn btn-warning">Activar usuario</button>
            </div>
        </div>
    </div>
</div>