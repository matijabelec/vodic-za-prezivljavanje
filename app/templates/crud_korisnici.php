<?php

class Crud_korisnici extends Template {
    public function __construct() {
        parent::__construct('data/table-korisnici-crud');
        
        $this->set('link-back', '');
        $this->set('link', '');
        
        $this->set('id_korisnika', '0');
        $this->set('korisnicko_ime', '');
        $this->set('lozinka', '');
        $this->set('mail', '');
        $this->set('ime', '');
        $this->set('prezime', '');
        $this->set('slika_korisnika', '');
        $this->set('datum_registracije', '');
        
        $this->set('id_tipa_korisnika-1', '');
        $this->set('id_tipa_korisnika-2', '');
        $this->set('id_tipa_korisnika-3', '');
        
        $this->set('status-1', '');
        $this->set('status-2', '');
        $this->set('status-3', '');
        $this->set('status-0', '');
        
        $this->set('readonly', '');
        
        $this->set('title', '');
        $this->set('data', '');
        $this->set('btn-submit', 'Potvrdi');
        
        $this->set('project_root_path', WEBSITE_ROOT_PATH);
    }
    
    public function fill_data($data) {
        if(isset($data) && is_array($data) ) {
            foreach($data as $key=>$val) {
                $this->set($key, $val);
            }
        }
    }
}

?>