<?php

class Users_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Users_view;
        $this->model = new Users_model;
    }
    
    public function index($args) {
        if(count($args) != URL_INDEX_ARGUMENTS_NONE)
            return RET_ERR;
        
        Redirect('/users/view');
    }
    
    public function view($args) {
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        // if user is logged in
        if(Auth::login_check() != false) {
            Redirect('/users/crud');
        }
        
        // show page
        $users = $this->model->get_users_safe();
        echo $this->view->view($users);
    }
    
    public function crud($args) {
        // check if user is not logged in
        if(Auth::login_check() == false) {
            Redirect('/users/view');
        }
        
        // get logged user's data
        $user = Auth::get_user();
        
        // get areas
        $users = $this->model->get_users();
        
        
        if(count($args) == URL_ARGUMENTS_1) {
            if($args[URL_ARG_1] == 'create') {
                echo $this->view->crud_create($user);
                return;
            } else
                Redirect('/users/view');
        }
        
        if(count($args) >= URL_ARGUMENTS_2) {
            $data_korisnik = Database::query('SELECT * FROM korisnici WHERE id_korisnika = :id', array('id'=>$args[URL_ARG_2]) );
            switch($args[URL_ARG_1]) {
                case 'read':
                case 'update':
                case 'delete':
                    break;
                default:
                    Redirect('/users/view');
                    break;
            }
            
            $action = 'crud_' . $args[URL_ARG_1];
            echo $this->view->$action($user, $data_korisnik);
            return;
        }
        
        echo $this->view->crud($user, $users);
    }
}

?>