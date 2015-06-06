<?php

/*
 *  Author: Matija Belec
 *    Date: 05.06.2015
 */

include_once('app/app_init.php');

/*class Website extends AppMain {
    public function __construct() {}
    public function __destruct() {}
    
    public function show() {
        echo '<!DOCTYPE html>';
        echo '<html>';
        echo '<head>';
        echo '  <meta charset="utf-8">';
        echo '  <title>Test</title>';
        echo '</head>';
        echo '<body>';
        echo '  <h1>Test</h1>';
        echo '  <p>Test paragraph.</p>';
        echo '</body>';
        echo '</html>';
        $conn = Database::connect('localhost', 'default', 'root', 'belec');
        Database::disconnect();
    }
}*/

$app = new Website();
$app->show();

?>