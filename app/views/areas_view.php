<?php

class Areas_view extends Webpage_view {
    public function output() {
        $userprofile = new Template('data/user_profile_menu_login');
        
        $page = new Standard_template('Područja', '', 
                                      'Korisnici...',//$content->fill(), 
                                      $userprofile->fill() );
        $page->set('option-areas', ' selected');
        
        return $page->fill();
    }
    
    public function view($areas=array() ) {
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
        if(count($areas) > 0) {
            $content = '<table>';
            $content .= '<tr>';
            foreach($areas[0] as $key=>$val)
                $content .= '<th>' . $key . '</th>';
            $content .= '</tr>';
            
            foreach($areas as $area) {
                $content .= '<tr>';
                foreach($area as $key=>$val)
                    $content .= '<td>' . $val . '</td>';
                $content .= '</tr>';
            }
            $content .= '</table>';
        }
        
        $page = new Standard_template('Područja', '', 
                                      $content,//->fill(), 
                                      $userprofile->fill() );
        $page->set('option-areas', ' selected');
        
        return $page->fill();
    }
}

?>