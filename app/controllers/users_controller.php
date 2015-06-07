<?php

class Users_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Users_view;
        $this->model = new Users_model;
    }
    
    public function index($args) {
        if(count($args) != URL_INDEX_ARGUMENTS_NONE)
            return RET_ERR;
        
        echo $this->view->output();
    }
    
    public function view($args) {
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        echo ' -data- ';
        $users = $this->model->get_users();
        foreach($users as $user) {
            print_r($user);
        }
        echo count($users);
        
        echo ' -data- ';
        exit;
        
        echo $this->view->output();
    }
}

?>