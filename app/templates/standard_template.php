<?php

class Standard_template extends Template {
    public function __construct($title, $head_data='', $body='', $userprofile='') {
        parent::__construct('page/standard');
        
        $this->set('head-data', $head_data);
        $this->set('title', $title);
        
        $this->set('body', $body);
        $this->set('user-profile-menu', $userprofile);
        
        $this->set('option1', '');
        $this->set('option2', '');
        $this->set('option3', '');
        $this->set('option4', '');
        $this->set('option5', '');
        
        $this->set('project_root_path', WEBSITE_ROOT_PATH);
    }
    
    /*public function output() {
        $this->set_title('/ Kriva adresa');
        //$this->add_js('jquery-2.1.3.min');
        
        $page = new Template('page/standard');
        $page->set('head-data', $this->get_head_data() );
        $page->set('title', $this->get_title() );
        
        $content = new Template('body/error');
        $page->set('body', $content->fill() );
        
        if(Auth::login_check() == false) {
            $userprofile = new Template('data/user_profile_menu_login');
            $page->set('user-profile-menu', $userprofile->fill() );
        } else {
            $user = Auth::get_user();
            
            $userprofile = new Template('data/user_profile_menu');
            $userprofile->set('username-link', $user['username']);
            $userprofile->set('username',$user['username']);
            $page->set('user-profile-menu', $userprofile->fill() );
        }
        
        $page->set('option1', '');
        $page->set('option2', '');
        $page->set('option3', '');
        $page->set('option4', '');
        $page->set('option5', '');
        
        $page->set('project_root_path', WEBSITE_ROOT_PATH);
        
        return $page->fill();
    }*/
}

?>