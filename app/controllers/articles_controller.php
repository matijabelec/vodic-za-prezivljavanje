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
        Auth::login_check();
        
        if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $articles = Data_model::get_articles();
            echo $this->view->view($articles);
        } else
            return RET_ERR;
    }
    
    public function read($args) {
        Auth::login_check();
        
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        $articleid = $args[URL_ARG_1];
        
        if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $userid = Auth::userid();
            
            $article = Data_model::get_article($articleid);
            $comments = Data_model::get_comments_for_article($articleid);
            
            $grade = Data_model::get_article_grade_by_subscriber($articleid, $userid);
            $gradescnt = Data_model::get_article_grade($articleid);
            
            echo $this->view->read($article, $comments, $grade, $gradescnt);
        } elseif(Auth::role_check(PROJECT_USER_ROLE_MODERATOR) || 
                 Auth::role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            $userid = Auth::userid();
            
            if(!Data_model::check_area_subscription_by_article($articleid, $userid) ) {
                return RET_ERR;
            }
            $article = Data_model::get_article($articleid);
            $comments = Data_model::get_comments_for_article($articleid);
            
            $grade = Data_model::get_article_grade_by_subscriber($articleid, $userid);
            $gradescnt = Data_model::get_article_grade($articleid);
            
            $rate = true;
            $articledata = Data_model::get_article($articleid);
            $areaid = $articledata['id_podrucja'];
            if(Data_model::check_area_moderation($areaid, $userid) )
                $rate = false;
            
            echo $this->view->read($article, $comments, $grade, $gradescnt, $rate);
        } else
            return RET_ERR;
    }
    
    public function create($args) {
        Auth::login_check();
        
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        $areaid = $args[URL_ARG_1];
        
        if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) || 
           Auth::role_check(PROJECT_USER_ROLE_MODERATOR) ) {
            $userid = Auth::userid();
            
            if(!Data_model::check_area_moderation($areaid, $userid) ) {
                return RET_ERR;
            }
            
            if(isset($_POST['naslov']) ) {
                $article = $_POST;
                $article['datum_objave'] = Server_time::get_virtualTime();
                $article['id_podrucja'] = $areaid;
                $article['id_korisnika'] = $userid;
                $article['status'] = 1;
                
                if(Data_model::create_article($article) )
                    Redirect('/areas/read/' . $areaid);
            }
            
            $article = Data_model::get_empty_article();
            $article['link-back'] = 'areas/read/' . $areaid;
            $article['link'] = 'articles/create/' . $areaid;
            $article['status'] = 1;
            echo $this->view->create($article);
        } else
            return RET_ERR;
    }
    
    
    public function grade($args) {
        Auth::login_check();
        
        if(Auth::role_check(PROJECT_USER_ROLE_GUEST) )
            RET_ERR;
        
        if(count($args) < URL_ARGUMENTS_2)
            return RET_ERR;
        
        $userid = Auth::userid();
        $articleid = $args[URL_ARG_1];
        $gradecnt = $args[URL_ARG_2];
        
        if(!Data_model::check_area_subscription_by_article($articleid, $userid) )
            Redirect('/articles/read/' . $articleid);
        
        $articledata = Data_model::get_article($articleid);
        $areaid = $articledata['id_podrucja'];
        
        if(Data_model::check_area_moderation($areaid, $userid) )
            Redirect('/articles/read/' . $articleid);
        
        if($gradecnt=='0') {
            if(Data_model::ungrade_article($articleid, $userid) )
                Redirect('/articles/read/' . $articleid);
            exit;
        } elseif($gradecnt=='1' || 
                 $gradecnt=='2' || 
                 $gradecnt=='3' || 
                 $gradecnt=='4' || 
                 $gradecnt=='5') {
            $grade['id_korisnika'] = $userid;
            $grade['id_clanka'] = $articleid;
            $grade['ocjena'] = $gradecnt;
            $grade['datum_ocjene'] = Server_time::get_virtualTime();
            if(Data_model::grade_article($grade) )
                Redirect('/articles/read/' . $articleid);
            exit;
        }
        Redirect('/articles/read/' . $articleid);
    }
    
    
    public function ajax($args) {
        Auth::login_check();
        
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
                    } elseif(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
                        $areaid = $args[URL_ARG_2];
                        $articles = Data_model::get_articles_for_area($areaid);
                        echo $this->view->ajax_view_reg($articles);
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