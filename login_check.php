<?php

session_name("APP_USERID");
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['key']) ) {
    //$user = new User($_SESSION['username'], $_SESSION['key']);
}

?>