<?php
    session_start();
    include "../library/mcript.php";
    $encryptedPhone = $encriptar( $_SESSION['phone'] );
?>

<section class="container s--myqr">
    <div class="row">
        <div class="col-12 text-center">
            <a href="/"><img src="https://thankyoutipper.com/wp-content/uploads/2021/08/newLogo-W.svg" width="60%" alt="Logo ThankYou Tipper"></a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 text-center">
            <p class="text-white" style="font-weight: 800;">I'm <?php echo $_SESSION['firstName']; ?> and my super power is:</p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 text-center">
            <span class="superPower">To <?php echo $_SESSION['superPower']; ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col-1"></div>
        <div class="card col-10">
            <div class="card-body">
                <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https://myapp.thankyoutipper.com/payments/?id=<?php echo $encryptedPhone; ?>&choe=UTF-8" alt="Generate QR Code">
                <h2 class="card-title text--orange" style="font-weight: 800;"><?php echo $_SESSION['firstName']; ?></h2>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <span class="thanks">Thanks!</span>
        </div>
    </div>
</section>