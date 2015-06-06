<?php

class Index_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Index_view;
    }
    
    public function index() {
        if(Auth::login_check() == true) {
            echo $this->view->admin();
        } else
            echo $this->view->output();
    }
}

?>