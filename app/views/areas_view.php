<?php

class Areas_view extends Webpage_view {
    protected function create_table_areas($data='', $type=PROJECT_DATA_STATUS_ACTIVE, $headers=true) {
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
            
            foreach($data as $d) {
                if($d['Status'] == $type) {
                    $table .= '<tr>';
                    foreach($d as $key=>$val)
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
        
        $table1 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_ACTIVE);
        $table2 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_DELETED);
        
        $content->set_tabledata(
            '<h3>Aktivna područja</h3>' . $table1 . 
            '<h3>Izbrisana područja</h3>' . $table2);
        
        $page = new Standard_template('Područja', '', 
                                      $content->fill(), 
                                      $userprofile->fill() );
        $page->set('option-areas', ' selected');
        
        return $page->fill();
    }
}

?>