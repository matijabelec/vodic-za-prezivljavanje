<?php

class Users_controller extends Webpage_controller {
    public function __construct() {
        $this->view = new Users_view;
        $this->model = new Users_model;
    }
    
    public function index($args) {
        if(count($args) != URL_INDEX_ARGUMENTS_NONE)
            return RET_ERR;
        
        Redirect('/users/view');
    }
    
    public function view($args) {
        if(count($args) != URL_ARGUMENTS_NONE)
            return RET_ERR;
        
        // if user is logged in
        if(Auth::login_check() && Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Redirect('/users/crud');
        }
        
        // show page
        $users = $this->model->get_users_safe();
        echo $this->view->view($users);
    }
    
    public function crud($args) {
        // check if user is not logged in
        if(!Auth::login_check() || !Auth::user_role_check(PROJECT_USER_ROLE_ADMIN) ) {
            Redirect('/users/view');
        }
        
        // get logged user's data
        $user = Auth::get_user();
        
        // get areas
        $users = $this->model->get_users();
        
        if(count($args) == URL_ARGUMENTS_1) {
            if($args[URL_ARG_1] == 'create') {
                if(isset($_POST['id_korisnika']) && 
                   isset($_POST['id_tipa_korisnika']) && 
                   isset($_POST['korisnicko_ime']) && 
                   isset($_POST['lozinka']) && 
                   isset($_POST['mail']) && 
                   isset($_POST['ime']) && 
                   isset($_POST['prezime']) && 
                   isset($_POST['slika_korisnika']) && 
                   isset($_POST['status']) ) {
                    $st = $_POST['status'];
                    if($st==0 && $user['userid'] == $id_kor)
                        break;
                    if($st >= 0 && $st <=3) {
                        Database::query('INSERT INTO korisnici(korisnicko_ime, lozinka, mail, ime, prezime, slika_korisnika, id_tipa_korisnika, status) VALUES(:korime, :lozinka, :mail, :ime, :prezime, :slika, :id_tip, :status)',
                        array('korime' => $_POST['korisnicko_ime'],
                              'lozinka' => $_POST['lozinka'],
                              'mail' => $_POST['mail'],
                              'ime' => $_POST['ime'],
                              'prezime' => $_POST['prezime'],
                              'slika' => $_POST['slika_korisnika'],
                              'id_tip' => $_POST['id_tipa_korisnika'],
                              'status' => $st) );
                        Redirect('/users/crud');
                    }
                }
                echo $this->view->crud_create($user);
                return;
            } else
                Redirect('/users/view');
        }
        
        if(count($args) >= URL_ARGUMENTS_2) {
            $data_korisnik = Database::query('SELECT * FROM korisnici WHERE id_korisnika = :id', array('id'=>$args[URL_ARG_2]) );
            switch($args[URL_ARG_1]) {
                case 'read':
                    if(isset($_POST['id_korisnika']) ) {
                        Redirect('/users/crud');
                    }
                    break;
                case 'update':
                    if(isset($_POST['id_korisnika']) && 
                       isset($_POST['id_tipa_korisnika']) && 
                       isset($_POST['korisnicko_ime']) && 
                       isset($_POST['lozinka']) && 
                       isset($_POST['mail']) && 
                       isset($_POST['ime']) && 
                       isset($_POST['prezime']) && 
                       isset($_POST['slika_korisnika']) && 
                       isset($_POST['status']) ) {
                        $id_kor = $_POST['id_korisnika'];
                        $st = $_POST['status'];
                        if($st==0 && $user['userid'] == $id_kor)
                            break;
                        if($st >= 0 && $st <=3) {
                            Database::query('UPDATE korisnici SET korisnicko_ime=:korime, lozinka=:lozinka, mail=:mail, ime=:ime, prezime=:prezime, slika_korisnika=:slika, id_tipa_korisnika=:id_tip, status=:status WHERE id_korisnika=:korid',
                            array('korid' => $id_kor,
                                  'korime' => $_POST['korisnicko_ime'],
                                  'lozinka' => $_POST['lozinka'],
                                  'mail' => $_POST['mail'],
                                  'ime' => $_POST['ime'],
                                  'prezime' => $_POST['prezime'],
                                  'slika' => $_POST['slika_korisnika'],
                                  'id_tip' => $_POST['id_tipa_korisnika'],
                                  'status' => $st) );
                            Redirect('/users/crud');
                        }
                    }
                    break;
                case 'delete':
                    if(isset($_POST['id_korisnika']) ) {
                        $id_kor = $_POST['id_korisnika'];
                        if($user['userid'] != $id_kor) {
                            Database::query('UPDATE korisnici SET status = 0 WHERE id_korisnika = :id', array('id'=>$id_kor) );
                            Redirect('/users/crud');
                        }
                    }
                    break;
                default:
                    Redirect('/users/view');
                    break;
            }
            
            $action = 'crud_' . $args[URL_ARG_1];
            echo $this->view->$action($user, $data_korisnik);
            return;
        }
        
        echo $this->view->crud($user, $users);
    }
}

?>