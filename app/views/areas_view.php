<?php

class Areas_view extends Webpage_view {
    public function output() {
        $userprofile = new Template('data/user_profile_menu_login');
        
        $page = new Standard_template('Područja', '', 
                                      '', 
                                      $userprofile->fill() );
        $page->set('option-areas', ' selected');
        
        return $page->fill();
    }
    
    public function view($areas=array() ) {
        $userprofile = '';
        if(Auth::login_check() == false) {
            $userprofile = new Template('data/user_profile_menu_login');
        } else {
            $user = Auth::get_user();
            
            $userprofile = new Template('data/user_profile_menu');
            $userprofile->set('username-link', $user['username']);
            $userprofile->set('username',$user['username']);
        }
        
        $content = new Body_table_template('Područja');
        
        $table = '';
        if(count($areas) > 0) {
            $table = '<table>';
            $table .= '<tr>';
            foreach($areas[0] as $key=>$val)
                $table .= '<th>' . $key . '</th>';
            $table .= '</tr>';
            
            foreach($areas as $area) {
                $table .= '<tr>';
                foreach($area as $key=>$val)
                    $table .= '<td>' . $val . '</td>';
                $table .= '</tr>';
            }
            $table .= '</table>';
        }
        $content->set_tabledata($table);
        
        $page = new Standard_template('Područja', '', 
                                      $content->fill(), 
                                      $userprofile->fill() );
        $page->set('option-areas', ' selected');
        
        return $page->fill();
    }
}

?>