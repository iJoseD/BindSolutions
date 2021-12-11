<?php session_start();

// MySQLi
$servername = "localhost";
$username   = "app_bind";
$password   = "h_Af867w";
$dbname     = "app_bind";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$code   = rand(1000, 9999);

if (is_array($_FILES) && count($_FILES) > 0) {
    if (($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/png")
        || ($_FILES["file"]["type"] == "image/gif")) {
        if ( move_uploaded_file( $_FILES["file"]["tmp_name"], "../dist/img-profile/".$code."-".$_FILES['file']['name'] ) ) {
            $avatar = "/dist/img-profile/".$code."-".$_FILES['file']['name'];

            $sql = "SELECT MAX(id) AS id FROM productos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $idProducto = $row['id'];
                }
            }

            $sql = "UPDATE productos SET imagen = '$avatar' WHERE id = '$idProducto'";
            if ($conn->query($sql) === TRUE) {
                echo $avatar;
            } else {
                echo 'error_update_db';
            }
        } else {
            echo "error_al_mover_archivo";
        }
    } else {
        echo "error_formato_imagen";
    }
} else {
    echo "error_array_files";
}

$conn->close();