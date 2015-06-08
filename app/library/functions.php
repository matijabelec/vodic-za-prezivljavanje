<?php

/*
 *
 *  Filename: functions.php
 *  Author: Matija Belec (hackerma3x@gmail.com)
 *  Date: 5 March 2015
 *  Description:
 *      - utility functions for standard stuff
 *      - autoloader function
 *      - security functions (reporting mode, globals, MQ-functions, secure session)
 *  Requirements:
 *      - config.php
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

function Autoloader($class_name) {
    $class_name = strtolower($class_name);
    
    $library = DIR_LIBRARY."$class_name.php";
    if(file_exists($library) ) { require_once($library); return; }
    
    $template = DIR_TEMPLATES."$class_name.php";
    if(file_exists($template) ) { require_once($template); return; }
    
    $view = DIR_VIEWS."$class_name.php";
    if(file_exists($view) ) { require_once($view); return; }
    
    $model = DIR_MODELS."$class_name.php";
    if(file_exists($model) ) { require_once($model); return; }
    
    $controller = DIR_CONTROLLERS."$class_name.php";
    if(file_exists($controller) ) { require_once($controller); return; }
    
    $plugin = DIR_PLUGINS."$class_name.php";
    if(file_exists($plugin) ) { require_once($plugin); return; }
}

function SetReportingMode() {
    if(ENVIRONMENT_DEVELOPMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', 'Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', DIR_LOGS.'errors.log');
    }
}

function UnregisterGlobals() {
    if(ini_get('register_globals') ) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value)
            foreach($GLOBALS[$value] as $key => $var)
                if($var === $GLOBALS[$key])
                    unset($GLOBALS[$key]);
    }
}

function StripSlashesDeep($value) {
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}
function RemoveMQ() {
    if(get_magic_quotes_gpc() ) {
        $_GET = StripSlashesDeep($_GET);
        $_POST = StripSlashesDeep($_POST);
        $_COOKIE = StripSlashesDeep($_COOKIE);
    }
}

function Redirect($url, $relative=true) {
    if($relative)
        $url = WEBSITE_ROOT_PATH . $url;
    
    if(headers_sent() ) {
        die('<script type="text/javascript">window.location=\'' . $url . '\';</script>');
    } else {
        header('Location: ' . $url);
        die();
    }
}

function UseSecureConnection() {
    if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']!=='on') {
        $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if(!headers_sent() ) {
            die('<script type="text/javascript">window.location=\'' . $url . '\';</script>');
        } else {
            header('Status: 301 Moved Permanently');
            header('Location: ' . $url);
            die();
        }
    }
}

function SecureSessionStart($session_name='NEW_SESSION_ID') {
    session_name($session_name);
    session_start();
    session_regenerate_id(true);
}

?>