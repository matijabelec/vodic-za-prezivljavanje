<?php

class Areas_controller extends Controller {
    public function __construct() {
        $this->view = new Areas_view;
        $this->model = new Areas_model;
    }
    
    public function index($args) {
        Redirect('/areas/view');
    }
    
    public function view($args) {
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $user = Auth::get_user();
            $areas = $this->model->get_active_areas();
            
            $subs = new Subscribes_model;
            foreach($areas as &$area) {
                $sub_ch = $subs->check_subscription($user['userid'], $area['id_podrucja']);
                
                if($sub_ch) {
                    $area['subscribe-link'] = '/delete/' . $area['id_podrucja'];
                    $area['subscribe'] = 'Ukloni pretplatu';
                } else {
                    $area['subscribe-link'] = '/create/' . $area['id_podrucja'];
                    $area['subscribe'] = 'Pretplati se';
                }
            }
            unset($subs);
            
            $areas2 = $this->model->get_deleted_areas();
            
            echo $this->view->view_admin($areas, $areas2);
            
        } elseif (Auth::user_role_check(PROJECT_USER_ROLE_MODERATOR) || 
                  Auth::user_role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            $user = Auth::get_user();
            $areas = $this->model->get_active_areas();
            
            $subs = new Subscribes_model;
            foreach($areas as &$area) {
                $sub_ch = $subs->check_subscription($user['userid'], $area['id_podrucja']);
                
                if($sub_ch) {
                    $area['subscribe-link'] = '/delete/' . $area['id_podrucja'];
                    $area['subscribe'] = 'Ukloni pretplatu';
                } else {
                    $area['subscribe-link'] = '/create/' . $area['id_podrucja'];
                    $area['subscribe'] = 'Pretplati se';
                }
            }
            unset($subs);
            echo $this->view->view_registered($areas);
        } else {
            $areas1 = $this->model->get_active_areas();
            echo $this->view->view_guest($areas1);
        }
    }
    
    public function create($args) {
        // if user is not admin
        if(!Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) )
            Redirect('/areas/view');
        
        // check if data sent
        if(isset($_POST['id_podrucja']) ) {
            $area = $_POST;
            $ok = $this->model->create_new_area($area);
            if($ok)
                Redirect('/areas/view');
        }
        
        echo $this->view->crud_create();
    }
    
    public function read($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        // check if data sent
        if(isset($_POST['id_podrucja']) )
            Redirect('/areas/view');
        
        // get data
        $areaid = $args[URL_ARG_1];
        $areadata = $this->model->get_active_area($areaid);
        if(count($areadata) == 0)
            return RET_ERR;
        
        $articles = $this->model->get_area_articles($areaid);
        
        if(!Auth::user_role_check(PROJECT_USER_ROLE_GUEST) ) {
            $user = Auth::get_user();
            $userid = $user['userid'];
            
            if(Subscribes_model::check_subscription($userid, $areaid) )
                $subs = true;
            else
                $subs = false;
        }
        
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            echo $this->view->crud_read(array('area'=>$areadata, 'articles'=>$articles, 'subscribes'=>$subs), array('back', 'subscribe', 'update', 'delete') );
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_MODERATOR) ) {
            echo $this->view->crud_read(array('area'=>$areadata, 'articles'=>$articles, 'subscribes'=>$subs), array('back', 'subscribe', 'update') );
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            echo $this->view->crud_read(array('area'=>$areadata, 'articles'=>$articles, 'subscribes'=>$subs), array('back', 'subscribe') );
        } else {
            echo $this->view->crud_read(array('area'=>$areadata, 'articles'=>$articles), array('back') );
        }
    }
    
    public function update($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        if(!(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) || 
           Auth::user_role_check(PROJECT_USER_ROLE_MODERATOR) ) )
            Redirect('/areas/view');
        
        $areaid = $args[URL_ARG_1];
        
        // check if data sent
        if(isset($_POST['id_podrucja']) ) {
            $area = $_POST;
            
            $ok = $this->model->update_area($area);
            if($ok)
                Redirect('/areas/view');
        }
        
        // get data
        $areadata = $this->model->get_area($areaid);
        echo $this->view->crud_update($areadata);
    }
    
    public function delete($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        // if user is not admin
        if(!Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) )
            Redirect('/areas/view');
        
        $areaid = $args[URL_ARG_1];
        $ok = $this->model->delete_area($areaid);
        
        Redirect('/areas/view');
    }
}

?>