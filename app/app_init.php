<?php

/*
 *  Author: Matija Belec
 *    Date: 06.06.2015
 */

include_once('config.php');
include_once('functions.php');
include_once('server_time.php');

include_once('library/database.php');
include_once('library/template.php');
include_once('library/view.php');
include_once('library/model.php');
include_once('library/controller.php');

include_once('library/auth.php');

session_name('APP_USERID');
session_start();

?>