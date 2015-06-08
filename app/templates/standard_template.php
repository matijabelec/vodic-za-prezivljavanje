<?php

class Standard_template extends Template {
    public function __construct($title, $head_data='', $body='', $userprofile='') {
        parent::__construct('page/standard');
        
        $this->set('head-data', $head_data);
        $this->set('title', $title);
        
        $this->set('project-title', PROJECT_TITLE);
        $this->set('copyright-info-data', PROJECT_COPYRIGHT_INFO);
        
        $this->set('body', $body);
        $this->set('user-profile-menu', $userprofile);
        
        $this->set('option-home', '');
        $this->set('option-users', '');
        $this->set('option-areas', '');
        
        $this->set('option-documentation', '');
        $this->set('option-about-author', '');
        
        $this->set('style-user-type-id', '');
        if(Auth::login_check() != false) {
            $user = Auth::get_user();
            $this->set_user_type_style($user['role']);
        }
        
        $this->set('project_root_path', WEBSITE_ROOT_PATH);
    }
    
    public function set_user_type_style($id=PROJECT_USER_ROLE_GUEST) {
        $style = ' style="background-color: ';
        if($id == PROJECT_USER_ROLE_REGISTERED) {
            $this->set('style-user-type-id', $style.'#0000ff"');
        } elseif($id == PROJECT_USER_ROLE_MODERATOR) {
            $this->set('style-user-type-id', $style.'#00ff00"');
        } elseif($id == PROJECT_USER_ROLE_ADMIN) {
            $this->set('style-user-type-id', $style.'#ff0000"');
        } else {
            $this->set('style-user-type-id', '');
        }
    }
}

?>