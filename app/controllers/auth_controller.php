<?php

class Auth_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Auth_view;
    }
    
    public function index() {
        Redirect('/');
    }
    
    public function login() {
        echo $this->view->login();
    }
    
    public function logout() {
        echo $this->view->logout();
    }
}

?>