<?php

class Admin_controller extends Controller {
    public function __construct() {
        $this->view = new Admin_view;
    }
    
    public function index() {
        if(!Auth::role_check(PROJECT_USER_ROLE_ADMIN) )
            return RET_ERR;
        Redirect('/admin/view');
    }
    
    public function view() {
        Auth::login_check();
        
        if(!Auth::role_check(PROJECT_USER_ROLE_ADMIN) )
            return RET_ERR;
        
        $data['time'] = Server_time::get_virtualTime();
        $data['time-offset'] = Server_time::get_virtualTimeOffset();
        echo $this->view->time($data);
    }
    
    public function time() {
        Auth::login_check();
        
        if(!Auth::role_check(PROJECT_USER_ROLE_ADMIN) )
            return RET_ERR;
        
        Server_time::set_time();
        Redirect('/admin/view');
    }
    
    
    public function ajax($args) {
        Auth::login_check();
        
        $argc = count($args);
        if($argc < URL_ARGUMENTS_1)
            return;
        
        if(!Auth::role_check(PROJECT_USER_ROLE_ADMIN) )
            return;
        
        if($args[URL_ARG_1] == 'table') {
            if($argc < URL_ARGUMENTS_2)
                return;
            
            switch($args[URL_ARG_2]) {
                case 'users':
                    $tablename = 'Korisnici';
                    $data = Data_model::get_all_users();
                    break;
                case 'areas':
                    $tablename = 'Područja';
                    $data = Data_model::get_all_areas();
                    break;
                case 'articles':
                    $tablename = 'Članci';
                    $data = Data_model::get_all_articles();
                    break;
                case 'comments':
                    $tablename = 'Komentari';
                    $data = Data_model::get_all_comments();
                    break;
                case 'subscribes':
                    $tablename = 'Pretplate';
                    $data = Data_model::get_all_subscribes();
                    break;
                case 'materials':
                    $tablename = 'Materijali';
                    $data = Data_model::get_all_materials();
                    break;
                case 'restrictions':
                    $tablename = 'Zabrane pristupa';
                    $data = Data_model::get_all_restrictions();
                    break;
                
                
                case 'log-data':
                    $tablename = 'Prijave/odjave';
                    $data = Data_model::get_all_logs();
                    break;
                default:
                    break;
            }
            
            if(isset($tablename) )
                echo $this->view->view_table($tablename, $data);
        }
        return;
    }
}

?>