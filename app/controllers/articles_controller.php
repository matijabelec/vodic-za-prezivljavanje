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
        if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $articles = Data_model::get_articles();
            echo $this->view->view($articles);
        } else
            return RET_ERR;
    }
    
    public function read($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        $articleid = $args[URL_ARG_1];
        
        if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $article = Data_model::get_article($articleid);
            $comments = Data_model::get_comments_for_article($articleid);
            echo $this->view->read($article, $comments);
        } elseif(Auth::role_check(PROJECT_USER_ROLE_MODERATOR) || 
                 Auth::role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            $userid = Auth::userid();
            
            if(!Data_model::check_area_subscription_by_article($articleid, $userid) ) {
                return RET_ERR;
            }
            $article = Data_model::get_article($articleid);
            $comments = Data_model::get_comments_for_article($articleid);
            echo $this->view->read($article, $comments);
        } else
            return RET_ERR;
    }
    
    public function create($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        $areaid = $args[URL_ARG_1];
        
        if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
            /*$article = $this->model->get_article($articleid);
            $comments = $this->model->get_comments_for_article($articleid);
            echo $this->view->read($article, $comments);*/
        } elseif(Auth::role_check(PROJECT_USER_ROLE_MODERATOR) || 
                 Auth::role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            $userid = Auth::userid();
            
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
    
    
    
    
    
    public function ajax($args) {
        $argc = count($args);
        if($argc >= URL_ARGUMENTS_1) {
            switch($args[URL_ARG_1]) {
                case 'articles-for-area':
                    if($argc < URL_ARGUMENTS_2)
                        break;
                    if(Auth::role_check(PROJECT_USER_ROLE_GUEST) ) {
                        $areaid = $args[URL_ARG_2];
                        $articles = Data_model::get_articles_for_area($areaid);
                        echo $this->view->ajax_view($articles);
                    } else {
                        $areaid = $args[URL_ARG_2];
                        $userid = Auth::userid();
                        $articles = Data_model::get_articles_for_area($areaid);
                        if(Data_model::check_area_subscription($areaid, $userid) )
                            echo $this->view->ajax_view_reg($articles);
                        else
                            echo $this->view->ajax_view($articles);
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