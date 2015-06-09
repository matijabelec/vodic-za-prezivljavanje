<?php

class Users_view extends Webpage_view {
    public function output() {
        $userprofile = new Template('data/user_profile_menu_login');
        
        $page = new Standard_template('Početna', '', 
                                      '',
                                      $userprofile->fill() );
        $page->set('option-users', ' selected');
        
        return $page->fill();
    }
    
    public function view($users=array() ) {
        $userprofile = '';
        if(Auth::login_check() == false) {
            $userprofile = new Template('data/user_profile_menu_login');
        } else {
            $user = Auth::get_user();
            
            $userprofile = new Template('data/user_profile_menu');
            $userprofile->set('username-link', $user['username']);
            $userprofile->set('username',$user['username']);
        }
        
        $content = new Body_table_template('Korisnici');
        
        $table = '';
        if(count($users) > 0) {
            $table = '<table>';
            $table .= '<tr>';
            foreach($users[0] as $key=>$val)
                $table .= '<th>' . $key . '</th>';
            $table .= '</tr>';
            
            foreach($users as $user) {
                $table .= '<tr>';
                foreach($user as $key=>$val)
                    $table .= '<td>' . $val . '</td>';
                $table .= '</tr>';
            }
            $table .= '</table>';
        }
        
        $content->set_tabledata($table);
        
        $page = new Standard_template('Početna', '', 
                                      $content->fill(), 
                                      $userprofile->fill() );
        $page->set('option-users', ' selected');
        
        return $page->fill();
    }
}

?>