<?php

class Index_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Index_view;
    }
    
    public function index() {
        if(Auth::login_check() == true) {
            if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
                echo $this->view->admin();
            }
        } else {
            echo $this->view->output();
        }
    }
}

?>