<?php

class Index_view extends Webpage_view {
    public function output() {
        $content = new Template('body/index');
        $userprofile = new Template('data/user_profile_menu_login');
        
        $page = new Standard_template('Početna', '', 
                                      $content->fill(), 
                                      $userprofile->fill() );
        $page->set('option1', ' selected');
        
        return $page->fill();
    }
    
    public function admin() {
        $user = Auth::get_user();
        
        $content = new Template('body/index');
        
        $userprofile = new Template('data/user_profile_menu');
        $userprofile->set('username-link', $user['username']);
        $userprofile->set('username', $user['username']);
        
        $page = new Standard_template('Početna -- admin pogled', '', 
                                      $content->fill(), 
                                      $userprofile->fill() );
        $page->set('option1', ' selected');
        
        return $page->fill();
    }
}

?>