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
    
    static public function getInstance() {
        if(is_null(self::$instance) ) {
            self::$instance = new ServerTime();
        }
        return self::$instance;
    }
    
    function setTime() {
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
        
        self::$server_time = time();
        self::$system_time = $vrijeme_servera + (self::$hours * 3600);
    }
    
    function getVirtualTime() {
        if(!is_null(self::$hours) )
            return self::$system_time;
    }
    function getRealTime() {
        if(!is_null(self::$hours) )
            return self::$server_time;
    }
}

?>