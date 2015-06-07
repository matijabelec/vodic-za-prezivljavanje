<?php

/*
 *
 *  Filename: cacher.php
 *  Author: Matija Belec (hackerma3x@gmail.com)
 *  Date: 5 March 2015
 *  Description:
 *      - singleton that represents a file loader with cache
 *      - every file which is loaded is cached in $files (using method load)
 *      - if any file wants to be removed from cache it can be with method unload
 *  Requirements:
 *      - [none]
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Cacher {
    static private $files = array();
    
    protected function __construct() {}
    protected function __destruct() {}
    
    static public function load($filename) {
        // check if template is already cached
        foreach(self::$files as $file)
            if($file['filename'] == $filename)
                return $file['data'];
        
        // check if template exists
        if(file_exists($filename) ) {
            $data = file_get_contents($filename);
            self::$files[] = array('filename'=>$filename, 'data'=>$data);
            return $data;
        }
        
        trigger_error("[Cacher]: '$filename' can't be loaded!", E_USER_WARNING);
        return RET_ERR;
    }
    
    static public function unload($filename) {
        // check if template is cached
        foreach(self::$files as $file)
            if($file['filename'] == $filename) {
                unset($file);
                return RET_OK;
            }
        return RET_ERR;
    }
}

?>