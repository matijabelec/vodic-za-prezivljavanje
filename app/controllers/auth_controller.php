<?php

class Auth_controller extends Controller {
    public function __construct() {
        $this->view = new Auth_view;
    }
    
    public function index() {
        Redirect('/');
    }
    
    public function login() {
        UseSecureConnection();
        
        // if user is logged in
        if(Auth::login_check() != false)
            Redirect('/');
        
        // if login fails (0. argument is 'url' always)
        if(count($_GET) != 1) {
            $reg = (isset($_GET['reg']) ? $_GET['reg'] : null);
            $info = (isset($_GET['info']) ? $_GET['info'] : null);
            
            echo $this->view->login($reg, $info);
            return;
        }
        
        // if user is NOT logged in
        if(Auth::login_check() == false) {
            if(isset($_POST['username']) && isset($_POST['password']) ) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                // check username and password if they are correct
                $ok = Auth::login($username, $password);
                if($ok == 1)
                    Redirect('/');
                elseif($ok == -2)
                    Redirect('/auth/login?reg=failed&info=user-blocked');
                else
                    Redirect('/auth/login?reg=failed');
            }
        }
        
        echo $this->view->login();
    }
    
    public function registration() {
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
        if(isset($_POST['korisnicko_ime']) && 
           isset($_POST['mail']) && 
           isset($_POST['mail2']) && 
           isset($_POST['lozinka']) && 
           isset($_POST['lozinka2']) ) {
               
            $username = $_POST['korisnicko_ime'];
            $email = $_POST['mail'];
            $email2 = $_POST['mail2'];
            $passwd = $_POST['lozinka'];
            $passwd2 = $_POST['lozinka2'];
            
            if($email!=$email2)
                Redirect('/auth/registration?reg=failed&info=two-different-mails');
            if($passwd!=$passwd2)
                Redirect('/auth/registration?reg=failed&info=two-different-passwords');
            
            if(!Auth::check_username_available($username) )
                Redirect('/auth/registration?reg=failed&info=username-not-available');
            
            if(!Auth::check_mail_available($email) )
                Redirect('/auth/registration?reg=failed&info=email-not-available');
            
            $userdata = $_POST;
            $userdata['id_tipa_korisnika'] = PROJECT_USER_ROLE_REGISTERED;
            $userdata['ime'] = 'ime'; 
            $userdata['prezime'] = 'prezime'; 
            $userdata['slika_korisnika'] = ''; 
            if(Auth::registration($userdata) == true)
                Redirect('/auth/activate');
            Redirect('/auth/registration?reg=failed');
        }
        
        echo $this->view->registration();
    }
    
    public function activate() {
        UseSecureConnection();
        
        if(isset($_GET['acl']) ) {
            $acl = $_GET['acl'];
            if(Auth::activation($acl) )
                Redirect('/auth/login');
            else
                Redirect('/');
        }
        Redirect('/');
    }
    
    public function logout() {
        UseSecureConnection();
        
        if(Auth::login_check() == true) {
            Auth::logout();
            Redirect('/auth/login');
        }
        
        Redirect('/');
    }
}

?>