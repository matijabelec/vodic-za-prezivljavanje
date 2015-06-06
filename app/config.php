<?php

/*
 *
 *  Filename: config.php
 *  Author: Matija Belec (hackerma3x@gmail.com)
 *  Date: 5 March 2015
 *  Description:
 *      - here is definitions for all needed constants (defines)
 *  Requirements:
 *      - [none]
 *  
 *  Copyright 2015. Matija Belec. All Rights reserved.
 *  
 */

define('ENVIRONMENT_DEVELOPMENT', true);

// database connection informations
define('DEFAULT_DB_HOSTNAME',   'localhost');
define('DEFAULT_DB_DATABASE',   'webdipdb');
define('DEFAULT_DB_USERNAME',   'root');
define('DEFAULT_DB_PASSWORD',   'belec');

// default controllers & actions
define('CONTROLLER_DEFAULT',    'index');
define('CONTROLLER_ERROR',      'error');
define('ACTION_DEFAULT',        'index');

// define app paths
define('DIR_LIBRARY',       DIR_APP.'library'.DS);
define('DIR_TEMPLATES',     DIR_APP.'templates'.DS);
define('DIR_MODELS',        DIR_APP.'models'.DS);
define('DIR_VIEWS',         DIR_APP.'views'.DS);
define('DIR_CONTROLLERS',   DIR_APP.'controllers'.DS);
define('DIR_PLUGINS',       DIR_APP.'plugins'.DS);
define('DIR_TMP',           DIR_APP.'tmp'.DS);
define('DIR_LOGS',          DIR_TMP.'logs'.DS);

// define site paths
define('DIR_SITE',          ROOT.'site'.DS);
define('DIR_SITE_CSS',      DIR_SITE.'css'.DS);
define('DIR_SITE_JS',       DIR_SITE.'js'.DS);
define('DIR_SITE_GFX',      DIR_SITE.'gfx'.DS);
define('DIR_SITE_FILES',    DIR_SITE.'files'.DS);

define('RET_OK',     1);
define('RET_ERR',   -1);

?>