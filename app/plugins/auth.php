<?php

/*
 *  Author: Matija Belec
 *    Date: 05.06.2015
 */

class Auth {
    protected static $instance = null;
    
    protected function __construct() {}
    protected function __destruct() {}
    
    static public function getInstance() {
        if(is_null(self::$instance) ) {
            self::$instance = new Auth();
        }
        return self::$instance;
    }
    
    public function login() {
        global $user;
        if(isset($_SESSION['username']) && isset($_SESSION['key']) ) {
            //$user = new User($_SESSION['username'], $_SESSION['key']);
            return true;
        }
        return false;
    }
    public function login_check() {
        if(isset($_SESSION['username']) && isset($_SESSION['key']) ) {
            //$user = new User($_SESSION['username'], $_SESSION['key']);
            return true;
        }
        return false;
    }
    public function logout() {
        session_destroy();
    }
}

?>