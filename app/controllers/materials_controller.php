<?php

class Materials_controller extends Controller {
    public function __construct() {}
    
    public function create($args) {
        Auth::login_check();
        
        if(Auth::role_check(PROJECT_USER_ROLE_GUEST) )
            Redirect('/');
        
        if(count($args) == URL_ARGUMENTS_1) {
            $articleid = $args[URL_ARG_1];
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
        
        if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
            if(count($args) == URL_ARGUMENTS_1) {
                $materialid = $args[URL_ARG_1];
                Data_model::delete_material($materialid);
                Redirect('/articles/read/' . $articleid);
            }
            return RET_ERR;
        }
        
        if(count($args) == URL_ARGUMENTS_1) {
            $materialid = $args[URL_ARG_1];
            $userid = Auth::userid();
            if(Data_model::check_material_owner($materialid, $userid) ) {
                if(Data_model::delete_material($materialid) ) 
                    Redirect('/articles/read/' . $articleid);
                Redirect('/articles/read/' . $articleid);
            }
        }
        return RET_ERR;
    }
}

?>