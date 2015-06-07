<?php

class Error_view extends Webpage_view {
    public function output() {
        $userprofile = '';
        if(Auth::login_check() == false) {
            $userprofile = new Template('data/user_profile_menu_login');
        } else {
            $user = Auth::get_user();
            
            $userprofile = new Template('data/user_profile_menu');
            $userprofile->set('username-link', $user['username']);
            $userprofile->set('username',$user['username']);
        }
        
        $content = new Template('body/error');
        
        $page = new Standard_template('Kriva adresa', '', 
                                      $content->fill(), 
                                      $userprofile->fill() );
        $page->set('option1', ' selected');
        
        return $page->fill();
    }
}

?>