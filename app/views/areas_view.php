<?php

class Areas_view extends Webpage_view {
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
    
    public function crud($user, $areas=array() ) {
        $page = $this->view_auth_prepare($user);
        
        $crud_create = '<div style="text-align:right">' . Crud::get_html_c('/areas') . '</div>';
        
        $table1 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_ACTIVE, 'rud');
        $table2 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_DELETED, 'ru');
        
        $content = new Body_table_template('Područja');
        $content->set_tabledata(
            $crud_create . 
            '<h3>Aktivna područja</h3>' . $table1 . 
            '<h3>Izbrisana područja</h3>' . $table2);
        
        $page->set_body($content->fill() );
        
        return $page->fill();
    }
    
    public function crud_create($user) {
        $page = $this->view_auth_prepare($user);
        $content = new Template(Crud::create('table-podrucja-crud-c'), true);
        $content->set('link-back', 'areas/crud');
        $content->set('link', 'areas/crud/create');
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_read($user, $data) {
        $page = $this->view_auth_prepare($user);
        $content = new Template(Crud::read('table-podrucja-crud-r', $data), true);
        $content->set('link-back', 'areas/crud');
        $content->set('link', 'areas/crud/read');
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_update($user, $data) {
        $page = $this->view_auth_prepare($user);
        $content = new Template(Crud::update('table-podrucja-crud-u', $data), true);
        $content->set('link-back', 'areas/crud');
        $content->set('link', 'areas/crud/update');
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_delete($user, $data) {
        $page = $this->view_auth_prepare($user);
        $content = new Template(Crud::delete('table-podrucja-crud-d', $data), true);
        $content->set('link-back', 'areas/crud');
        $content->set('link', 'areas/crud/delete');
        $page->set_body($content->fill() );
        return $page->fill();
    }
    
    
    protected function create_table_areas($data='', $type=PROJECT_DATA_STATUS_ACTIVE, $crud=false, $headers=true) {
        $table = '';
        $cnt = 0;
        if(count($data) > 0) {
            $table = '<table>';
            if($headers == true) {
                $table .= '<tr>';
                foreach($data[0] as $key=>$val)
                    $table .= '<th>' . $key . '</th>';
                if($crud != false) {
                    $table .= '<th>CRUD</th>';
                }
                $table .= '</tr>';
            }
            
            foreach($data as $d) {
                if($d['Status'] == $type) {
                    $table .= '<tr>';
                    foreach($d as $key=>$val)
                        $table .= '<td>' . $val . '</td>';
                    if($crud != false) {
                        if($crud=='rud')
                            $table .= '<td>' . Crud::get_html_rud('/areas', '/'.$d['ID']) . '</td>';
                        else
                            $table .= '<td>' . Crud::get_html_ru('/areas', '/'.$d['ID']) . '</td>';
                    }
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