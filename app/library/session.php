<?php

/*
 *
 *  Filename: session.php
 *  Author: Matija Belec (matijabelec1@gmail.com)
 *  Date: 14 June 2015
 *  Description:
 *      - singleton
 *  Requirements:
 *      - [none]
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Session {
    public static function set($name, $value) {
        if(!isset($name) || !isset($value) )
            return false;
        $_SESSION[$name] = $value;
    }
    public static function get($name) {
        if(isset($name) && isset($_SESSION[$name]) )
            return $_SESSION[$name];
        return null;
    }
    public static function check($name) {
        if(isset($name) && isset($_SESSION[$name]) )
            return true;
        return false;
    }
    public static function destroy($name) {
        unset($_SESSION[$name]);
        session_destroy();
    }
}

?>