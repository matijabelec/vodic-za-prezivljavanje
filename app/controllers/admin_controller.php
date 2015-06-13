<?php

class Admin_controller extends Controller {
    public function __construct() {
        $this->view = new Admin_view;
        $this->model = new Admin_model;
    }
    
    public function index() {
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Redirect('/admin/view');
        } else
            return RET_ERR;
    }
    
    public function view() {
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            // get users
            $time = $this->model->get_time();
            echo $this->view->time($time);
        } else
            return RET_ERR;
    }
    
    public function time() {
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $this->model->set_time();
            Redirect('/admin/view');
        } else
            return RET_ERR;
    }
}

?>