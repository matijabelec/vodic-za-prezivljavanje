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

class Auth {
    //protected static $instance = null;
    protected static $user = null;
    
    protected function __construct() {}
    protected function __destruct() {}
    
    //public static function getInstance() {
    //    if(is_null(self::$instance) ) self::$instance = new Auth();
    //    return self::$instance;
    //}
    
    public static function get_user() {
        return self::$user;
    }
    
    public static function login($username='', $password='') {
        self::$user = null;
        if(self::login_check() == false) {
            //TODO: add database connection
            $users = Database::query('SELECT id_korisnika AS "userid", korisnicko_ime AS "username", lozinka AS "password", id_tipa_korisnika AS "role", "status" AS "status" FROM korisnici WHERE korisnicko_ime = :usname', array('usname'=>$username) );
            
            if(count($users) != 1)
                return false;
            
            $us = $users[0];
            if($us['status'] == '0')
                return false;
            
            if($us['username']==$username && $us['password']==$password) {
                self::$user = array(
                    'userid' => $us['userid'],
                    'username' => $us['username'],
                    'role' => $us['role'],
                    'key' => 'fe6752348a67c78c3eef2aa3'
                );
                $_SESSION['user'] = self::$user;
                return true;
            }
            
            return false;
        }
        return true;
    }
    public static function login_check() {
        self::$user = null;
        if(isset($_SESSION['user']) ) {
            self::$user = $_SESSION['user'];
            return true;
        }
        return false;
    }
    public static function logout() {
        $user_logouted = false;
        if(isset($_SESSION['user']) ) {
            self::$user = null;
            $_SESSION['user'] = null;
            unset($_SESSION['user']);
            $user_logouted = true;
        }
        session_destroy();
        return $user_logouted;
    }
    
    public static function register($userdata=array() ) {
        if(!isset($userdata['username']) || $userdata['username']=='' || 
           !isset($userdata['email']) || $userdata['email']=='' || 
           !isset($userdata['activation_data']) || $userdata['activation_data']=='') {
            return false;
        }
        
        $link = 'https://' . WEBSITE_ROOT_NAME . WEBSITE_ROOT_PATH . '/auth/activate?' . $userdata['activation_data'];
        $username = $userdata['username'];
        
        $mail_to = $userdata['email'];
        
        $mail_headers  = 'MIME-Version: 1.0' . "\r\n";
        $mail_headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $mail_headers .= 'From: ' . PROJECT_REGISTRATION_EMAIL_FROM . "\r\n";

        $mail_subject = PROJECT_REGISTRATION_EMAIL_SUBJECT;
        $mail_body = 'Aktivirajte svoj računa za "Priručnik za preživljavanje".' . "\r\n" .
                     'Korisničko ime: ' . $username . " \r\n" .
                     'Link za aktivaciju: ' . $link . " \r\n" .
                     'Aktivacijski link vrijedi 24 sata.' . "\r\n";
        
        if(mail($mail_to, $mail_subject, $mail_body, $mail_headers) ) {
            return true;
        }
        return false;
    }
    
    public static function activate($id=null) {
        if(isset($id) && !is_null($id) ) {
            return true;
        }
        return false;
    }
    
    public static function user_role_check($role) {
        if(!is_null(self::$user) && isset(self::$user['role']) && self::$user['role'] == $role) {
            return true;
        }
        return false;
    }
}

?>