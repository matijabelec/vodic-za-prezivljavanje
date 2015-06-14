<?php

class Moderators_view extends Webpage_view {
    public function view($moderators=array() ) {
        $page = $this->view_prepare();
        
        $content = new Body_table_template('Moderatori');
        
        $table = '<a href="' . WEBSITE_ROOT_PATH . '/moderators/create">Dodaj</a>';
        $table .= ' | <a href="' . WEBSITE_ROOT_PATH . '/moderators/delete">Izbriši</a>';
        
        $table .= $this->create_table($moderators);
        
        $content->set_tabledata($table);
        $page->set_body($content->fill() );
        unset($content);
        
        return $page->fill();
    }
    
    public function crud_create($moderation) {
        $page = $this->view_prepare();
        
        $content = new Crud_moderations();
        $content->set('link-back', 'moderators/view');
        $content->set('link', 'moderators/create');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    
    protected function view_prepare() {
        $page = new Standard_template('Moderatori');
        $page->set('option-moderators', ' selected');
        
        return $page;
    }
}

?>