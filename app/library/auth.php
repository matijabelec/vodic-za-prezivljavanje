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
            if($username == 'matija' && $password == 'belec') {
                $user = array(
                    'userid' => 12,
                    'username' => 'matijabelec',
                    'role' => 3,
                    'key' => 'fe6752348a67c78c3eef2aa3'
                );
                $_SESSION['user'] = $user;
                return true;
            }
            if($username == 'ivan' && $password == 'belec') {
                $user = array(
                    'userid' => 12,
                    'username' => 'ivan1',
                    'role' => 1,
                    'key' => '1e6752348a67c78c3eef2aa3'
                );
                $_SESSION['user'] = $user;
                return true;
            }
            if($username == 'roko' && $password == 'bel') {
                $user = array(
                    'userid' => 12,
                    'username' => 'roko1',
                    'role' => 2,
                    'key' => '5e6752348a67c78c3eef2aa3'
                );
                $_SESSION['user'] = $user;
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
        if(!isset($userdata['activation_data']) || !isset($userdata['email']) ) {
            return false;
        }
        
        $link =  WEBSITE_ROOT_NAME . WEBSITE_ROOT_PATH . '/auth/activate?id=' . $userdata['activation_data'];
        
        $mail_to = $userdata['email'];
        $mail_from = 'From: ' . PROJECT_REGISTRATION_EMAIL_FROM;
        $mail_subject = PROJECT_REGISTRATION_EMAIL_SUBJECT;
        $mail_body = 'Aktivirajte svoj računa za "Priručnik za preživljavanje".\r\n' .
                     'Link za aktivaciju: ' . $link . ' \r\n' .
                     'Aktivacijski link vrijedi 24 sata.';
        
        if(mail($mail_to, $mail_subject, $mail_body, $mail_from) ) {
            return true;
        }
        return false;
    }
    
    public static function activate($id=null) {
        if(isset($id) && !is_null($id) ) {
            echo $id;
        }
        echo 'activation has wrong identification data';
    }
}

?>