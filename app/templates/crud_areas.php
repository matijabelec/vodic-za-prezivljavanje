<?php

class Crud_podrucja extends Template {
    public function __construct() {
        parent::__construct('data/table-podrucja-crud');
        
        $this->set('link-back', '');
        $this->set('link', '');
        
        $this->set('id_podrucja', '0');
        $this->set('naziv_podrucja', '');
        $this->set('opis', '');
        $this->set('slika', '');
        
        $this->set('status-0', '');
        $this->set('status-1', '');
        
        $this->set('readonly', '');
        
        $this->set('title', '');
        $this->set('data', '');
        $this->set('btn-submit', 'Potvrdi');
        
        $this->set('menu-top', '');
        $this->set('menu-bottom', '');
        
        $this->set('project_root_path', WEBSITE_ROOT_PATH);
    }
    
    public function fill_data($data) {
        if(isset($data) && is_array($data) ) {
            foreach($data as $key=>$val) {
                $this->set($key, $val);
            }
        }
    }
    
    public function create_menu($data) {
        $create = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/create">Novo</a> ';
        $read = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/read/{@id_podrucja}">Više</a> ';
        $update = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/update/{@id_podrucja}">Uredi</a> ';
        $delete = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/delete/{@id_podrucja}">Izbriši</a> ';
        $activate = '<a class="btn" href="' . WEBSITE_ROOT_PATH . '/areas/create/{@id_podrucja}">Aktiviraj</a> ';
        
        $m = '';
        foreach($data as $d)
            switch($d) {
                case 'c': $m  .= $create; break;
                case 'r': $m  .= $read; break;
                case 'u': $m  .= $update; break;
                case 'd': $m  .= $delete; break;
                case 'a': $m  .= $activate; break;
                default: break;
            }
        return $m;
    }
}

?>