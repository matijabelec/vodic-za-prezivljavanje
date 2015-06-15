<?php

class Subscribes_controller extends Controller {
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
        if(Auth::role_check(PROJECT_USER_ROLE_GUEST) ) {
            Redirect('/');
        }
        
        $areaid = $args[URL_ARG_1];
        
        $userid = Auth::userid();
        
        if($this->model->subscribe($userid, $areaid) )
            Redirect('/areas/read/' . $areaid);
        
        Redirect('/areas/view');
    }
    
    public function delete($args) {
        if(count($args) != URL_ARGUMENTS_1)
            return RET_ERR;
        
        // if user is guest
        if(Auth::role_check(PROJECT_USER_ROLE_GUEST) ) {
            Redirect('/');
        }
        
        $areaid = $args[URL_ARG_1];
        
        $userid = Auth::userid();
        
        if($this->model->unsubscribe($userid, $areaid) )
            Redirect('/areas/read/' . $areaid);
        
        Redirect('/areas/view');
    }
}

?>