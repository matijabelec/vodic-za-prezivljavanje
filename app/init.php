<?php

/*
 *
 *  Filename: init.php
 *  Author: Matija Belec (hackerma3x@gmail.com)
 *  Date: 6 March 2015
 *  Description:
 *      - this is only file witch MUST be included to proprely setup framework
 *  Requirements:
 *      - config.php
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

define('DIR_APP', __DIR__.DS);

require_once(DIR_APP.'config.php');
require_once(DIR_APP.'project_data.php');
require_once(DIR_LIBRARY.'functions.php');
require_once(DIR_LIBRARY.'router.php');

function Start() {
    SecureSessionStart('USER_ID');
    
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    
    spl_autoload_register('Autoloader');
    SetReportingMode();
    RemoveMQ();
    UnregisterGlobals();
    
    Router::route($url);
}

?>