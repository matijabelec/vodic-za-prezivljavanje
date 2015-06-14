<?php

class Articles_controller extends Controller {
    public function __construct() {
        $this->view = new Articles_view;
        $this->model = new Articles_model;
    }
    
    public function index($args) {
        Redirect('/articles/view');
    }
    
    public function view($args) {
        $argc = count($args);
        if($argc != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $articles = $this->model->get_active_articles();
            echo $this->view->view($articles);
        } else
            return RET_ERR;
    }
    
    public function read($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        $articleid = $args[URL_ARG_1];
        
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $article = $this->model->get_article($articleid);
            $comments = $this->model->get_comments_for_article($articleid);
            echo $this->view->read($article, $comments);
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_MODERATOR) || 
                 Auth::user_role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            $user = Auth::get_user();
            $userid = $user['userid'];
            
            if(!$this->model->check_subscribed_to_articles_area($userid, $articleid) ) {
                return RET_ERR;
            }
            
            $article = $this->model->get_article($articleid);
            $comments = $this->model->get_comments_for_article($articleid);
            echo $this->view->read($article, $comments);
        } else
            return RET_ERR;
    }
    
    public function create($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        $areaid = $args[URL_ARG_1];
        
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            /*$article = $this->model->get_article($articleid);
            $comments = $this->model->get_comments_for_article($articleid);
            echo $this->view->read($article, $comments);*/
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_MODERATOR) || 
                 Auth::user_role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            $user = Auth::get_user();
            $userid = $user['userid'];
            
            if(!$this->model->check_moderation_for_area($userid, $areaid) ) {
                return RET_ERR;
            }
            
            return RET_ERR;
            
            /*
            $article = $this->model->get_article($articleid);
            $comments = $this->model->get_comments_for_article($articleid);
            echo $this->view->read($article, $comments);*/
        } else
            return RET_ERR;
    }
}

?>