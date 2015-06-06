<?php

class Authors_model extends Model {
    public function get_authors() {
        $db = Database::connect();
        
        $st = $db->prepare("SELECT * FROM authors_view");
        $st->execute();
        $result = $st->fetchAll();
        
        Database::disconnect();
        
        $ad = [];
        foreach($result as $row) {
            if(isset($ad[$row['member_id'] ]) ) {
                $ad[$row['member_id'] ]['contact'][] = [
                    'type' => $row['contact_typename'],
                    'code' => $row['contact_code'],
                    'data' => $row['contact_data']
                ];
            } else {
                $ad[$row['member_id'] ] = [
                    'id' => '',
                    'name' => $row['firstname'].' '.$row['lastname'],
                    'role' => $row['jobs'],
                    'bio' => $row['bio'],
                    'more-link' => '/about/author/'.$row['id'],
                    'contact' => [ [
                        'type' => $row['contact_typename'],
                        'code' => $row['contact_code'],
                        'data' => $row['contact_data']
                    ] ]
                ];
            }
        }
        return $ad;
    }
    
    public function get_author($id) {
        $db = Database::connect();
        
        $st = $db->prepare("SELECT * FROM authors_view WHERE id = :id");
        $st->execute(['id'=>$id]);
        $result = $st->fetchAll();
        
        Database::disconnect();
        
        if(0 == count($result) )
            return RET_ERR;
        
        $ad = [];
        foreach($result as $row) {
            if(isset($ad[$row['member_id'] ]) ) {
                $ad[$row['member_id'] ]['contact'][] = [
                    'type' => $row['contact_typename'],
                    'code' => $row['contact_code'],
                    'data' => $row['contact_data']
                ];
            } else {
                $ad[$row['member_id'] ] = [
                    'id' => '',
                    'name' => $row['firstname'].' '.$row['lastname'],
                    'role' => $row['jobs'],
                    'bio' => $row['bio'],
                    'more-link' => '/about/author/'.$row['id'],
                    'contact' => [ [
                        'type' => $row['contact_typename'],
                        'code' => $row['contact_code'],
                        'data' => $row['contact_data']
                    ] ]
                ];
            }
        }
        return $ad;
    }
}

?>