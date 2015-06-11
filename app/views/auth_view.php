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
        $page = $this->view_prepare();
        
        $content = new Template('body/login');
        $content->set('errors', '');
        if(!is_null($reg) && $reg!='') {
            $error_info = 'Neuspjela prijava! Provjerite unesene podatke.';
            $content->set('errors', $error_info);
        }
        $page->set_body($content->fill() );
        
        $page->set_title('Prijava');
        $page->set('usermenu-login', ' selected');
        
        return $page->fill();
    }
    
    public function registration($reg=null, $info=null) {
        $page = $this->view_prepare();
        
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
        $page->set_body($content->fill() );
        
        $page->set_title('Registracija');
        $page->set('usermenu-registration', ' selected');
        
        return $page->fill();
    }
    
    public function logout() {
        $page = $this->view_prepare();
        
        $content = new Template('body/logout');
        $page->set_body($content->fill() );
        
        $page->set_title('Odjava');
        $page->set('usermenu-logout', ' selected');
        
        return $page->fill();
    }
    
    protected function view_prepare() {
        $page = new Standard_template('Auth');
        
        return $page;
    }
}

?>