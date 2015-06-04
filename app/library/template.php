<?php

class Template {
    protected $filename = null;
    protected $data = null;
    protected $template = '';
    protected $modified = true;
    
    public function __construct() {}
    public function __destruct() {}
    
    // load template
    public function load($file) {
        $filename = $file;
        
        //TODO: load template from file and "save" it to $template
        
        $modified = true;
    }
    public function getFilename() {
        if($filename !== null)
            return $filename;
    }
    
    // fill template & get filled template
    public function set($key='', $val='') {
        if($data === null)
            return false;
        $data[$key] = $val;
        $modified = true;
        return true;
    }
    public function get($key='') {
        if($data !== null && isset($data[$key]) )
            return $data[$key];
    }
    public function fill() {
        if($modified !== false) {
            
            //TODO: fill template with data
            
            $modified = false;
        }
        return $template;
    }
}

?>