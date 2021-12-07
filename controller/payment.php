<?php

// MySQLi
$servername = "localhost";
$username   = "app_bind";
$password   = "h_Af867w";
$dbname     = "app_bind";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// stripeAuthentication
$sql = "SELECT * FROM stripeAuthentication";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        switch ( $row['label'] ) {
            case 'SECRET_TEST':
                $SECRET_TEST = $row['value'];
            break;
        }
    }
}

// Var
$caso     = $_POST['caso'];
$ccnum    = trim( $_POST['ccnum'] );
$expMonth = $_POST['expMonth'];
$expYear  = $_POST['expYear'];
$cvv      = $_POST['cvv'];
$amount   = $_POST['amount'];
$tAmount  = $_POST['tAmount'];

if ( $caso == 'payment' ) { // CREAR METODO DE PAGO Y OBTENER ID
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "type=card&card[number]=$ccnum&card[exp_month]=$expMonth&card[exp_year]=$expYear&card[cvc]=$cvv");
    curl_setopt($ch, CURLOPT_USERPWD, $SECRET_TEST . ':' . '');

    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $array = json_decode($result);
    $paymentMethod = $array->id;

    if (curl_errno($ch)) {
        echo 'error_payment_methods';
    } else { // CREAR INTENCIÓN DE PAGO Y REGISTRAR
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "amount=$tAmount&currency=usd&payment_method_types[]=card&description=TEST_PAYMENT&payment_method=$paymentMethod&confirm=true");
        curl_setopt($ch, CURLOPT_USERPWD, $SECRET_TEST . ':' . '');

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'error_payment_intents';
        } else { // TRANSFERIR A LA CUENTA CONECTADA
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/transfers');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "amount=$amount&currency=usd&destination=acct_1JVeKzPXms5KFVvi");
            curl_setopt($ch, CURLOPT_USERPWD, $SECRET_TEST . ':' . '');

            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'error_transfers';
            } else {
                echo 'successful_payment';
            }
            curl_close($ch); // TRANSFERIR A LA CUENTA CONECTADA
        }
        curl_close($ch); // CREAR INTENCIÓN DE PAGO Y REGISTRAR
    }
    curl_close($ch); // CREAR METODO DE PAGO Y OBTENER ID
}