<?php
    include "../library/mcript.php";
    $decryptedPhone = $desencriptar( $_GET['id'] );

    // MySQLi
    $servername = "localhost";
    $username   = "app_bind";
    $password   = "h_Af867w";
    $dbname     = "app_bind";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

    $sql = "SELECT * FROM userProfile WHERE phone = '$decryptedPhone'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ( empty( $row['avatar'] ) ) { $avatar = '../dist/img/user.png'; } else { $avatar = $row['avatar']; }
            $firstName = $row['firstname'];
            $superPower = $row['superPower'];
        }
    }

    $conn->close();
?>

<section class="container mb-5">
    <div class="row mt-3">
        <div class="col-12 text-center">
            <a href="/"><img src="https://thankyoutipper.com/wp-content/uploads/2021/08/newLogo.svg" width="60%" alt="Logo ThankYou Tipper"></a>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12 text-center">
            <img src="<?php echo $avatar; ?>" alt="Profile Avatar" width="50%">
        </div>
        <div class="col-12 mt-3 text-center">
            <p class="text--blue">I'm <?php echo $firstName; ?> and my super power is:</p>
        </div>
        <div class="col-12 text-center">
            <span class="superPower">To <?php echo $superPower; ?></span>
        </div>
    </div>

    <!-- Transaction -->
    <div class="row mt-5 transaction">
        <div class="col-12 text-center">
            <h1 class="text--blue">Transaction</h1>
        </div>
        <div class="col-12 mt-3">
            <h6 class="text--blue">Select an amount</h6>
        </div>
        <div class="col-3 mt-2">
            <div class="card-custom" id="amount-5">
                <div class="overlay" data-amount="5"></div>
                <span class="amount">5</span>
                <span class="symbol">$</span>
            </div>
        </div>
        <div class="col-3 mt-2">
            <div class="card-custom" id="amount-10">
                <div class="overlay" data-amount="10"></div>
                <span class="amount">10</span>
                <span class="symbol">$</span>
            </div>
        </div>
        <div class="col-3 mt-2">
            <div class="card-custom" id="amount-20">
                <div class="overlay" data-amount="20"></div>
                <span class="amount">20</span>
                <span class="symbol">$</span>
            </div>
        </div>
        <div class="col-3 mt-2">
            <div class="card-custom" id="amount-30">
                <div class="overlay" data-amount="30"></div>
                <span class="amount">30</span>
                <span class="symbol">$</span>
            </div>
        </div>
        <div class="col-12 mt-5 d-table hide">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold" colspan="2">Tip to <?php echo $superPower; ?></td>
                        <td class="text-center t-amount"></td>
                    </tr>
                    <tr>
                        <td class="fw-bold" colspan="2">Transaction cost</td>
                        <td class="text-center tCost"></td>
                    </tr>
                    <tr class="bgOrange text-white">
                        <td class="fw-bold" colspan="2">Total</td>
                        <td class="text-center total-amount"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="form-floating col-12 hide">
            <input type="text" class="form-control" id="amount">
            <label for="amount">Amount</label>
        </div>
        <div class="form-floating col-12 hide">
            <input type="text" class="form-control" id="t--amount">
            <label for="t--amount">Total Amount</label>
        </div>
        <div class="col-12 mt-5 d-grid">
            <button type="button" class="sendMoney btn btn-primary">Send Money</button>
        </div>
    </div>

    <!-- Payment -->
    <div class="row mt-5 payment hide">
        <div class="col-12 text-center">
            <h1 class="text--blue">Payment</h1>
        </div>
        <div class="col-12 text-center">
            <p class="text--orange amount fs-1">Amount: $ <span></span> usd</p>
        </div>
        <div class="form-floating col-12">
            <input type="text" class="form-control" name="ccnum" id="ccnum" inputmode="numeric" autocomplete="cc-number" placeholder="4242 4242 4242 4242">
            <label for="card-number">Card number</label>
        </div>
        <div class="form-floating col-4 mt-3">
            <select class="form-select" id="exp-month">
                <option value="01" selected>01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
            <label for="exp-month">Month</label>
        </div>
        <div class="form-floating col-4 mt-3">
            <select class="form-select" id="exp-year">
                <?php
                    $f = date("Y");
                    for( $i = 6; $i > 0; $i-- ) {
                        echo "<option value='". date("Y", strtotime("$f +$i year")) ."'>". date("Y", strtotime("$f +$i year")) ."</option>";
                    }
                    echo "<option value='". $f ."' selected>". $f ."</option>";
                ?>
            </select>
            <label for="exp-year">Year</label>
        </div>
        <div class="form-floating col-4 mt-3">
            <input type="password" class="form-control" id="cvv">
            <label for="cvv">CVV</label>
        </div>
        <div class="col-12 mt-5 d-grid">
            <button type="button" class="proceedPay btn btn-primary">Proceed to Pay</button>
        </div>
    </div>

    <!-- Processing payment -->
    <div class="row mt-5 processing-payment hide">
        <div class="col-12 text-center">
            <div class="spinner-border" style="width: 5rem; height: 5rem;" role="status"></div>
        </div>
        <div class="col-12 text-center">
            <span class="mt-3">Processing payment...</span>
        </div>
    </div>

    <!-- Successful payment -->
    <div class="row mt-5 successful-payment hide">
        <div class="col-12 text-center">
            <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
            <lottie-player src="https://assets5.lottiefiles.com/private_files/lf30_yo2zavgg.json" background="transparent" speed="1" style="width: 200px; height: 200px; margin: 0 auto;" loop autoplay></lottie-player>
            <h2 class="text--blue">Successful payment!</h2>
        </div>
    </div>
</section>