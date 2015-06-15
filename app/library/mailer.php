<?php

/*
 *
 *  Filename: mailer.php
 *  Author: Matija Belec (matijabelec1@gmail.com)
 *  Date: 14 June 2015
 *  Description:
 *      - singleton, mail station
 *  Requirements:
 *      - config.php
 *      - project_data.php
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Mailer {
    public static function send_mail_utf8($mail_to, $subject, $content) {
        //utf-8 fix
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: ' . PROJECT_REGISTRATION_EMAIL_FROM . "\r\n";
        
        if(mail($mail_to, $subject, $content, $headers) ) {
            return true;
        }
        return false;
    }
}

?>