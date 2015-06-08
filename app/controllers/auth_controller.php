<?php

class Auth_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Auth_view;
    }
    
    public function index() {
        Redirect('/');
    }
    
    public function login() {
        UseSecureConnection();
        
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
    
    public function registration($args) {
        UseSecureConnection();
        
        // if user is logged in
        if(Auth::login_check() == true) {
            Redirect('/');
        }
        
        // if registration fails (0. argument is 'url' always)
        if(count($_GET) != 1) {
            $reg = (isset($_GET['reg']) ? $_GET['reg'] : null);
            $info = (isset($_GET['info']) ? $_GET['info'] : null);
            
            echo $this->view->registration($reg, $info);
            return;
        }
        
        // check if registration data is available
        if(isset($_POST['username']) && $_POST['username']!='' &&
           isset($_POST['email']) && $_POST['email']!='' ) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            
            // check if username is available
            $users = Database::query('SELECT korisnicko_ime FROM korisnici WHERE korisnicko_ime = :usname', array('usname'=>$username) );
            if(count($users) != 0) {
                Redirect('/auth/registration?reg=failed&info=username-not-available');
            }
            
            // check if e-mail is available
            $mails = Database::query('SELECT mail FROM korisnici WHERE mail = :usmail', array('usmail'=>$email) );
            if(count($mails) != 0) {
                Redirect('/auth/registration?reg=failed&info=email-not-available');
            }
            
            $userdata = array(
                'username' => $username,
                'email' => $email,
                'activation_data' => 'id=' . $username
            );
            
            if(Auth::register($userdata) == true) {
                Redirect('/auth/activation');
            } else {
                Redirect('/auth/registration?reg=failed');
            }
        }
        
        echo $this->view->registration();
    }
    
    public function activation($id=null) {
        UseSecureConnection();
        
        Redirect('/');
    }
    
    public function logout() {
        UseSecureConnection();
        
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