<?php

class Areas_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Areas_view;
        $this->model = new Areas_model;
    }
    
    public function index($args) {
        if(count($args) != URL_INDEX_ARGUMENTS_NONE)
            return RET_ERR;
        
        Redirect('/areas/view');
    }
    
    public function view($args) {
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        // if user is logged in
        if(Auth::login_check() != false) {
            Redirect('/areas/crud');
        }
        
        // show page
        $areas = $this->model->get_areas();
        echo $this->view->view($areas);
    }
    
    public function crud($args) {
        // check if user is not logged in
        if(Auth::login_check() == false) {
            Redirect('/areas/view');
        }
        
        // get logged user's data
        $user = Auth::get_user();
        
        // get areas
        $areas = $this->model->get_areas();
        
        
        if(count($args) == URL_ARGUMENTS_1) {
            if($args[URL_ARG_1] == 'create') {
                echo $this->view->crud_create($user);
                return;
            } else
                Redirect('/areas/view');
        }
        
        if(count($args) >= URL_ARGUMENTS_2) {
            $data_korisnik = Database::query('SELECT * FROM podrucja WHERE id_podrucja = :id', array('id'=>$args[URL_ARG_2]) );
            switch($args[URL_ARG_1]) {
                case 'read':
                case 'update':
                case 'delete':
                    break;
                default:
                    Redirect('/areas/view');
                    break;
            }
            
            $action = 'crud_' . $args[URL_ARG_1];
            echo $this->view->$action($user, $data_korisnik);
            return;
        }
        
        echo $this->view->crud($user, $areas);
    }
}

?>