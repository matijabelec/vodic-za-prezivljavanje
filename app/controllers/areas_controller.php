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
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
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