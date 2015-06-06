<?php

class Index_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Index_view;
    }
    
    public function index() {
        echo $this->view->output();
    }
}

?>