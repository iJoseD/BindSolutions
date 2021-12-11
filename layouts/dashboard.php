<?php session_start();
    $fullName = $_SESSION['fullName'];
?>

<section class="container">
    <div class="row mt-5">
        <div class="col-12">
            <h4>Bienvenido de nuevo <?php echo $fullName; ?></h4>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-3 col-12">
            <div class="card mb-3 text-center text-white" style="background-image: url('/reportes/assets/img/bg-1.png'); background-position: left; background-repeat: no-repeat; background-size: inherit;">
                <div class="card-body">
                    <span style="font-size: xxx-large;font-weight: bolder;">10</span>
                </div>
                <div class="card-footer">
                    <div>Empleados activos</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12">
            <div class="card mb-3 text-center text-white" style="background-image: url('/reportes/assets/img/bg-2.png'); background-position: left; background-repeat: no-repeat; background-size: inherit;">
                <div class="card-body">
                    <span style="font-size: xxx-large;font-weight: bolder;">10</span>
                </div>
                <div class="card-footer">
                    <div>Todas las reservas</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12">
            <div class="card mb-3 text-center text-white" style="background-image: url('/reportes/assets/img/bg-3.png'); background-position: left; background-repeat: no-repeat; background-size: inherit;">
                <div class="card-body">
                    <span style="font-size: xxx-large;font-weight: bolder;">10</span>
                </div>
                <div class="card-footer">
                    <div>Reservas para hoy</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-12">
            <div class="card mb-3 text-center text-white" style="background-image: url('/reportes/assets/img/bg-4.png'); background-position: left; background-repeat: no-repeat; background-size: inherit;">
                <div class="card-body">
                    <span style="font-size: xxx-large;font-weight: bolder;">10</span>
                </div>
                <div class="card-footer">
                    <div>Ganancias estimadas</div>
                </div>
            </div>
        </div>
    </div>
</section>