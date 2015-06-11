<?php

class Admin_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Admin_view;
        $this->model = new Admin_model;
    }
    
    public function index() {
        Redirect('/admin/view');
    }
    
    public function view() {
        $time = $this->model->get_time();
        echo $this->view->time($time);
    }
    
    public function time() {
        $this->model->set_time();
        Redirect('/admin/view');
    }
}

?>