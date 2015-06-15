<?php

/*
 *
 *  Filename: auth.php
 *  Author: Matija Belec (matijabelec1@gmail.com)
 *  Date: 5 June 2015
 *  Description:
 *      - singleton that represents an login/logout module for users in app
 *      - it uses database from which user data is pulled
 *  Requirements:
 *      - database.php
 *      - config.php
 *      - project_data.php
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Auth extends Controller {
    public static function login($username, $password) {
        if(!isset($username) || !isset($password) )
            return false;
        
        $user = Data_model::get_activated_user_by_username($username);
        if(!empty($user) ) {
            $userid = $user['id_korisnika'];
            $username = $user['korisnicko_ime'];
            $userrole = $user['id_tipa_korisnika'];
            $time = '0000-00-00 00:00:00';
            if($user['lozinka'] == $password) {
                Session::set('user', array('id'=>$userid, 
                                           'name'=>$username, 
                                           'role'=>$userrole) );
                Data_model::insert_login($userid, $time);
                return true;
            } else {
                Data_model::insert_login_fail($userid, $time);
                if(Data_model::get_login_failed_count() >= 3) {
                    Data_model::block_user($userid);
                }
            }
        }
        return false;
    }
    
    public static function check_username_available($username) {
        return !Data_model::check_username_exists($username);
    }
    public static function check_mail_available($mail) {
        return !Data_model::check_mail_exists($mail);
    }
    
    public static function logout() {
        if(!Session::check('user') )
            return false;
        
        $user = Session::get('user');
        
        $time = '0000-00-00 00:00:00';
        Data_model::insert_logout(self::userid(), $time);
        
        Session::destroy('user');
        return true;
    }
    
    public static function registration($user) {
        if(!isset($user) || !is_array($user) )
            return false;
        
        if(!isset($user['korisnicko_ime']) )
            return false;
        
        $username = $user['korisnicko_ime'];
        $user['aktivacijski_kod'] = $username.$username;
        $user['datum_registracije'] = '0000-00-00 00:00:00'; 
        
        if(Data_model::create_user($user) ) {
            $mail_to = $user['mail'];
            $link = 'http://' . WEBSITE_ROOT_NAME . WEBSITE_ROOT_PATH . '/auth/activate?acl=' . $user['aktivacijski_kod'];
            
            $subject = PROJECT_REGISTRATION_EMAIL_SUBJECT;
            $content = 'Aktivirajte svoj račun za "Priručnik za preživljavanje".' . "\r\n" .
                       'Korisničko ime: ' . $user['korisnicko_ime'] . " \r\n" .
                       'Link za aktivaciju: ' . $link . " \r\n" .
                       'Aktivacijski link vrijedi 24 sata.' . "\r\n";
            Mailer::send_mail_utf8($mail_to, $subject, $content);
            return true;
        }
        return false;
    }
    
    public static function activation($aclink) {
        if(!isset($aclink) )
            return false;
        
        return Data_model::activate_user_by_aclink($aclink);
    }
    
    public static function authorize($username) {
        if(!isset($username) )
            return false;
        $user = Data_model::get_activated_user_by_username($username);
        if(count($user) == 1) {
            $userid = $user['id_korisnika'];
            $usern = $user['korisnicko_ime'];
            $userr = $user['id_tipa_korisnika'];
            Session::set('user', array('id'=>$userid, 
                                       'name'=>$usern, 
                                       'role'=>$userr) );
            return true;
        }
        return false;
    }
    public static function role_check($role) {
        if(!isset($role) )
            return false;
        if(!Session::check('user') ) {
            if($role == PROJECT_USER_ROLE_GUEST)
                return true;
            return false;
        }
        if(self::userrole() == $role)
            return true;
        return false;
    }
    public static function login_check() {
        return Session::check('user');
    }
    
    public static function username() {
        $user = Session::get('user');
        return $user['name'];
    }
    public static function userid() {
        $user = Session::get('user');
        return $user['id'];
    }
    public static function userrole() {
        $user = Session::get('user');
        return $user['role'];
    }
}

?>