<?php

class Comments_controller extends Controller {
    public function __construct() {
        $this->view = new Comments_view;
        $this->model = new Comments_model;
    }
    
    public function index($args) {
        return RET_ERR;
    }
    
    public function create($args) {
        Auth::login_check();
        
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        if(Auth::role_check(PROJECT_USER_ROLE_GUEST) )
            return RET_ERR;
        
        $userid = Auth::userid();
        $articleid = $args[URL_ARG_1];
        
        if(isset($_POST['id_clanka']) ) {
            $comment = $_POST;
            $comment['status'] = 1;
            $comment['datum_objave'] = Server_time::get_virtualTime();
            $ok = Data_model::comment_article($comment);
            if($ok)
                Redirect('/articles/read/' . $articleid);
        }
        
        echo $this->view->create($userid, $articleid);
    }
    
    public function delete($args) {
        Auth::login_check();
        
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        if(Auth::role_check(PROJECT_USER_ROLE_GUEST) )
            return RET_ERR;
        
        if(Auth::role_check(PROJECT_USER_ROLE_MODERATOR) ) {
            
        }
        
        $userid = Auth::userid();
        $articleid = $args[URL_ARG_1];
        
        if(isset($_POST['id_clanka']) ) {
            $comment = $_POST;
            $ok = $this->model->delete($comment);
            if($ok)
                Redirect('/articles/read/' . $articleid);
        }
        return RET_ERR;
    }
    
    
    
    public function ajax($args) {
        Auth::login_check();
        
        $argc = count($args);
        if($argc >= URL_ARGUMENTS_1) {
            switch($args[URL_ARG_1]) {
                case 'comments-for-article':
                    if($argc < URL_ARGUMENTS_2)
                        break;
                    if(!Auth::role_check(PROJECT_USER_ROLE_GUEST) ) {
                        $articleid = $args[URL_ARG_2];
                        $comments = Data_model::get_comments_for_article($articleid);
                        echo $this->view->ajax_view($comments);
                    }
                    return;
                default:
                    break;
            }
        }
        return;
    }
}

?>