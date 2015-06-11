<?php

/*
 *
 *  Filename: server_time.php
 *  Author: Matija Belec (matijabelec1@gmail.com)
 *  Date: 6 June 2015
 *  Description:
 *      - [no-decsription]
 *  Requirements:
 *      - [none]
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Server_time {
    protected static $instance = null;
    protected static $url = "http://arka.foi.hr/PzaWeb/PzaWeb2004/config/pomak.xml";
    protected static $hours = null;
    protected static $server_time;
    protected static $system_time;
    
    protected function __construct() {}
    protected function __destruct() {}
    
    public static function set_time() {
        if(!($fp = fopen(self::$url, 'r') ) ) {
            echo "Error: url '$url' is not reachable!";
            exit;
        }
        $xml_string = fread($fp, 10000);
        fclose($fp);
        
        $domdoc = new DOMDocument;
        $domdoc->loadXML($xml_string);
        $params = $domdoc->getElementsByTagName('pomak');
        
        self::$hours = 0;
        foreach ($params as $param) {
            $attr = $param->attributes;
            foreach($attr as $key => $val)
                if("brojSati" == $key)
                    self::$hours = $val->value;
        }
        
        //Database::query("CREATE TABLE IF NOT EXISTS vrijeme_sustava(id SERIAL PRIMARY KEY, trenutno_vrijeme INTEGER)");
        //Database::query("INSERT INTO vrijeme_sustava(trenutno_vrijeme) VALUES(:time)", array('time'=>self::$hours) );
        Database::query("UPDATE TABLE vrijeme_sustava SET trenutno_vrijeme = :time WHERE id = 1", array('time'=>self::$hours) );
    }
    
    public static function get_virtualTime() {
        self::$server_time = time();
        self::$system_time = self::$server_time + (self::$hours * 3600);
        if(!is_null(self::$hours) )
            return self::$system_time;
    }
    public static function get_realTime() {
        self::$server_time = time();
        if(!is_null(self::$hours) )
            return self::$server_time;
    }
    
    public static function get_saved_time() {
        $result = Database::query("SELECT trenutno_vrijeme FROM vrijeme_sustava");
        if(count($result) == 1) {
            $time = $result[0];
            self::$hours = $time['trenutno_vrijeme'];
            return self::get_virtualTime();
        }
    }
    /*public static function get_saved_time_str() {
        return date("Y-m-d H:i:s");
    }*/
}

?>