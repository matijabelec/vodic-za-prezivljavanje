<?php

class Crud_controller extends Webpage_controller {
    public function __construct() {}
    
    public function users($args, $echo=true) {
        $auth = PROJECT_USER_ROLE_GUEST;
        if(Auth::login_check() && Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) )
            $auth = PROJECT_USER_ROLE_ADMIN;
        
        if($auth == PROJECT_USER_ROLE_ADMIN) {
            $model = new Users_model();
            $view = new Users_view();
            
            switch($args[URL_ARG_1]) {
                case 'create':
                    $model->
                    break;
                
                case 'read':
                    break;
                
                case 'update':
                    break;
                
                case 'delete':
                    break;
                
                default:
                    break;
            }
        }
        
    }
    
    public function areas($args, $echo=true) {
        
    }
}

?>