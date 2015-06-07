<?php

class Auth_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Auth_view;
    }
    
    public function index() {
        Redirect('/');
    }
    
    public function login() {
        // if user is NOT logged in
        if(Auth::login_check() == false) {
            if(isset($_POST['username']) && isset($_POST['password']) ) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                // check username and password if they are correct
                if(Auth::login($username, $password) == true) {
                    // user is logged in
                    Redirect('/');
                } else {
                    // user is NOT logged in - WRONG user data
                    Redirect('/auth/login');
                }
            } else {
                echo $this->view->login();
            }
        
        // if user is logged in
        } else {
            Redirect('/');
        }
    }
    
    public function registration() {
        if(Auth::login_check() == true) {
            Redirect('/');
            
        // if user is NOT logged in
        } else {
            if(isset($_POST['username']) ) {
                if(Auth::register($userdata) == true) {
                    Redirect('/auth/activation');
                } else {
                    Redirect('/auth/registration?reg=failed');
                }
            }
            
            echo $this->view->registration();
        }
    }
    
    public function activation($id=null) {
        if(Auth::register($userdata) == true) {
            Redirect('/auth/activation');
            
        // if user is NOT logged in
        } else {
            echo $this->view->registration();
        }
    }
    
    public function logout() {
        if(Auth::login_check() == true) {
            Auth::logout();
            Redirect('/auth/login');
            //    echo $this->view->logout();
        
        // if user is NOT logged in
        } else {
            Redirect('/');
        }
    }
}

?>