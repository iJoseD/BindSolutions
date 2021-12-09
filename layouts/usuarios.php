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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Crear nuevo usuario</button>
        </div>
    </div>

    <div class="row mt-5">
        <table id="tableusuarios" class="display">
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
                    $sql = "SELECT * FROM rol";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        $html = '<tr>';
                            while($row = $result->fetch_assoc()) {
                                $html .= '<td>'. $row['fullName'] .'</td>';
                                $html .= '<td>'. $row['user'] .'</td>';
                                $html .= '<td>'. $row['rol'] .'</td>';
                                $html .= '<td>'. $row['lastLogin'] .'</td>';
                                $html .= '<td><button type="button" class="btn btn-success"><i class="bi bi-pencil"></i></button></td>';
                            }
                        $html .= '</tr>';

                        echo $html;
                    }
                ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Crear nuevo usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="fullName" id="fullName" class="form-control" placeholder="Joan Alonso Rivero">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Rol</label>
                            <select name="rol" id="rol" class="form-select">
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
                            <input type="text" name="user" id="user" class="form-control" placeholder="JoanAlonso">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña">
                        </div>
                    </div>
                </div>
                <div class="successful-message hide">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="/dist/img/tick.png" alt="Tick">
                            <h2>Usuario creado correctamente</h2>
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