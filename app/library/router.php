<?php

/*
 *
 *  Filename: router.php
 *  Author: Matija Belec (hackerma3x@gmail.com)
 *  Date: 6 March 2015
 *  Description:
 *      - singleton that represents a routing to existing webpage(controller->action) or
 *          route to error webpage
 *  Requirements:
 *      - config.php
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Router {
    public function __construct() {
        trigger_error("[Router]: Not allowed.", E_USER_ERROR);
    }
    
    static public function route($url) {
        if(isset($url) && ''!=$url && '/'!='$url') {
            if('/' == substr($url, -1, 1) )
                $url = substr($url, 0, -1);
            $array = explode('/', $url);
            $controller = $array[0];
            $action = isset($array[1]) ? $array[1] : ACTION_DEFAULT;
            $args = $array;
        } else {
            $controller = CONTROLLER_DEFAULT;
            $action = ACTION_DEFAULT;
            $args = null;
        }
        
        $class = ucfirst($controller) . '_controller';
        $method = $action;
        
        if(class_exists($class) && method_exists($class, $method) && is_callable([$class, $method]) ) {
            $obj = new $class;
            //if(true === is_a($obj, "Webpage_controller") ) {
                $status = $obj->$method($args);
                if(null === $status) return;
            //}
        }
        
        $class = ucfirst(CONTROLLER_ERROR) . '_controller';
        $method = ACTION_DEFAULT;
        (new $class)->$method(null);
    }
}

?>