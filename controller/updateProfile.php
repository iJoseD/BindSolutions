<?php session_start();

// MySQLi
$servername = "localhost";
$username   = "app_bind";
$password   = "h_Af867w";
$dbname     = "app_bind";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Var
$caso       = $_POST['caso'];
$dni        = $_POST['dni'];
$firstName  = $_POST['firstName'];
$lastName   = $_POST['lastName'];
$email      = $_POST['email'];
$phone      = $_POST['phone'];
$address    = $_POST['address'];
$superPower = $_POST['superPower'];

// updateProfile
if ( $caso == 'updateProfile' ) {
    $sql = "UPDATE userProfile SET dni = '$dni', firstname = '$firstName', lastname = '$lastName', email = '$email', address = '$address', superPower = '$superPower', status = 'profile_created' WHERE phone = '$phone'";

    if ($conn->query($sql) === TRUE) {
        echo 'update_success';

        $_SESSION['dni']        = $dni;
        $_SESSION['firstName']  = $firstName;
        $_SESSION['lastName']   = $lastName;
        $_SESSION['email']      = $email;
        $_SESSION['address']    = $address;
        $_SESSION['superPower'] = $superPower;
    } else {
        echo 'error_update_db';
    }

    $conn->close();
}