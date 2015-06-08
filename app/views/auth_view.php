<?php

/*
 *
 *  Filename: auth_view.php
 *  Author: Matija Belec (matijabelec1@gmail.com)
 *  Date: 5 June 2015
 *  Description:
 *      - [no-decsription]
 *  Requirements:
 *      - [none]
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Auth_view extends Webpage_view {
    public function login($reg=null, $info=null) {
        $content = new Template('body/login');
        
        $content->set('errors', '');
        if(!is_null($reg) && $reg!='') {
            $error_info = 'Neuspjela prijava! Provjerite unesene podatke.';
            $content->set('errors', $error_info);
        }
        
        $userprofile = new Template('data/user_profile_menu_login');
        
        $page = new Standard_template('Login', '', 
                                      $content->fill(), 
                                      $userprofile->fill() );
        $page->set('option1', ' selected');
        
        return $page->fill();
    }
    
    public function registration($reg=null, $info=null) {
        $content = new Template('body/registration');
        
        $content->set('errors', '');
        if(!is_null($reg) && $reg!='') {
            $error_info = 'Registracija nije uspjela!';
            if(!is_null($info) && $info!='') {
                if($info == 'username-not-available')
                    $error_info = 'Korisničko ime je već zauzeto.';
                elseif($info == 'email-not-available')
                    $error_info = 'E-mail je već zauzet.';
            }
            $content->set('errors', $error_info);
        }
        
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