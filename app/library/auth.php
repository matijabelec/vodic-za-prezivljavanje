<?php

/*
 *
 *  Filename: auth.php
 *  Author: Matija Belec (matijabelec1@gmail.com)
 *  Date: 5 June 2015
 *  Description:
 *      - singleton that represents an login/logout module for users in app
 *  Requirements:
 *      -
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Auth {
    //protected static $instance = null;
    protected static $user = null;
    
    protected function __construct() {}
    protected function __destruct() {}
    
    //public static function getInstance() {
    //    if(is_null(self::$instance) ) self::$instance = new Auth();
    //    return self::$instance;
    //}
    
    public static function login() {
        self::$user = null;
        if(self::login_check() == false) {
            $user = [
                'userid' => 12,
                'username' => 'matijabelec',
                'key' => 'fe6752348a67c78c3eef2aa3'
            ];
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }
    public static function login_check() {
        self::$user = null;
        if(isset($_SESSION['user']) ) {
            self::$user = $_SESSION['user'];
            return true;
        }
        return false;
    }
    public static function logout() {
        $user_logouted = false;
        if(isset($_SESSION['user']) ) {
            self::$user = null;
            $_SESSION['user'] = null;
            unset($_SESSION['user']);
            $user_logouted = true;
        }
        session_destroy();
        return $user_logouted;
    }
}

?>