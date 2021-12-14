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

<section class="container mb-5">
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <h2>Bienvenido de nuevo <?php echo $fullName; ?></h2>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-xl-3 col-md-6 col-6 d-grid">
            <div class="card mb-3 text-center text-white MoonlitAsteroid">
                <div class="card-body">
                    <?php
                        $sql = "SELECT COUNT(id) AS 'total' FROM productos";
                        $result = $conn->query($sql);
                    
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                                <span style="font-size: 3em;font-weight: bolder;"><?php echo $row['total']; ?></span>
                            <?php }
                        }
                    ?>
                </div>
                <div class="card-footer">
                    <div>Productos registrados</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-6 d-grid">
            <div class="card mb-3 text-center text-white DarkOcean">
                <div class="card-body">
                    <?php
                        $sql = "SELECT COUNT(id) AS 'total' FROM eventos";
                        $result = $conn->query($sql);
                    
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                                <span style="font-size: 3em;font-weight: bolder;"><?php echo $row['total']; ?></span>
                            <?php }
                        }
                    ?>
                </div>
                <div class="card-footer">
                    <div>Eventos registrados</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-6 d-grid">
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
                    <span style="font-size: 3em;font-weight: bolder;"><?php echo $cont; ?></span>
                </div>
                <div class="card-footer">
                    <div>Próximos eventos</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-6 d-grid">
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
                    <span style="font-size: 3em;font-weight: bolder;"><?php echo $cont; ?></span>
                </div>
                <div class="card-footer">
                    <div>Eventos finalizados</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-xl-6 col-md-12 col-12">
            <h4 class="mb-3">Productos más vendidos</h4>
            <canvas id="productosMasVendidos" width="100%"></canvas>
        </div>
        <div class="col-xl-6 col-md-12 col-12">
            <h4 class="mb-3">Productos menos vendidos</h4>
            <canvas id="productosMenosVendidos" width="100%"></canvas>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        window.setTimeout(function() {
            // productosMasVendidos
            var ctx_productosMasVendidos = document.getElementById('productosMasVendidos');
            var myChart_productosMasVendidos = new Chart(ctx_productosMasVendidos, {
                type: 'bar',
                data: {
                    labels: [
                        <?php
                            $sql = "SELECT p.nombre, SUM(v.cantidad) AS 'cantidad'
                            FROM ventas v
                            JOIN productos p ON v.idProducto = p.id
                            GROUP BY v.idProducto
                            ORDER BY cantidad DESC
                            LIMIT 5";
                            $result = $conn->query($sql);
                        
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "'". $row['nombre'] ."', ";
                                }
                            }
                        ?>
                    ],
                    datasets: [{
                        label: 'Unidades vendidas',
                        data: [
                            <?php
                                $sql = "SELECT p.nombre, SUM(v.cantidad) AS 'cantidad'
                                FROM ventas v
                                JOIN productos p ON v.idProducto = p.id
                                GROUP BY v.idProducto
                                ORDER BY cantidad DESC
                                LIMIT 5";
                                $result = $conn->query($sql);
                            
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo $row['cantidad'] . ', ';
                                    }
                                }
                            ?>
                        ],
                        backgroundColor: [
                            'rgba(62, 81, 81, 0.2)',
                            'rgba(17, 153, 142, 0.2)',
                            'rgba(16, 141, 199, 0.2)',
                            'rgba(239, 142, 56, 0.2)',
                            'rgba(252, 92, 125, 0.2)',
                            'rgba(75, 19, 79, 0.2)',
                            'rgba(69, 182, 73, 0.2)'
                        ],
                        borderColor: [
                            'rgba(62, 81, 81, 1)',
                            'rgba(17, 153, 142, 1)',
                            'rgba(16, 141, 199, 1)',
                            'rgba(239, 142, 56, 1)',
                            'rgba(252, 92, 125, 1)',
                            'rgba(75, 19, 79, 1)',
                            'rgba(69, 182, 73, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // productosMenosVendidos
            var ctx_productosMenosVendidos = document.getElementById('productosMenosVendidos');
            var myChart_productosMenosVendidos = new Chart(ctx_productosMenosVendidos, {
                type: 'bar',
                data: {
                    labels: [
                        <?php
                            $sql = "SELECT p.nombre, SUM(v.cantidad) AS 'cantidad'
                            FROM ventas v
                            JOIN productos p ON v.idProducto = p.id
                            GROUP BY v.idProducto
                            ORDER BY cantidad ASC
                            LIMIT 5";
                            $result = $conn->query($sql);
                        
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "'". $row['nombre'] ."', ";
                                }
                            }
                        ?>
                    ],
                    datasets: [{
                        label: 'Unidades vendidas',
                        data: [
                            <?php
                                $sql = "SELECT p.nombre, SUM(v.cantidad) AS 'cantidad'
                                FROM ventas v
                                JOIN productos p ON v.idProducto = p.id
                                GROUP BY v.idProducto
                                ORDER BY cantidad ASC
                                LIMIT 5";
                                $result = $conn->query($sql);
                            
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo $row['cantidad'] . ', ';
                                    }
                                }
                            ?>
                        ],
                        backgroundColor: [
                            'rgba(88, 24, 69, 0.2)',
                            'rgba(144, 12, 63, 0.2)',
                            'rgba(199, 0, 57, 0.2)',
                            'rgba(255, 87, 51, 0.2)',
                            'rgba(255, 195, 0, 0.2)',
                        ],
                        borderColor: [
                            'rgba(88, 24, 69, 1)',
                            'rgba(144, 12, 63, 1)',
                            'rgba(199, 0, 57, 1)',
                            'rgba(255, 87, 51, 1)',
                            'rgba(255, 195, 0, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }, 1500);
    });
</script>