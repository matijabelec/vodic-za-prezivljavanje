<?php

/*
 *  Author: Matija Belec
 *    Date: 05.06.2015
 */

include_once('app/app_init.php');

//session_name("APP_USERID");
//session_start();

$user = null;
if(isset($_SESSION['userdata']) ) {
    $user = $_SESSION['userdata'];
}

if(is_null($user) ) {
    echo 'Gost';
} else {
    echo 'Registrirani korisnik';
}

?>