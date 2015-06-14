<?php

class Comments_controller extends Controller {
    public function __construct() {
        $this->view = new Comments_view;
        $this->model = new Comments_model;
    }
    
    public function index($args) {
        return RET_ERR;
    }
    
    public function create($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        if(Auth::user_role_check(PROJECT_USER_ROLE_GUEST) )
            return RET_ERR;
        
        $user = Auth::get_user();
        $userid = $user['userid'];
        $articleid = $args[URL_ARG_1];
        
        if(isset($_POST['id_clanka']) ) {
            $comment = $_POST;
            $ok = $this->model->comment($comment);
            if($ok)
                Redirect('/articles/read/' . $articleid);
        }
        
        echo $this->view->crud_create($userid, $articleid);
    }
    
    public function create($args) {
        if(count($args) < URL_ARGUMENTS_1)
            return RET_ERR;
        
        if(Auth::user_role_check(PROJECT_USER_ROLE_GUEST) )
            return RET_ERR;
        
        $user = Auth::get_user();
        $userid = $user['userid'];
        $articleid = $args[URL_ARG_1];
        
        if(isset($_POST['id_clanka']) ) {
            $comment = $_POST;
            $ok = $this->model->comment($comment);
            if($ok)
                Redirect('/articles/read/' . $articleid);
        }
        
        echo $this->view->crud_create($userid, $articleid);
    }
}

?>