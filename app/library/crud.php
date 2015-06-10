<?php

/*
 *
 *  Filename: crud.php
 *  Author: Matija Belec (matijabelec1@gmail.com)
 *  Date: 9 June 2015
 *  Description:
 *      - [none]
 *  Requirements:
 *      - config.php
 *      - database.php
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Crud {
    protected function __construct() {}
    protected function __destruct() {}
    
    public static function create($template) {
        $dt = new Template('data/' . $template);
        $cr = new Template('data/crud-create');
        $cr->set('data', $dt->fill() );
        return $cr->fill();
    }
    public static function read($template, $data) {
        $dt = new Template('data/' . $template);
        if(is_array($data) && count($data)==1) {
            foreach($data[0] as $key=>$val) {
                $dt->set($key, $val);
            }
        }
        $cr = new Template('data/crud-create');
        $cr->set('data', $dt->fill() );
        return $cr->fill();
    }
    public static function update($template, $data) {
        $dt = new Template('data/' . $template);
        if(is_array($data) && count($data)==1) {
            foreach($data[0] as $key=>$val) {
                $dt->set($key, $val);
            }
        }
        $cr = new Template('data/crud-create');
        $cr->set('data', $dt->fill() );
        return $cr->fill();
    }
    public static function delete($template, $data) {
        $dt = new Template('data/' . $template);
        if(is_array($data) && count($data)==1) {
            foreach($data[0] as $key=>$val) {
                $dt->set($key, $val);
            }
        }
        $cr = new Template('data/crud-create');
        $cr->set('data', $dt->fill() );
        return $cr->fill();
    }
    
    public static function view($template, $data) {
        return '';
    }
    
    
    public static function get_html_c($url) {
        $url = WEBSITE_ROOT_PATH . $url;
        $btn_create = '<a class="btn" href="' . $url . '/crud/create">Dodaj</a>';
        return $btn_create;
    }
    public static function get_html_rud($url, $id) {
        $url = WEBSITE_ROOT_PATH . $url;
        $btn_read = '<a class="btn" href="' . $url . '/crud/read' . $id . '">R</a>';
        $btn_update = '<a class="btn" href="' . $url . '/crud/update' . $id . '">U</a>';
        $btn_delete = '<a class="btn" href="' . $url . '/crud/delete' . $id . '">D</a>';
        return $btn_read . $btn_update . $btn_delete;
    }
    public static function get_html_ru($url, $id) {
        $url = WEBSITE_ROOT_PATH . $url;
        $btn_read = '<a class="btn" href="' . $url . '/crud/read' . $id . '">R</a>';
        $btn_update = '<a class="btn" href="' . $url . '/crud/update' . $id . '">U</a>';
        return $btn_read . $btn_update;
    }
}

?>