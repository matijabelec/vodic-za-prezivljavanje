<?php

class Error_controller extends Controller {
    public function __construct() {
        Auth::login_check();
        
        $this->view = new Error_view;
    }
    
    public function index() {
        Auth::login_check();
        
        echo $this->view->output();
    }
}

?>