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
            
            if(!is_null($info) ) {
                switch($info) {
                    case 'user-blocked':
                        $error_info = 'Korisnik je blokiran.';
                        break;
                    default:
                        break;
                }
            }
            
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
                switch($info) {
                    case 'username-not-available':
                        $error_info = 'Korisničko ime je već zauzeto.';
                        break;
                    case 'email-not-available';
                        $error_info = 'Već postoji korisnik sa unesenom e-mail adresom.';
                        break;
                    case 'two-different-mails':
                    case 'two-different-passwords':
                        $error_info = 'Pogrešno ispunjena prijava.';
                        break;
                    default:
                        break;
                }
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