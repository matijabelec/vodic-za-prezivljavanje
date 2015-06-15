<?php

/*
 *
 *  Filename: uploader.php
 *  Author: Matija Belec (hackerma3x@gmail.com)
 *  Date: 15 June 2015
 *  Description:
 *      - [none]
 *  Requirements:
 *      - [none]
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

class Uploader {
    function upload_image() {
        $dir = "uploads/";
        $file = $dir . basename($_FILES["fileToUpload"]["name"]);
        $ift = pathinfo($target_file, PATHINFO_EXTENSION);
        
        $ok = 1;
        if(isset($_POST["submit"]) ) {
            $chk = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            $ok = ($chk !== false) ? 1 : 0;
        }

        if(file_exists($file) ) $ok = 0;
        if($_FILES["fileToUpload"]["size"] > 500000) $ok = 0;
        if($ift!='png' && $ift!='jpg' && $ift!='jpeg' && $ift!='gif' ) $ok = 0;
        if($ok == 0) return false;
        if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file) )
            return true;
        return false;
    }
}


?> 