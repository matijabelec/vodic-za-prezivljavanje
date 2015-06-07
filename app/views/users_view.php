<?php

class Users_view extends Webpage_view {
    public function output() {
        //$content = new Template('body/index');
        $userprofile = new Template('data/user_profile_menu_login');
        
        $page = new Standard_template('Početna', '', 
                                      'Korisnici...',//$content->fill(), 
                                      $userprofile->fill() );
        $page->set('option1', ' selected');
        
        return $page->fill();
    }
}

?>