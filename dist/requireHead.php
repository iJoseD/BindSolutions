<?php
    if ( strpos( $_SERVER['REQUEST_URI'], '/payments/' ) !== false ) { } else {
        session_start();

        if ( empty( $_SESSION['user'] ) ) {
            if ( $_SERVER['REQUEST_URI'] != '/login/' ) {
                header( 'location: ../login/' );
            }
        } else {
            if ( $_SERVER['REQUEST_URI'] == '/login/' ) {
                header( 'location: /' );
            }
        }
    }
?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- <link rel="icon" href="https://thankyoutipper.com/wp-content/uploads/2021/08/cropped-favicon2-32x32.jpg" sizes="32x32">
    <link rel="icon" href="https://thankyoutipper.com/wp-content/uploads/2021/08/cropped-favicon2-192x192.jpg" sizes="192x192">
    <link rel="apple-touch-icon" href="https://thankyoutipper.com/wp-content/uploads/2021/08/cropped-favicon2-180x180.jpg">
    <meta name="msapplication-TileImage" content="https://thankyoutipper.com/wp-content/uploads/2021/08/cropped-favicon2-270x270.jpg"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- dataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/dist/css/style.css">
    
    <title>Bind Solutions</title>
</head>