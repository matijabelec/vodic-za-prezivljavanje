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
    
    public function view($users=array() ) {
        //$content = new Template('body/index');
        
        $userprofile = '';
        if(Auth::login_check() == false) {
            $userprofile = new Template('data/user_profile_menu_login');
        } else {
            $user = Auth::get_user();
            
            $userprofile = new Template('data/user_profile_menu');
            $userprofile->set('username-link', $user['username']);
            $userprofile->set('username',$user['username']);
        }
        
        $content = '';
        if(count($users) > 0) {
            $content = '<table>';
            $content .= '<tr>';
            foreach($users[0] as $key=>$val)
                $content .= '<th>' . $key . '</th>';
            $content .= '</tr>';
            
            foreach($users as $user) {
                $content .= '<tr>';
                foreach($user as $key=>$val)
                    $content .= '<td>' . $val . '</td>';
                $content .= '</tr>';
            }
            $content .= '</table>';
        }
        
        $page = new Standard_template('Početna', '', 
                                      $content,//->fill(), 
                                      $userprofile->fill() );
        $page->set('option1', ' selected');
        
        return $page->fill();
    }
}

?>