<?php

class Standard_template extends Template {
    public function __construct($title) {
        parent::__construct('page/standard');
        
        $this->set('head-data', '');
        $this->set('title', $title);
        
        $this->set('project-title', PROJECT_TITLE);
        $this->set('copyright-info-data', PROJECT_COPYRIGHT_INFO);
        
        $this->set('body', '');
        
        $this->set('option-home', '');
        $this->set('option-users', '');
        $this->set('option-areas', '');
        
        $this->set('option-documentation', '');
        $this->set('option-about-author', '');
        
        
        // prepare user profile preview
        $user = Auth::get_user();
        if($user == null) {
            $this->set('style-user-type-id', '');
        } else {
            $this->set_user_type_style($user['role']);
        }
        
        if($user == null) {
            $userprofile = new Template('data/user_profile_menu_login');
        } else {
            $userprofile = new Template('data/user_profile_menu');
            $userprofile->set('username-link', $user['username']);
            $userprofile->set('username',$user['username']);
        }
        
        // prepare menu
        $mainmenu = new Template('data/main-menu');
        $mainmenu->set('user-profile-menu', $userprofile->fill() );
        $this->set('main-menu', $mainmenu->fill() );
        
        
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
    
    public function set_headdata($head) {
        $this->set('head-data', $head);
    }
    
    public function set_body($body) {
        $this->set('body', $body);
    }
}

?>