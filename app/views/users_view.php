<?php

class Users_view extends Webpage_view {
    protected function create_table_users($data='', $type=PROJECT_DATA_USER_STATUS_ACTIVATED, $headers=true) {
        $table = '';
        $cnt = 0;
        if(count($data) > 0) {
            $table = '<table>';
            if($headers == true) {
                $table .= '<tr>';
                foreach($data[0] as $key=>$val)
                    $table .= '<th>' . $key . '</th>';
                $table .= '</tr>';
            }
            
            foreach($data as $user) {
                if($user['Status'] == $type) {
                    $table .= '<tr>';
                    foreach($user as $key=>$val)
                        $table .= '<td>' . $val . '</td>';
                    $table .= '</tr>';
                    $cnt++;
                }
            }
            $table .= '</table>';
        }
        if($cnt == 0)
            return '<p>Nema podataka</p>';
        return $table;
    }
    
    public function output() {
        
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
        
        $table1 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_ACTIVATED);
        $table2 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_REGISTERED);
        $table3 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_BLOCKED);
        $table4 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_DELETED);
        
        $content->set_tabledata(
            '<h3>Aktivirani korisnici</h3>' . $table1 . 
            '<h3>Registrirani korisnici</h3>' . $table2 . 
            '<h3>Blokirani korisnici</h3>' . $table3 . 
            '<h3>Izbrisani korisnici</h3>' . $table4);
        
        $page = new Standard_template('Korisnici', '', 
                                      $content->fill(), 
                                      $userprofile->fill() );
        $page->set('option-users', ' selected');
        
        return $page->fill();
    }
}

?>