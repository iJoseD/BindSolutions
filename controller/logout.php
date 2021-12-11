<?php

$caso = $_POST['caso'];

if ( $caso == 'logout' ) {
    session_destroy();
    header( 'location: /' );
}