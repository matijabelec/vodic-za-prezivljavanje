<?php

class Admin_controller extends Controller {
    public function __construct() {
        $this->view = new Admin_view;
    }
    
    public function index() {
        if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Redirect('/admin/view');
        } else
            return RET_ERR;
    }
    
    public function view() {
        if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $time = Server_time::get_virtualTime();
            echo $this->view->time($time);
        } else
            return RET_ERR;
    }
    
    public function time() {
        if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Server_time::set_time();
            Redirect('/admin/view');
        } else
            return RET_ERR;
    }
}

?>