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
    $_SESSION['userdata'] = null;
    unset($_SESSION['userdata']);
    echo 'Korisnik je odjavljen';
} else {
    echo 'Korisnik nije niti bio prijavljen';
}

session_destroy();

?>