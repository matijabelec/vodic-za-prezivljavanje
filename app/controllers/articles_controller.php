<?php

class Articles_controller extends Controller {
    public function __construct() {
        $this->view = new Articles_view;
        $this->model = new Articles_model;
    }
    
    public function index($args) {
        Redirect('/articles/view');
    }
}

?>