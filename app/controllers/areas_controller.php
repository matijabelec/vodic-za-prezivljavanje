<?php

class Areas_controller extends Controller {
    public function __construct() {
        $this->view = new Areas_view;
    }
    
    public function index($args) {
        Redirect('/areas/view');
    }
    
    public function view($args) {
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        if(Auth::role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $areas = Data_model::get_areas();
            $areas2 = Data_model::get_deleted_areas();
            echo $this->view->view_admin($areas, $areas2);
        } elseif (Auth::role_check(PROJECT_USER_ROLE_MODERATOR) ) {
            $userid = Auth::userid();
            $areas = Data_model::get_areas_for_moderator($userid);
            $areas2 = Data_model::get_areas_not_for_moderator($userid);
            echo $this->view->view_mod($areas, $areas2);
        } elseif(Auth::role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            $areas = Data_model::get_areas();
            echo $this->view->view_reg($areas);
        } else {
            $areas1 = Data_model::get_areas();
            echo $this->view->view($areas1);
        }
    }
    
    public function create($args) {
        if(count($args) == URL_ARGUMENTS_1) {
            $areaid = $args[URL_ARG_1];
            if(Data_model::undelete_area($areaid) )
                Redirect('/areas/view');
        }
        
        // if user is not admin
        if(!Auth::role_check(PROJECT_USER_ROLE_ADMIN) )
            Redirect('/areas/view');
        
        // check if data sent
        if(isset($_POST['id_podrucja']) ) {
            $area = $_POST;
            if(Data_model::create_area($area) )
                Redirect('/areas/view');
        } else
            $area = Data_model::get_empty_area();
        $area['link-back'] = 'areas/view';
        $area['link'] = 'areas/create';
        $area['status'] = 1;
        echo $this->view->create($area);
    }
    
    public function read($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        $areaid = $args[URL_ARG_1];
        $area =  Data_model::get_area_by_id($areaid);
        if(count($area) == 0)
            return RET_ERR;
        
        $articles = Data_model::get_articles_for_area($areaid);
        
        if(Auth::role_check(PROJECT_USER_ROLE_GUEST) ) {
            echo $this->view->read($area, $articles);
        } elseif(Auth::role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            $userid = Auth::userid();
            $subs = !Data_model::check_area_subscription($areaid, $userid);
            echo $this->view->read_reg($area, $articles, $subs);
        } elseif(Auth::role_check(PROJECT_USER_ROLE_MODERATOR) ) {
            $userid = Auth::userid();
            if(Data_model::check_area_moderation($areaid, $userid) )
                echo $this->view->read_mod($area, $articles);
            else {
                $subs = !Data_model::check_area_subscription($areaid, $userid);
                echo $this->view->read_reg($area, $articles, $subs);
            }
        } else {
            echo $this->view->read_admin($area, $articles);
        }
    }
    
    public function update($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        $areaid = $args[URL_ARG_1];
        
        if(Auth::role_check(PROJECT_USER_ROLE_GUEST) || 
           Auth::role_check(PROJECT_USER_ROLE_REGISTERED) )
            Redirect('/areas/view');
        
        if(Auth::role_check(PROJECT_USER_ROLE_MODERATOR) ) {
            $userid = Auth::userid();
            if(!Data_model::check_area_moderation($areaid, $userid) )
                Redirect('/areas/view');
        }
        
        // check if data sent
        if(isset($_POST['id_podrucja']) ) {
            $area = $_POST;
            $area['id_podrucja'] = $areaid;
            
            if(Data_model::update_area($area) )
                Redirect('/areas/read/' . $areaid);
        } else 
            $area = Data_model::get_area_by_id($areaid);
        $area['link-back'] = 'areas/view';
        $area['link'] = 'areas/update/' . $areaid;
        echo $this->view->update($area);
    }
    
    public function delete($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        // if user is not admin
        if(!Auth::role_check(PROJECT_USER_ROLE_ADMIN) )
            Redirect('/areas/view');
        
        $areaid = $args[URL_ARG_1];
        $ok = Data_model::delete_area($areaid);
        
        Redirect('/areas/view');
    }
}

?>