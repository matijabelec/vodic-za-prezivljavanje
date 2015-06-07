<?php

/*
 *
 *  Filename: template.php
 *  Author: Matija Belec (hackerma3x@gmail.com)
 *  Date: 6 March 2015
 *  Description:
 *      - class that represents a HTML template (file with extension .tpl)
 *      - class can manipulate with data on template (methods set and get)
 *      - all data is "baked" on template with method fill
 *  Requirements:
 *      - Cacher
 *  
 *  Copyright 2014. Matija Belec. All Rights reserved.
 *  
 */

class Template {
    private $inline = null;
    private $filename = null;
    private $data = array();
    
    public function __construct($template, $inline=false) {
        if(false === $inline) {
            $this->filename = DIR_TEMPLATES."$template.tpl";
            if(RET_ERR === Cacher::load($this->filename) )
                $this->filename = null;
        } else {
            $this->inline = $template;
        }
    }
    
    public function set($key, $val, $overwrite=true) {
        // check if key can be overwritten
        if(false == $overwrite) {
            if(isset($key) )
                return RET_ERR;
            $this->data[$key] = $val;
            return RET_OK;
        }
        
        $this->data[$key] = $val;
        return RET_OK;
    }
    
    public function get($key) {
        if(isset($this->data[$key]) )
            return $this->data[$key];
        return RET_ERR;
    }
    
    public function fill() {
        if(null != $this->filename) {
            $filled = Cacher::load($this->filename);
            foreach($this->data as $key=>$val)
                $filled = str_replace("{@$key}", $val, $filled);
            return $filled;
        }
        
        if(null != $this->inline) {
            $filled = $this->inline;
            foreach($this->data as $key=>$val)
                $filled = str_replace("{@$key}", $val, $filled);
            return $filled;
        }
        
        return RET_ERR;
    }
}

?>