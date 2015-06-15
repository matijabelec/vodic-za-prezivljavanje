<?php

class Moderators_controller extends Controller {
    public function __construct() {
        $this->view = new Moderators_view;
        $this->model = new Moderators_model;
    }
    
    public function index($args) {
        Redirect('/moderators/view');
    }
    
    public function view($args) {
        if(!Auth::role_check(PROJECT_USER_ROLE_ADMIN) )
            return RET_ERR;
        
        $moderators = $this->model->get_moderators();
        echo $this->view->view($moderators);
    }
    
    public function create($args) {
        if(!Auth::role_check(PROJECT_USER_ROLE_ADMIN) )
            return RET_ERR;
        
        $argc = count($args);
        
        $moderation = array('id_korisnika'=>0,
                            'id_podrucja'=>0,
                            'status'=>1);
        
        if($argc == URL_ARGUMENTS_2) {
            $userid = $args[URL_ARG_1];
            $areaid = $args[URL_ARG_2];
            $ok = $this->model->add_moderation($userid, $areaid);
            if($ok)
                Redirect('/moderators/view');
        } else {
            if(isset($_POST['id_korisnika']) && isset($_POST['id_podrucja']) ) {
                $moderation = $_POST;
                $userid = $moderation['id_korisnika'];
                $areaid = $moderation['id_podrucja'];
                $ok = $this->model->add_moderation($userid, $areaid);
                if($ok)
                    Redirect('/moderators/view/' . $articleid);
            }
        }
        
        echo $this->view->crud_create($moderation);
        
        /*if(Auth::role_check(PROJECT_USER_ROLE_GUEST) )
            return RET_ERR;
        
        $user = Auth::get_user();
        $userid = $user['userid'];
        $articleid = $args[URL_ARG_1];
        
        if(isset($_POST['id_clanka']) ) {
            $comment = $_POST;
            $ok = $this->model->comment($comment);
            if($ok)
                Redirect('/articles/read/' . $articleid);
        }
        
        echo $this->view->crud_create($userid, $articleid);*/
    }
    
    public function delete($args) {
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