<?php

class Error_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Error_view;
    }
    
    public function index() {
        echo $this->view->output();
    }
}

?>