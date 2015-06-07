<?php

class Auth_view extends Webpage_view {
    public function login() {
        $content = new Template('body/login');
        
        $userprofile = new Template('data/user_profile_menu_login');
        
        $page = new Standard_template('Login', '', 
                                      $content->fill(), 
                                      $userprofile->fill() );
        $page->set('option1', ' selected');
        
        return $page->fill();
    }
    
    public function registration() {
        $content = new Template('body/registration');
        
        $userprofile = new Template('data/user_profile_menu_login');
        
        $page = new Standard_template('Registracija novog korisnika', '', 
                                      $content->fill(), 
                                      $userprofile->fill() );
        $page->set('option1', ' selected');
        
        return $page->fill();
    }
    
    public function logout() {
        /*$user = Auth::get_user();
        
        $userprofile = new Template('data/user_profile_menu');
        $userprofile->set('username-link', $user['username']);
        $userprofile->set('username',$user['username']);
        
        $content = new Template('body/logout');
        
        $page = new Standard_template('Logout', '', 
                                      $content->fill(), 
                                      $userprofile->fill() );
        $page->set('option1', ' selected');
        
        return $page->fill();*/
    }
}

?>