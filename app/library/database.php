<?php

/*
 *
 *  Filename: database.php
 *  Author: Matija Belec (hackerma3x@gmail.com)
 *  Date: 6 March 2015
 *  Description:
 *      - singleton used to connect to database from single point
 *  Requirements:
 *      - config.php
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Database {
    private static $conn = null;
    
    protected function __construct() {}
    protected function __destruct() {
        if(!is_null(self::$conn) )
            self::$conn = null;
    }
    
    public static function connect( $db_username = DEFAULT_DB_USERNAME,
                                    $db_password = DEFAULT_DB_PASSWORD,
                                    $db_database = DEFAULT_DB_DATABASE,
                                    $db_hostname = DEFAULT_DB_HOSTNAME) {
        if(is_null(self::$conn) ) {
            try {
                if(PROJECT_USE_OLD_CHARSET != true) {
                    self::$conn = new PDO("mysql:host=$db_hostname;dbname=$db_database;charset=utf8", $db_username, $db_password);
                } else {
                    self::$conn = new PDO("mysql:host=$db_hostname;dbname=$db_database", $db_username, $db_password);
                    self::$conn->exec("set names utf8");
                }
            } catch(PDOException $pdo_e) {
                die($pdo_e->getMessage() );
            }
        }
        return self::$conn;
    }
    
    public static function disconnect() {
        if(!is_null(self::$conn) )
            self::$conn = null;
    }
    
    public static function query($sql, $args=array() ) {
        $db = self::connect();
        $st = $db->prepare($sql);
        $st->execute($args);
        $res = $st->fetchAll(PDO::FETCH_ASSOC);
        self::disconnect();
        return $res;
    }
    
    public static function insert($sql, $args=array() ) {
        $db = self::connect();
        $st = $db->prepare($sql);
        $st->execute($args);
        $ok = $st->rowCount() ? true : false;
        self::disconnect();
        return $ok;
    }
}

?>