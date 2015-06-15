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
    //protected static $url = "http://arka.foi.hr/PzaWeb/PzaWeb2004/config/pomak.xml";
    protected static $url = "http://arka.foi.hr/WebDiP/pomak_vremena/pomak.php?format=xml";
    
    protected function __construct() {}
    protected function __destruct() {}
    
    public static function set_time() {
        if($fp=fopen(self::$url, 'r') ) {
            $xml_string = fread($fp, 10000);
            fclose($fp);            
            $xml = simplexml_load_string($xml_string);
            $hours = $xml->vrijeme->pomak->brojSati;
            Data_model::set_systemtime($hours);
        }
    }
    
    public static function get_virtualTime() {
        $hours = Data_model::get_systemtime();
        $server_time = time();
        $system_time = $server_time + ($hours * 3600);
        return date("Y-m-d H:i:s", $system_time);
    }
}

?>