<?php session_start();
    $fullName = $_SESSION['fullName'];
?>

<section class="container">
    <div class="row mt-5">
        <div class="col-12">
            <h4>Bienbenido de nuevo, <?php echo $fullName; ?></h4>
        </div>
    </div>
</section>