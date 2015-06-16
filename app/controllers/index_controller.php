<?php

class Index_controller extends Controller {
    public function __construct() {
        Auth::login_check();
        
        $this->view = new Index_view;
    }
    
    public function index($args) {
        Auth::login_check();
        
        if(!is_null($args) )
            Redirect('/');
        
        if(Auth::login_check() == true) {
            if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
                echo $this->view->admin();
            } else {
                echo $this->view->admin();
            }
        } else {
            echo $this->view->output();
        }
    }
}

?>