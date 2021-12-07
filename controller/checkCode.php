<?php session_start();

// MySQLi
$servername = "localhost";
$username   = "app_bind";
$password   = "h_Af867w";
$dbname     = "app_bind";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Var
$caso   = $_POST['caso'];
$phone  = $_POST['phone'];
$code   = $_POST['code'];

if ( $caso == 'checkCode' ) {
    $sql = "SELECT * FROM userProfile WHERE phone = '$phone'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ( $row['codeActivation'] == $code ) {
                if ( $row['status'] == 'pending_activation' ) {
                    $sql = "UPDATE userProfile SET status = 'incomplete_profile' WHERE phone = '$phone'";

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['phone'] = $phone;

                        echo 'update_success';
                    } else {
                        echo 'error_update_db';
                    }
                } else {
                    $_SESSION['phone'] = $phone;
                    $sql = "SELECT * FROM userProfile WHERE phone = '$phone'";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $_SESSION['avatar']     = $row['avatar'];
                            $_SESSION['dni']        = $row['dni'];
                            $_SESSION['firstName']  = $row['firstname'];
                            $_SESSION['lastName']   = $row['lastname'];
                            $_SESSION['email']      = $row['email'];;
                            $_SESSION['address']    = $row['address'];;
                            $_SESSION['superPower'] = $row['superPower'];;
                        }
                    }
                    
                    echo 'login_successful';
                }
            } else {
                echo 'invalid_code';
            }
        }
    }

    $conn->close();
}