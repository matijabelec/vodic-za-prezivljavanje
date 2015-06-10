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
    protected static $user = null;
    protected static $login_fail_count = 0;
    protected static $status = 0;
    
    protected function __construct() {}
    protected function __destruct() {}
    
    public static function get_user() {
        return self::$user;
    }
    
    public static function login($username='', $password='') {
        self::$user = null;
        if(self::login_check() == false) {
            $users = Database::query('SELECT id_korisnika AS "userid", korisnicko_ime AS "username", lozinka AS "password", id_tipa_korisnika AS "role", status FROM korisnici WHERE korisnicko_ime = :usname', array('usname'=>$username) );
            if(count($users) != 1)
                return false;
            
            $us = $users[0];
            
            // check if user is deleted
            if($us['status'] == PROJECT_DATA_USER_STATUS_DELETED) {
                self::$status = PROJECT_DATA_USER_STATUS_DELETED;
                return false;
            }
            
            // check if user is registered (not activated)
            if($us['status'] == PROJECT_DATA_USER_STATUS_REGISTERED) {
                self::$status = PROJECT_DATA_USER_STATUS_REGISTERED;
                return false;
            }
            
            // check if user is blocked
            if($us['status'] == PROJECT_DATA_USER_STATUS_BLOCKED) {
                self::$status = PROJECT_DATA_USER_STATUS_BLOCKED;
                return false;
            }
            
            // check if wrong password is supplied
            if($us['username']==$username && $us['password']!=$password) {
                self::$login_fail_count += 1;
                if(self::$login_fail_count >= 3) {
                    self::$login_fail_count = 3;
                    Database::query('UPDATE TABLE korisnici SET status = :status WHERE korisnicko_ime = :usname',
                                    array('status'=>PROJECT_DATA_USER_STATUS_BLOCKED,'usname'=>$username) );
                    self::$status = PROJECT_DATA_USER_STATUS_BLOCKED;
                }
                return false;
            }
            
            // check if username and password are correct
            if($us['username']==$username && $us['password']==$password) {
                self::$user = array(
                    'userid' => $us['userid'],
                    'username' => $us['username'],
                    'role' => $us['role']
                );
                $_SESSION['user'] = self::$user;
                self::$status = 0;
                return true;
            }
        }
        return false;
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
        
        $username = $userdata['username'];
        $mail_to = $userdata['email'];
        
        $link = 'https://' . WEBSITE_ROOT_NAME . WEBSITE_ROOT_PATH . '/auth/activate?' . $userdata['activation_data'];
        
        //utf-8 fix
        $mail_headers  = 'MIME-Version: 1.0' . "\r\n";
        $mail_headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $mail_headers .= 'From: ' . PROJECT_REGISTRATION_EMAIL_FROM . "\r\n";
        
        $mail_subject = PROJECT_REGISTRATION_EMAIL_SUBJECT;
        $mail_body = 'Aktivirajte svoj račun za "Priručnik za preživljavanje".' . "\r\n" .
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
            //TODO: check activation with database
            
            return true;
        }
        return false;
    }
    
    public static function user_role_check($role=null) {
        if(!is_null(self::$user) && 
           isset(self::$user['role']) && 
           self::$user['role'] == $role) {
            return true;
        }
        return false;
    }
}

?>