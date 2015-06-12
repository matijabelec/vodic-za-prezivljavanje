<?php

class Areas_controller extends Webpage_controller {
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
        
        // if user is admin
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $user = Auth::get_user();
            
            // get areas
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
            
            echo $this->view->view_registered($areas);
        
        // if user is moderator
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_MODERATOR) ) {
            $user = Auth::get_user();
            
            // get areas
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
            
            echo $this->view->view_registered($areas);
        
        // if user is registered user
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            $user = Auth::get_user();
            
            // get areas
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
            
            echo $this->view->view_registered($areas);
        
        // if user is guest
        } else {
            $areas = $this->model->get_active_areas();
            echo $this->view->view_guest($areas);
        }
    }
    
    public function create($args) {
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        // if user is not admin
        if(!Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Redirect('/areas/view');
        }
        
        // check if data sent
        if(isset($_POST['naziv_podrucja']) && 
           isset($_POST['opis']) && 
           isset($_POST['slika']) && 
           isset($_POST['status']) ) {
            $st = $_POST['status'];
            if($st>=0 && $st<=1) {
                Database::query('INSERT INTO podrucja(naziv_podrucja, opis, slika, status) VALUES(:title, :opis, :slika, :status)',
                array('title' => $_POST['naziv_podrucja'],
                      'opis' => $_POST['opis'],
                      'slika' => $_POST['slika'],
                      'status' => $st) );
                Redirect('/areas/view');
            }
        }
        
        echo $this->view->crud_create();
    }
    
    public function read($args) {
        if(count($args) != URL_ARGUMENTS_1)
            return RET_ERR;
        
        // if user is admin
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            // check if data sent
            if(isset($_POST['id_podrucja']) ) {
                Redirect('/areas/view');
            }
            
            // get data
            $areadata = $this->model->get_area_by_id($args[URL_ARG_1]);
            if(count($areadata) == 0)
                return RET_ERR;
            
            $articles = $this->model->get_articles_for_area($args[URL_ARG_1]);
            
            echo $this->view->crud_read_registered(array('area'=>$areadata, 'articles'=>$articles) );
        
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_MODERATOR) ) {
            // check if data sent
            if(isset($_POST['id_podrucja']) ) {
                Redirect('/areas/view');
            }
            
            // get data
            $areadata = $this->model->get_area_by_id($args[URL_ARG_1]);
            if(count($areadata) == 0)
                return RET_ERR;
            
            $articles = $this->model->get_articles_for_area($args[URL_ARG_1]);
            
            echo $this->view->crud_read_registered(array('area'=>$areadata, 'articles'=>$articles) );
        
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            // check if data sent
            if(isset($_POST['id_podrucja']) ) {
                Redirect('/areas/view');
            }
            
            // get data
            $areadata = $this->model->get_area_by_id($args[URL_ARG_1]);
            if(count($areadata) == 0)
                return RET_ERR;
            
            $articles = $this->model->get_articles_for_area($args[URL_ARG_1]);
            
            echo $this->view->crud_read_registered(array('area'=>$areadata, 'articles'=>$articles) );
        } else {
            // check if data sent
            if(isset($_POST['id_podrucja']) ) {
                Redirect('/areas/view');
            }
            
            // get data
            $areadata = $this->model->get_area_by_id($args[URL_ARG_1]);
            if(count($areadata) == 0)
                return RET_ERR;
            
            $articles = $this->model->get_articles_for_area($args[URL_ARG_1]);
            
            echo $this->view->crud_read_guest(array('area'=>$areadata, 'articles'=>$articles) );
        }
    }
    
    public function update($args) {
        if(count($args) != URL_ARGUMENTS_1)
            return RET_ERR;
        
        // if user is not admin
        if(!Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Redirect('/areas/view');
        }
        
        // check if data sent
        if(isset($_POST['id_podrucja']) && 
           isset($_POST['naziv_podrucja']) && 
           isset($_POST['opis']) && 
           isset($_POST['slika']) && 
           isset($_POST['status']) ) {
            $st = $_POST['status'];
            if($st>=0 && $st<=1) {
                Database::query('UPDATE podrucja SET naziv_podrucja=:title, opis=:opis, slika=:slika, status=:status WHERE id_podrucja=:id',
                array('id' => $_POST['id_podrucja'],
                      'title' => $_POST['naziv_podrucja'],
                      'opis' => $_POST['opis'],
                      'slika' => $_POST['slika'],
                      'status' => $st) );
                Redirect('/areas/view');
            }
        }
        
        // get data
        $areadata = $this->model->get_area_by_id($args[URL_ARG_1]);
        echo $this->view->crud_update($areadata);
    }
    
    public function delete($args) {
        if(count($args) != URL_ARGUMENTS_1)
            return RET_ERR;
        
        // if user is not admin
        if(!Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Redirect('/areas/view');
        }
        
        // check if data sent
        if(isset($_POST['id_podrucja']) ) {
            $id = $_POST['id_podrucja'];
            Database::query('UPDATE podrucja SET status = 0 WHERE id_podrucja = :id', array('id'=>$id) );
            Redirect('/areas/view');
        }
        
        // get data
        $areadata = $this->model->get_area_by_id($args[URL_ARG_1]);
        echo $this->view->crud_delete($areadata);
    }
}

?>