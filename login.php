<?php

/*
 *  Author: Matija Belec
 *    Date: 05.06.2015
 */

include_once('app/app_init.php');

$user = null;
if(isset($_SESSION['userdata']) ) {
    echo 'Korisnik je vec logiran';
    $user = $_SESSION['userdata'];
} else {
    $user = 124;
    $_SESSION['userdata'] = $user;
    echo 'Korisnik je uspjesno logiran';
}

//session_name("APP_USERID");
//session_start();

?>