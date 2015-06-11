<?php

class Standard_template extends Template {
    public function __construct($title) {
        parent::__construct('page/standard');
        
        $this->set('head-data', '');
        $this->set('title', $title);
        
        $this->set('project-title', PROJECT_TITLE);
        $this->set('copyright-info-data', PROJECT_COPYRIGHT_INFO);
        
        $this->set('body', '');
        
        $this->set('option-documentation', '');
        $this->set('option-about-author', '');
        
        
        // prepare user profile preview
        $user = Auth::get_user();
        if($user == null) {
            $this->set('style-user-type-id', '');
        } else {
            $this->set_user_type_style();
        }
        
        if($user == null) {
            $userprofile = new Template('data/user_profile_menu_login');
        } else {
            $userprofile = new Template('data/user_profile_menu');
            $userprofile->set('username-link', $user['username']);
            $userprofile->set('username',$user['username']);
        }
        
        // prepare menu
        $mainmenu = new Template('data/main-menu');
        $mainmenu->set('user-profile-menu', $userprofile->fill() );
        $this->set('main-menu', $mainmenu->fill() );
        $this->set('main-menu-options', '');
        
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $this->create_main_menu(array('Početna', 'Korisnici', 'Područja', 'Admin') );
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_MODERATOR) ) {
            $this->create_main_menu(array('Početna', 'Korisnici', 'Područja') );
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            $this->create_main_menu(array('Početna', 'Korisnici', 'Područja') );
        } else {
            $this->create_main_menu(array('Početna', 'Korisnici', 'Područja') );
        }
        
        $this->set('usermenu-registration', '');
        $this->set('usermenu-login', '');
        $this->set('usermenu-logout', '');
        $this->set('usermenu-user', '');
        
        $this->set('project_root_path', WEBSITE_ROOT_PATH);
    }
    
    public function create_main_menu($options) {
        $mm = '';
        $arr_id = array();
        if(is_array($options) ) {
            foreach($options as $name) {
                switch($name) {
                    case 'Početna':
                        $mm .= $this->create_menu_option('option-home', 'index', 'Početna');
                        $arr_id[] = 'option-home';
                        break;
                    case 'Korisnici':
                        $mm .= $this->create_menu_option('option-users', 'users', 'Korisnici');
                        $arr_id[] = 'option-users';
                        break;
                    case 'Područja':
                        $mm .= $this->create_menu_option('option-areas', 'areas', 'Područja');
                        $arr_id[] = 'option-areas';
                        break;
                    case 'Admin':
                        $mm .= $this->create_menu_option('option-admin', 'admin', 'Admin');
                        $arr_id[] = 'option-admin';
                        break;
                    default:
                        break;
                }
            }
        }
        $this->set('main-menu-options', $mm);
        foreach($arr_id as $id)
            $this->set($id, '');
    }
    
    protected function create_menu_option($id, $link, $name) {
        $option = '<li><a class="menu-option{@'.$id.'}" href="{@project_root_path}/'.$link.'">'.$name.'</a></li>';
        return $option;
    }
    
    public function set_user_type_style() {
        $style = ' style="background-color: ';
        if(Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            $this->set('style-user-type-id', $style.'#ff0000"');
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_MODERATOR) ) {
            $this->set('style-user-type-id', $style.'#00ff00"');
        } elseif(Auth::user_role_check(PROJECT_USER_ROLE_REGISTERED) ) {
            $this->set('style-user-type-id', $style.'#0000ff"');
        } else {
            $this->set('style-user-type-id', '');
        }
    }
    
    public function set_headdata($head) {
        $this->set('head-data', $head);
    }
    
    public function set_title($title) {
        $this->set('title', $title);
    }
    public function set_body($body) {
        $this->set('body', $body);
    }
}

?>