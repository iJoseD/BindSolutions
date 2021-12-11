<?php session_start();
    $fullName = $_SESSION['fullName'];

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
        <div class="col-12">
            <h4>Bienvenido de nuevo <?php echo $fullName; ?></h4>
        </div>
    </div>

    <div class="row mt-3">
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
                        $cont = 0:
                        
                        $sql = "SELECT * FROM eventos";
                        $result = $conn->query($sql);
                    
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $fechaEvento = strtotime( "$row['fecha']" );
                                
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
                    <span style="font-size: xxx-large;font-weight: bolder;">10</span>
                </div>
                <div class="card-footer">
                    <div>Total en ventas</div>
                </div>
            </div>
        </div>
    </div>
</section>