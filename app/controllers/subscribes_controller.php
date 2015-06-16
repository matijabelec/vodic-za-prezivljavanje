<?php

class Subscribes_controller extends Controller {
    public function __construct() {
        $this->model = new Subscribes_model;
    }
    
    public function create($args) {
        Auth::login_check();
        
        if(Auth::role_check(PROJECT_USER_ROLE_GUEST) )
            Redirect('/');
        
        if(count($args) == URL_ARGUMENTS_1) {
            $areaid = $args[URL_ARG_1];
            $userid = Auth::userid();
            if($this->model->subscribe($userid, $areaid) )
                Redirect('/areas/read/' . $areaid);
            Redirect('/areas/view');
        }
        return RET_ERR;
    }
    
    public function delete($args) {
        Auth::login_check();
        
        if(Auth::role_check(PROJECT_USER_ROLE_GUEST) )
            Redirect('/');
        
        if(count($args) == URL_ARGUMENTS_1) {
            $areaid = $args[URL_ARG_1];
            $userid = Auth::userid();
            if($this->model->unsubscribe($userid, $areaid) )
                Redirect('/areas/read/' . $areaid);
            Redirect('/areas/view');
        }
        return RET_ERR;
    }
}

?>