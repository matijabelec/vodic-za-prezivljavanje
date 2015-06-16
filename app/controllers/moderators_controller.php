<?php

class Moderators_controller extends Controller {
    public function __construct() {
        $this->view = new Moderators_view;
        $this->model = new Moderators_model;
    }
    
    public function index($args) {
        Auth::login_check();
        
        Redirect('/moderators/view');
    }
    
    public function view($args) {
        Auth::login_check();
        
        if(!Auth::role_check(PROJECT_USER_ROLE_ADMIN) )
            return RET_ERR;
        
        $moderators = Data_model::get_moderations();
        echo $this->view->view($moderators);
    }
    
    public function create($args) {
        Auth::login_check();
        
        if(!Auth::role_check(PROJECT_USER_ROLE_ADMIN) )
            return RET_ERR;
        
        $argc = count($args);
        
        if($argc == URL_ARGUMENTS_1) {
            $areaid = $args[URL_ARG_1];
            if(isset($_POST['id_korisnika']) ) {
                $moderatorid = $_POST['id_korisnika'];
                if(Data_model::create_moderator_for_area($areaid, $moderatorid) )
                    Redirect('/areas/read/' . $areaid);
                Redirect('/moderators/create/' . $areaid);
            }
        }
        
        $users = Data_model::get_users();
        echo $this->view->create($areaid, $users);
    }
    
    public function delete($args) {
        Auth::login_check();
        
        return RET_ERR;
        /*
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        if(Auth::role_check(PROJECT_USER_ROLE_GUEST) )
            return RET_ERR;
        
        if(Auth::role_check(PROJECT_USER_ROLE_MODERATOR) ) {
            
        }
        
        $user = Auth::get_user();
        $userid = $user['userid'];
        $articleid = $args[URL_ARG_1];
        
        if(isset($_POST['id_clanka']) ) {
            $comment = $_POST;
            $ok = $this->model->delete($comment);
            if($ok)
                Redirect('/articles/read/' . $articleid);
        }
        
        echo $this->view->crud_create($userid, $articleid);*/
    }
}

?>