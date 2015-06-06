<?php

/*
 *  Author: Matija Belec
 *    Date: 05.06.2015
 */

class Database {
    protected static $instance = null;
    protected static $conn = null;
    
    protected function __construct() {}
    protected function __destruct() {
        if(!is_null($instance) && !is_null($conn) )
            disconnect();
    }
    
    static public function getInstance() {
        if(is_null(self::$instance) ) {
            self::$instance = new AppMain();
        }
        return self::$instance;
    }
    
    static public function connect($host, $db, $user, $pw, $arr=array(PDO::ATTR_PERSISTENT=>true)) {
        if(is_null(self::$conn) ) {
            try {
                self::$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pw, $arr);
            } catch(PDOException $e) {
                //print "Error!: " . $e->getMessage() . "<br/>";
                die();
                //return null;
            }
        }
        return self::$conn;
    }
    
    static public function disconnect() {
        if(!is_null(self::$conn) ) {
            self::$conn = null;
        }
    }
    
    static public function query($query) {
        
    }
}

?>