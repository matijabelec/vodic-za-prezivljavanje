<?php

/*
 *
 *  Filename: project_data.php
 *  Author: Matija Belec (matijabelec1@gmail.com)
 *  Date: 7 June 2015
 *  Description:
 *      - here is definitions for all needed constants (defines) for project
 *  Requirements:
 *      - [none]
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

// configurations for different PHP versions
define('PROJECT_USE_OLD_CHARSET', false);
define('PROJECT_USE_HTTPS', true);


define('PROJECT_TITLE', 'Vodič za preživljavanje');
define('PROJECT_COPYRIGHT_INFO', 'Copyright &copy; 2015. <a href="https://plus.google.com/100603684622190187147?rel=author">Matija Belec</a>. Sva prava zadržana.');

define('PROJECT_REGISTRATION_EMAIL_FROM', 'matijaarka@gmail.com');//'WebDiP@foi.hr');
define('PROJECT_REGISTRATION_EMAIL_SUBJECT', 'WebDiP2015_projekt004 - Aktivacija');


// user roles
define('PROJECT_USER_ROLE_GUEST', '0');
define('PROJECT_USER_ROLE_REGISTERED', '3');
define('PROJECT_USER_ROLE_MODERATOR', '2');
define('PROJECT_USER_ROLE_ADMIN', '1');


// row status info (data status info)
define('PROJECT_DATA_STATUS_DELETED', '0');
define('PROJECT_DATA_STATUS_ACTIVE', '1');

// user status info
define('PROJECT_DATA_USER_STATUS_DELETED', '0');
define('PROJECT_DATA_USER_STATUS_REGISTERED', '1');
define('PROJECT_DATA_USER_STATUS_ACTIVATED', '2');
define('PROJECT_DATA_USER_STATUS_BLOCKED', '3');


?>