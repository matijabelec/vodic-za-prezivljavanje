<?php

class Index_view extends Webpage_view {
    public function output() {
        $content = new Template('body/index');
        $userprofile = new Template('data/user_profile_menu_login');
        
        $page = new Standard_template('Početna');
        $page->set_body($content->fill() );
        $page->set('option-home', ' selected');
        
        return $page->fill();
    }
    
    public function admin() {
        $user = Auth::get_user();
        
        $content = new Template('body/index-auth');
        
        $userprofile = new Template('data/user_profile_menu');
        $userprofile->set('username-link', $user['username']);
        $userprofile->set('username', $user['username']);
        
        $page = new Standard_template('Početna -- registrirani korisnik');
        $page->set_body($content->fill() );
        $page->set('option-home', ' selected');
        
        return $page->fill();
    }
}

?>