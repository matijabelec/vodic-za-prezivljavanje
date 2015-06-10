<?php

class Users_view extends Webpage_view {
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
        $content = new Template(Crud::create('table-korisnici-crud-c'), true);
        $content->set('link-back', 'users/crud');
        $content->set('link', 'users/crud/create');
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_read($user, $data) {
        $d = $data[0];
        $page = $this->view_auth_prepare($user);
        $content = new Template(Crud::read('table-korisnici-crud-rd', $data), true);
        $content->set('link-back', 'users/crud');
        $content->set('link', 'users/crud/read/'.$d['id_korisnika']);
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_update($user, $data) {
        $d = $data[0];
        $page = $this->view_auth_prepare($user);
        $content = new Template(Crud::update('table-korisnici-crud-u', $data), true);
        $content->set('link-back', 'users/crud');
        $content->set('link', 'users/crud/update/'.$d['id_korisnika']);
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_delete($user, $data) {
        $d = $data[0];
        $page = $this->view_auth_prepare($user);
        $content = new Template(Crud::delete('table-korisnici-crud-rd', $data), true);
        $content->set('link-back', 'users/crud');
        $content->set('link', 'users/crud/delete/'.$d['id_korisnika']);
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
                            $table .= '<td>' . Crud::get_html_rud('/users', '/'.$d['ID']) . '</td>';
                        else
                            $table .= '<td>' . Crud::get_html_ru('/users', '/'.$d['ID']) . '</td>';
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
        
        $page = new Standard_template('Korisnici', '', 
                                      '', 
                                      $userprofile->fill() );
        $page->set('option-users', ' selected');
        
        return $page;
    }
}

?>