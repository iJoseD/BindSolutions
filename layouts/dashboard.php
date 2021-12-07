<?php session_start();
    if ( empty( $_SESSION['avatar'] ) ) { $avatar = '../dist/img/user.png'; } else { $avatar = $_SESSION['avatar']; }
    $dni        = $_SESSION['dni'];
    $firstName  = $_SESSION['firstName'];
    $lastName   = $_SESSION['lastName'];
    $email      = $_SESSION['email'];
    $phone      = $_SESSION['phone'];
    $address    = $_SESSION['address'];
    $superPower = $_SESSION['superPower'];
?>

<section class="container">
    <div class="row mt-5">
        <div class="col-1"></div>
        <div class="card col-10">
            <div class="row">
                <div class="col-4">
                    <img src="<?php echo $avatar; ?>" class="img-fluid rounded-start" alt="Profile Avatar">
                </div>
                <div class="col-8">
                    <div class="card-body">
                        <h5 class="card-title text--blue">Good day, <?php echo $firstName; ?>!</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1"></div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text--blue">Balance of the last <span class="text--orange">7 days</span></h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <canvas id="balanceDashboard" width="100%"></canvas>
        </div>
    </div>

    <div class="options row mt-5">
        <div class="card col-4 text-center">
            <a href="/profile/">
                <img src="/dist/img/icoUser.png" alt="icoUser">
                <div class="card-body">
                    <h6 class="card-title text--blue">Account</h6>
                </div>
            </a>
        </div>
        <div class="card col-4 text-center">
            <a href="/historial/">
                <img src="/dist/img/icoHistory.png" alt="icoHistory">
                <div class="card-body">
                    <h6 class="card-title text--blue">Historial</h6>
                </div>
            </a>
        </div>
        <div class="card col-4 text-center">
            <a href="/my-qr/">
                <img src="/dist/img/icoQr.png" alt="icoQr">
                <div class="card-body">
                    <h6 class="card-title text--blue">My QR</h6>
                </div>
            </a>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        // Balance of the last 7 days
        window.setTimeout(function() {
            var ctx = document.getElementById('balanceDashboard');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        <?php
                            $f = date("M d");
                            for( $i = 6; $i > 0; $i-- ) {
                                echo "'".date("M d", strtotime("$f   -$i day"))."', ";
                            }
                            echo "'".$f."'";
                        ?>
                    ],
                    datasets: [{
                        label: 'Income',
                        data: [25, 30, 13, 18, 21, 11, 43],
                        backgroundColor: [
                            'rgba(18, 43, 252, 0.2)',
                            'rgba(29, 171, 149, 0.2)',
                            'rgba(247, 211, 79, 0.2)',
                            'rgba(247, 67, 67, 0.2)',
                            'rgba(42, 168, 247, 0.2)',
                            'rgba(176, 224, 29, 0.2)',
                            'rgba(196, 122, 51, 0.2)'
                        ],
                        borderColor: [
                            'rgba(18, 43, 252, 1)',
                            'rgba(29, 171, 149, 1)',
                            'rgba(247, 211, 79, 1)',
                            'rgba(247, 67, 67, 1)',
                            'rgba(42, 168, 247, 1)',
                            'rgba(176, 224, 29, 1)',
                            'rgba(196, 122, 51, 1)'
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