<?php

class Areas_view extends Webpage_view {
    public function view($areas=array() ) {
        $page = $this->view_prepare();
        
        $content = new Body_table_template('Područja');
        
        $table1 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_ACTIVE);
        
        $content->set_tabledata($table1);
        
        $page->set_body($content->fill() );
        
        return $page->fill();
    }
    
    public function view_2($areas=array() ) {
        $page = $this->view_prepare();
        
        $content = new Body_table_template('Područja');
        
        $table1 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_ACTIVE);
        
        $content->set_tabledata($table1);
        
        $page->set_body($content->fill() );
        
        return $page->fill();
    }
    
    public function crud($areas=array() ) {
        $page = $this->view_prepare();
        
        $crud_create = '<div style="text-align:right">' . Crud::get_html_c('/areas') . '</div>';
        
        $table1 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_ACTIVE, 'rud');
        $table2 = $this->create_table_areas($areas, PROJECT_DATA_STATUS_DELETED, 'ru');
        
        $content = new Body_table_template('Područja');
        $content->set_tabledata(
            $crud_create . 
            '<h3>Aktivna područja</h3>' . $table1 . 
            '<h3>Izbrisana područja</h3>' . $table2);
        
        $page->set_body($content->fill() );
        
        return $page->fill();
    }
    
    public function crud_create() {
        $page = $this->view_prepare();
        
        $content = new Crud_podrucja();
        $content->set('link-back', 'areas/view');
        $content->set('link', 'areas/create');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_read($data) {
        $page = $this->view_prepare();
        
        $content = new Crud_podrucja();
        $content->fill_data($data);
        $content->set('link-back', 'areas/view');
        $content->set('link', 'areas/read/'.$data['id_podrucja']);
        $content->set('status-'.$data['status'], 'selected');
        $content->set('readonly', 'readonly');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_update($data) {
        $page = $this->view_prepare();
        
        $content = new Crud_podrucja();
        $content->fill_data($data);
        $content->set('link-back', 'areas/view');
        $content->set('link', 'areas/update/'.$data['id_podrucja']);
        $content->set('status-'.$data['status'], 'selected');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    public function crud_delete($data) {
        $page = $this->view_prepare();
        
        $content = new Crud_podrucja();
        $content->fill_data($data);
        $content->set('link-back', 'areas/view');
        $content->set('link', 'areas/delete/'.$data['id_podrucja']);
        $content->set('status-'.$data['status'], 'selected');
        $content->set('readonly', 'readonly');
        
        $page->set_body($content->fill() );
        return $page->fill();
    }
    
    
    protected function create_table_areas($data='', $type=PROJECT_DATA_STATUS_ACTIVE, $crud=false, $headers=true) {
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
                            $table .= '<td style="white-space: nowrap">' . Crud::get_html_rud('/areas', '/'.$d['ID']) . '</td>';
                        else
                            $table .= '<td style="white-space: nowrap">' . Crud::get_html_ru('/areas', '/'.$d['ID']) . '</td>';
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
        $page = new Standard_template('Područja');
        $page->set('option-areas', ' selected');
        
        return $page;
    }
}

?>