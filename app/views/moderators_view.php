<?php

class Moderators_view extends Webpage_view {
    public function view($moderators) {
        $body = $this->create_table($moderators);
        return $this->page('Moderatori', $body);
    }
    
    public function create($areaid, $users) {
        $body = $this->view_input($areaid, $users);
        return $this->page('Moderatori', $body);
    }
    
    protected function view_input($areaid, $users) {
        $us = '';
        foreach($users as $user)
            $us .= '<option value="' . $user['id_korisnika'] . '">' . $user['korisnicko_ime'] . '</option>';
        
        $moderation = new Template('data/moderators/moderator-input');
        $moderation->set('id_podrucja', $areaid);
        $moderation->set('korisnici', $us);
        $moderation->set('link-back', 'areas/read/' . $areaid);
        $moderation->set('link', 'moderators/create/' . $areaid);
        $mf = $moderation->fill();
        unset($moderation);
        return $mf;
    }
    
    protected function page($title, $body) {
        $page = new Standard_template($title);
        $page->set('option-moderators', ' selected');
        $page->set('body', $body);
        $pf = $page->fill();
        unset($page);
        
        return $pf;
    }
}

?>