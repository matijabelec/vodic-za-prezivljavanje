<?php
include_once('app/AppMain.php');

class Website extends AppMain {
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
    }
}

$app = new Website();
$app->show();

?>