<?php

class Areas_view extends Webpage_view {
    public function output() {
        
    }
    
    public function view($areas=array() ) {
        $userprofile = new Template('data/user_profile_menu_login');
        
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
    
    public function view_auth($user, $areas=array() ) {
        $page = $this->view_auth_prepare($user);
        
        $content0 = new Template('<a style="text-align:right;display:block;padding-right:30px" href="{@project_root_path}/areas/edit">Edit</a>', true);
        
        $table1 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_ACTIVE);
        $table2 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_DELETED);
        $content1 = new Body_table_template('Područja');
        $content1->set_tabledata(
            $content0->fill() .
            '<h3>Aktivna područja</h3>' . $table1 . 
            '<h3>Izbrisana područja</h3>' . $table2);
        
        $content = $content1->fill();
        
        $page->set_body($content);
        
        return $page->fill();
    }
    
    public function edit_auth($user, $areas=array() ) {
        $page = $this->view_auth_prepare($user);
        
        /*$content0 = new Template('<a style="text-align:right;display:block;padding-right:30px" href="{@project_root_path}/areas/edit">Edit</a>', true);
        
        $table1 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_ACTIVE);
        $table2 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_DELETED);
        $content1 = new Body_table_template('Područja');
        $content1->set_tabledata(
            //$content0->fill() .
            '<h3>Aktivna područja</h3>' . $table1 . 
            '<h3>Izbrisana područja</h3>' . $table2);
        
        $content = $content1->fill();*/
        
        $content = new Body_table_template('Informacija', '<p>Uređivanje još nije dostupno.</p>');
        
        $page->set_body($content->fill() );
        
        return $page->fill();
    }
    
    
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
    
    protected function view_auth_prepare($user) {
        $user = Auth::get_user();
        
        $userprofile = new Template('data/user_profile_menu');
        $userprofile->set('username-link', $user['username']);
        $userprofile->set('username',$user['username']);
        
        $page = new Standard_template('Područja', '', 
                                      '', 
                                      $userprofile->fill() );
        $page->set('option-areas', ' selected');
        
        return $page;
    }
}

?>