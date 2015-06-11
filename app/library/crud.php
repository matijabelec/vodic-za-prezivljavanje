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
    
    public static function get_html_c($url) {
        $url = WEBSITE_ROOT_PATH . $url;
        $btn_create = '<a class="btn" href="' . $url . '/create">Dodaj</a>';
        return $btn_create;
    }
    public static function get_html_rud($url, $id) {
        $url = WEBSITE_ROOT_PATH . $url;
        $btn_read = '<a class="btn" href="' . $url . '/read' . $id . '">R</a>';
        $btn_update = '<a class="btn" href="' . $url . '/update' . $id . '">U</a>';
        $btn_delete = '<a class="btn" href="' . $url . '/delete' . $id . '">D</a>';
        return $btn_read . $btn_update . $btn_delete;
    }
    public static function get_html_ru($url, $id) {
        $url = WEBSITE_ROOT_PATH . $url;
        $btn_read = '<a class="btn" href="' . $url . '/read' . $id . '">R</a>';
        $btn_update = '<a class="btn" href="' . $url . '/update' . $id . '">U</a>';
        return $btn_read . $btn_update;
    }
}

?>