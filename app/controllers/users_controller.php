<?php

/*
 *
 *  Filename: users_controller.php
 *  Author: Matija Belec (matijabelec1@gmail.com)
 *  Date: 9 June 2015
 *  Description:
 *      - CRUD for table 'korisnici'
 *      - User roles:
 *          - Administrator:
 *              - view users (view all: activated, registered, blocked, deleted)
 *              - create new user
 *              - read user
 *              - update user
 *              - delete user
 *          - Moderator:
 *              - view users (only view: activated, registered)
 *          - Registered user:
 *              - view users (only view: activated, registered)
 *          - Guest:
 *              - view users (only view: activated, registered)
 *          - 
 *  Requirements:
 *      - [none]
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Users_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Users_view;
        $this->model = new Users_model;
    }
    
    public function index($args) {
        Redirect('/users/view');
    }
    
    public function view($args) {
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        // if user is admin
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            // get users
            $users = $this->model->get_users();
            echo $this->view->crud($users);
            return;
        
        // if user is registered user or moderator
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_MODERATOR) || 
                 Auth::user_role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            // get users
            $users = $this->model->get_users();
            echo $this->view->view_2($users);
            return;
        }
        
        // if user is guest
        $users = $this->model->get_users_safe();
        echo $this->view->view($users);
    }
    
    public function create($args) {
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        // if user is not admin
        if(!Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Redirect('/users/view');
        }
        
        // check if data sent
        if(isset($_POST['id_korisnika']) && 
           isset($_POST['id_tipa_korisnika']) && 
           isset($_POST['korisnicko_ime']) && 
           isset($_POST['lozinka']) && 
           isset($_POST['mail']) && 
           isset($_POST['ime']) && 
           isset($_POST['prezime']) && 
           isset($_POST['slika_korisnika']) && 
           isset($_POST['status']) ) {
            $st = $_POST['status'];
            if($st>=0 && $st<=3) {
                Database::query('INSERT INTO korisnici(korisnicko_ime, lozinka, mail, ime, prezime, slika_korisnika, id_tipa_korisnika, status) VALUES(:korime, :lozinka, :mail, :ime, :prezime, :slika, :id_tip, :status)',
                array('korime' => $_POST['korisnicko_ime'],
                      'lozinka' => $_POST['lozinka'],
                      'mail' => $_POST['mail'],
                      'ime' => $_POST['ime'],
                      'prezime' => $_POST['prezime'],
                      'slika' => $_POST['slika_korisnika'],
                      'id_tip' => $_POST['id_tipa_korisnika'],
                      'status' => $st) );
                Redirect('/users/view');
            }
        }
        
        echo $this->view->crud_create();
    }
    
    public function read($args) {
        if(count($args) != URL_ARGUMENTS_1)
            return RET_ERR;
        
        // if user is not admin
        if(!Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Redirect('/users/view');
        }
        
        // check if data sent
        if(isset($_POST['id_korisnika']) ) {
            Redirect('/users/view');
        }
        
        // get data
        $userdata = $this->model->get_user_by_id($args[URL_ARG_1]);
        echo $this->view->crud_read($userdata);
    }
    
    public function update($args) {
        if(count($args) != URL_ARGUMENTS_1)
            return RET_ERR;
        
        // if user is not admin
        if(!Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Redirect('/users/view');
        }
        
        // check if data sent
        if(isset($_POST['id_korisnika']) && 
           isset($_POST['id_tipa_korisnika']) && 
           isset($_POST['korisnicko_ime']) && 
           isset($_POST['lozinka']) && 
           isset($_POST['mail']) && 
           isset($_POST['ime']) && 
           isset($_POST['prezime']) && 
           isset($_POST['slika_korisnika']) && 
           isset($_POST['status']) ) {
            $id_kor = $_POST['id_korisnika'];
            $st = $_POST['status'];
            
            $user = Auth::get_user();
            
            if($st==0 && $user['userid'] == $id_kor) {
                
            } else if($st>=0 && $st<=3) {
                Database::query('UPDATE korisnici SET korisnicko_ime=:korime, lozinka=:lozinka, mail=:mail, ime=:ime, prezime=:prezime, slika_korisnika=:slika, id_tipa_korisnika=:id_tip, status=:status WHERE id_korisnika=:korid',
                array('korid' => $id_kor,
                      'korime' => $_POST['korisnicko_ime'],
                      'lozinka' => $_POST['lozinka'],
                      'mail' => $_POST['mail'],
                      'ime' => $_POST['ime'],
                      'prezime' => $_POST['prezime'],
                      'slika' => $_POST['slika_korisnika'],
                      'id_tip' => $_POST['id_tipa_korisnika'],
                      'status' => $st) );
                Redirect('/users/view');
            }
        }
        
        // get data
        $userdata = $this->model->get_user_by_id($args[URL_ARG_1]);
        echo $this->view->crud_update($userdata);
    }
    
    public function delete($args) {
        if(count($args) != URL_ARGUMENTS_1)
            return RET_ERR;
        
        // if user is not admin
        if(!Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Redirect('/users/view');
        }
        
        // check if data sent
        if(isset($_POST['id_korisnika']) ) {
            $user = Auth::get_user();
            
            $id_kor = $_POST['id_korisnika'];
            if($user['userid'] != $id_kor) {
                Database::query('UPDATE korisnici SET status = 0 WHERE id_korisnika = :id', array('id'=>$id_kor) );
                Redirect('/users/view');
            }
        }
        
        // get data
        $userdata = $this->model->get_user_by_id($args[URL_ARG_1]);
        echo $this->view->crud_delete($userdata);
    }
}

?>