<?php

class Webpage_view extends View {
    private $title = '';
    private $head_data = '';
    
    public function set_title($title) {
        $this->title = $title;
    }
    public function get_title() {
        return $this->title;
    }
    
    public function add_css($stylename) {
        $this->head_data .= "<link rel=\"stylesheet\" href=\"/site/css/$stylename.css\"/>";
    }
    public function add_js($scriptname, $external=false) {
        if(false === $external)
            $this->head_data .= "<script src=\"/site/js/$scriptname.js\"></script>";
        else
            $this->head_data .= "<script src=\"$scriptname\"></script>";
    }
    public function add_js_inline($script) {
        $this->head_data .= "<script>$script</script>";
    }
    public function get_head_data() {
        return $this->head_data;
    }
    
    public function main_section($content, $id=null) {
        $main_section = new Template('main-section');
        $main_section->set('id', null===$id ? '' : "id=\"$id\" ");
        $main_section->set('content', $content);
        $main_section->set('class', 'class="centered"');
        return $main_section->fill();
    }
}

?>