<?php session_start();
    $fullName     = $_SESSION['fullName'];
    $idEvento     = $_SESSION['idEvento'];
    $idPuntoVenta = $_SESSION['idPuntoVenta'];

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

<section class="container">
    <div class="row mt-5">
        <div class="col-12">
            <h2>Bienvenido de nuevo <?php echo $fullName; ?></h2>
        </div>
        <div class="col-12 mt-3">
            <h4>Tu evento asignado es <span class="badge bg-primary"><?php echo $nombreEvento; ?></span> en el punto de venta <span class="badge bg-primary"><?php echo $nombrePuntoVenta; ?></span></h4>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-xl-3 col-12">
            <div class="card mb-3 text-center text-white MoonlitAsteroid">
                <div class="card-body">
                    <?php
                        $sql = "SELECT COUNT(id) AS 'total' FROM productos";
                        $result = $conn->query($sql);
                    
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                                <span style="font-size: xxx-large;font-weight: bolder;"><?php echo $row['total']; ?></span>
                            <?php }
                        }
                    ?>
                </div>
                <div class="card-footer">
                    <div>Productos registrados</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12">
            <div class="card mb-3 text-center text-white DarkOcean">
                <div class="card-body">
                    <?php
                        $sql = "SELECT COUNT(id) AS 'total' FROM eventos";
                        $result = $conn->query($sql);
                    
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                                <span style="font-size: xxx-large;font-weight: bolder;"><?php echo $row['total']; ?></span>
                            <?php }
                        }
                    ?>
                </div>
                <div class="card-footer">
                    <div>Eventos registrados</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12">
            <div class="card mb-3 text-center text-white Amin">
                <div class="card-body">
                    <?php
                        $fechaActual = strtotime( date( 'm/d/Y', time() ) );
                        $cont = 0;
                        
                        $sql = "SELECT * FROM eventos";
                        $result = $conn->query($sql);
                    
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $fechaEvento = strtotime( $row['fecha'] );
                                
                                if ( $fechaActual > $fechaEvento ) { } else {
                                    $cont++;
                                }
                            }
                        }
                    ?>
                    <span style="font-size: xxx-large;font-weight: bolder;"><?php echo $cont; ?></span>
                </div>
                <div class="card-footer">
                    <div>Próximos eventos</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12">
            <div class="card mb-3 text-center text-white SinCityRed">
                <div class="card-body">
                    <?php
                        $fechaActual = strtotime( date( 'm/d/Y', time() ) );
                        $cont = 0;
                        
                        $sql = "SELECT * FROM eventos";
                        $result = $conn->query($sql);
                    
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $fechaEvento = strtotime( $row['fecha'] );
                                
                                if ( $fechaActual > $fechaEvento ) { $cont++; }
                            }
                        }
                    ?>
                    <span style="font-size: xxx-large;font-weight: bolder;"><?php echo $cont; ?></span>
                </div>
                <div class="card-footer">
                    <div>Eventos finalizados</div>
                </div>
            </div>
        </div>
    </div>
</section>