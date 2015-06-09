<?php

class Areas_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Areas_view;
        $this->model = new Areas_model;
    }
    
    public function index($args) {
        if(count($args) != URL_INDEX_ARGUMENTS_NONE)
            return RET_ERR;
        
        Redirect('/areas/view');
    }
    
    public function view($args) {
        $args_n = count($args);
        if($args_n > URL_ARGUMENTS_1)
            return RET_ERR;
        
        if($args_n == URL_ARGUMENTS_1) {
            switch($args[URL_ARG_1]) {
                case 'create':
                    break;
            }
        }
        
        $user = null;
        if(Auth::login_check() != false) {
            $user = Auth::get_user();
        }
        
        $areas = $this->model->get_areas();
        
        if(is_null($user) ) {
            echo $this->view->view($areas);
        } else {
            echo $this->view->view_auth($user, $areas);
        }
    }
    
    public function edit($args) {
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        if(Auth::login_check() == false) {
            Redirect('/areas/view');
        }
        
        $user = Auth::get_user();
        $areas = $this->model->get_areas();
        
        echo $this->view->edit_auth($user, $areas);
    }
}

?>