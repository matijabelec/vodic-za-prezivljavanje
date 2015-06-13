<?php

class Comments_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Comments_view;
        $this->model = new Comments_model;
    }
    
    public function index($args) {
        return RET_ERR;
    }
}

?>