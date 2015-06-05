<?php

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
}

?>