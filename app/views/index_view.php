<?php

class Index_view extends Webpage_view {
    public function output() {
        $this->set_title('Početna');
        //$this->add_js('jquery-2.1.3.min');
        
        $page = new Template('page/standard');
        $page->set('head-data', $this->get_head_data() );
        $page->set('title', $this->get_title() );
        
        $content = new Template('body/index');
        $page->set('body', $content->fill() );
        
        $userprofile = new Template('data/user_profile_menu_login');
        $page->set('user-profile-menu', $userprofile->fill() );
        
        $page->set('option1', ' selected');
        $page->set('option2', '');
        $page->set('option3', '');
        $page->set('option4', '');
        $page->set('option5', '');
        
        return $page->fill();
    }
    
    public function admin() {
        $this->set_title('Početna -- admin pogled');
        //$this->add_js('jquery-2.1.3.min');
        
        $page = new Template('page/standard');
        $page->set('head-data', $this->get_head_data() );
        $page->set('title', $this->get_title() );
        
        $content = new Template('body/index');
        $page->set('body', $content->fill() );
        
        $userprofile = new Template('data/user_profile_menu');
        $userprofile->set('username-link', Auth::get_user()['username']);
        $userprofile->set('username', Auth::get_user()['username']);
        $page->set('user-profile-menu', $userprofile->fill() );
        
        $page->set('option1', ' selected');
        $page->set('option2', '');
        $page->set('option3', '');
        $page->set('option4', '');
        $page->set('option5', '');
        
        return $page->fill();
    }
}

?>