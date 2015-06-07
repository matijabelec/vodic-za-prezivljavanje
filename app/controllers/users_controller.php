<?php

class Users_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Users_view;
        $this->model = new Users_model;
    }
    
    public function index($args) {
        if(count($args) != URL_INDEX_ARGUMENTS_NONE)
            return RET_ERR;
        
        Redirect('/users/view');
        
        //echo $this->view->output();
    }
    
    public function view($args) {
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        $users = $this->model->get_users();
        echo $this->view->view($users);
    }
}

?>