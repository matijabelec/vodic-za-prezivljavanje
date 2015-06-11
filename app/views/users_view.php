<?php

class Users_view extends Webpage_view {
    public function view($users=array() ) {
        $page = $this->view_prepare();
        
        $content = new Body_table_template('Korisnici');
        
        $table1 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_ACTIVATED);
        $table2 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_REGISTERED);
        
        $content->set_tabledata(
            '<h3>Aktivirani korisnici</h3>' . $table1 . 
            '<h3>Registrirani korisnici</h3>' . $table2);
        
        $page->set_body($content->fill() );
        
        return $page->fill();
    }
    
    public function view_2($user, $users=array() ) {
        $page = $this->view_auth_prepare($user);
        
        $content = new Body_table_template('Korisnici');
        
        $table1 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_ACTIVATED);
        $table2 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_REGISTERED);
        $table3 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_BLOCKED);
        
        $content->set_tabledata(
            '<h3>Aktivirani korisnici</h3>' . $table1 . 
            '<h3>Registrirani korisnici</h3>' . $table2 . 
            '<h3>Blokirani korisnici</h3>' . $table3);
        
        $page->set_body($content->fill() );
        
        return $page->fill();
    }
    
    public function crud($user, $users=array() ) {
        $page = $this->view_auth_prepare($user);
        
        $crud_create = '<div style="text-align:right">' . Crud::get_html_c('/users') . '</div>';
        
        $table1 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_ACTIVATED, 'rud');
        $table2 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_REGISTERED, 'rud');
        $table3 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_BLOCKED, 'rud');
        $table4 = $this->create_table_users($users, PROJECT_DATA_USER_STATUS_DELETED, 'ru');
        
        $content = new Body_table_template('Korisnici');
        $content->set_tabledata(
            $crud_create . 
            '<h3>Aktivirani korisnici</h3>' . $table1 . 
            '<h3>Registrirani korisnici</h3>' . $table2 . 
            '<h3>Blokirani korisnici</h3>' . $table3 . 
            '<h3>Izbrisani korisnici</h3>' . $table4);
        
        $page->set_body($content->fill() );
        
        return $page->fill();
    }
    
    public function crud_create($user) {
        $page = $this->view_auth_prepare($user);
        
        $content = new Crud_korisnici();
        $content->set('link-back', 'users/view');
        $content->set('link', 'users/create');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_read($user, $data) {
        $page = $this->view_auth_prepare($user);
        
        $content = new Crud_korisnici();
        $content->fill_data($data);
        $content->set('link-back', 'users/view');
        $content->set('link', 'users/read/'.$data['id_korisnika']);
        $content->set('id_tipa_korisnika-'.$data['id_tipa_korisnika'], 'selected');
        $content->set('status-'.$data['status'], 'selected');
        $content->set('readonly', 'readonly');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_update($user, $data) {
        $page = $this->view_auth_prepare($user);
        
        $content = new Crud_korisnici();
        $content->fill_data($data);
        $content->set('link-back', 'users/view');
        $content->set('link', 'users/update/'.$data['id_korisnika']);
        $content->set('id_tipa_korisnika-'.$data['id_tipa_korisnika'], 'selected');
        $content->set('status-'.$data['status'], 'selected');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_delete($user, $data) {
        $page = $this->view_auth_prepare($user);
        
        $content = new Crud_korisnici();
        $content->fill_data($data);
        $content->set('link-back', 'users/view');
        $content->set('link', 'users/delete/'.$data['id_korisnika']);
        $content->set('id_tipa_korisnika-'.$data['id_tipa_korisnika'], 'selected');
        $content->set('status-'.$data['status'], 'selected');
        $content->set('readonly', 'readonly');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    
    protected function create_table_users($data='', $type=PROJECT_DATA_USER_STATUS_ACTIVATED, $crud=false, $headers=true) {
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
                            $table .= '<td style="white-space: nowrap">' . Crud::get_html_rud('/users', '/'.$d['ID']) . '</td>';
                        else
                            $table .= '<td style="white-space: nowrap">' . Crud::get_html_ru('/users', '/'.$d['ID']) . '</td>';
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
    
    protected function view_prepare() {
        $userprofile = new Template('data/user_profile_menu_login');
        
        $page = new Standard_template('Korisnici', '', 
                                      '', 
                                      $userprofile->fill() );
        $page->set('option-users', ' selected');
        
        return $page;
    }
    protected function view_auth_prepare($user) {
        $userprofile = new Template('data/user_profile_menu');
        $userprofile->set('username-link', $user['username']);
        $userprofile->set('username',$user['username']);
        
        $page = new Standard_template('Korisnici', '', 
                                      '', 
                                      $userprofile->fill() );
        $page->set('option-users', ' selected');
        
        return $page;
    }
}

?>