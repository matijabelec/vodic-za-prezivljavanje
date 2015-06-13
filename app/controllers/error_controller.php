<?php

class Error_controller extends Controller {
    public function __construct() {
        $this->view = new Error_view;
    }
    
    public function index() {
        echo $this->view->output();
    }
}

?>