<?php

/*
 *
 *  Filename: crud.php
 *  Author: Matija Belec (matijabelec1@gmail.com)
 *  Date: 9 June 2015
 *  Description:
 *      - singleton used for CRUD operations
 *  Requirements:
 *      - config.php
 *      - database.php
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Crud {
    protected $table_name = null;
    protected $obj_data = null;
    
    public function __construct($name=null) {
        $this->table_name = $name;
    }
    public function __destruct() {
        $this->table_name = null;
    }
    
    public function create() {
        if(is_null($this->table_name) )
            return false;
        if(is_null($this->obj_data) )
            return false;
        $this->$obj_data->create();
        return true;
    }
    public function read() {
        if(is_null($this->table_name) )
            return false;
        if(is_null($this->obj_data) )
            return false;
        $this->$obj_data->read();
        return true;
    }
    public function update() {
        if(is_null($this->table_name) )
            return false;
        if(is_null($this->obj_data) )
            return false;
        $this->$obj_data->update();
        return true;
    }
    public function delete() {
        if(is_null($this->table_name) )
            return false;
        if(is_null($this->obj_data) )
            return false;
        $this->$obj_data->delete;
        return true;
    }
}

?>