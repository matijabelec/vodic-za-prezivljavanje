<?php

class Subscribes_controller extends Webpage_controller {
    public function __construct() {
        $this->model = new Subscribes_model;
    }
    
    public function index($args) {
        Redirect('/areas/view');
    }
    
    public function view($args) {
        return RET_ERR;
    }
    
    public function create($args) {
        if(count($args) != URL_ARGUMENTS_1)
            return RET_ERR;
        
        // if user is guest
        if(Auth::user_role_check(PROJECT_USER_ROLE_GUEST) ) {
            Redirect('/');
        }
        
        $areaid = $args[URL_ARG_1];
        
        $user = Auth::get_user();
        
        if($this->model->subscribe($user['userid'], $areaid) )
            Redirect('/areas/read/' . $areaid);
        
        Redirect('/areas/view');
    }
    
    public function delete($args) {
        if(count($args) != URL_ARGUMENTS_1)
            return RET_ERR;
        
        // if user is guest
        if(Auth::user_role_check(PROJECT_USER_ROLE_GUEST) ) {
            Redirect('/');
        }
        
        $areaid = $args[URL_ARG_1];
        
        $user = Auth::get_user();
        
        if($this->model->unsubscribe($user['userid'], $areaid) )
            Redirect('/areas/read/' . $areaid);
        
        Redirect('/areas/view');
    }
}

?>