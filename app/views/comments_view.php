<?php

class Comments_view extends Webpage_view {
    public function crud_create($userid, $articleid) {
        $page = $this->view_prepare();
        
        $content = new Crud_comments();
        $content->set('link-back', 'areas/view');
        $content->set('link', 'comments/create/' . $articleid);
        
        $content->set('id_korisnika', $userid);
        $content->set('id_clanka', $articleid);
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    
    protected function view_prepare() {
        $page = new Standard_template('Područja');
        $page->set('option-comments', ' selected');
        
        return $page;
    }
}

?>