<?php

class Devotional_model extends CI_Model {

public function getDevotional($vol = null) {

    if($vol === null) {
        return $this->db->get('devotional')->result_array();
    }
    return $this->db->get_where('devotional', ['vol' => $vol ] )->result_array();
}

public function deleteDevotional($vol) {
    $this->db->delete('devotional', ['vol' => $vol]);
    return $this->db->affected_rows();
}

public function createDevotional($data) {
    $this->db->insert('devotional', $data);
    return $this->db->affected_rows();
}

public function updateDevotional($data, $vol) {
    $this->db->update('devotional', $data, ['vol' => $vol]);
    return $this->db->affected_rows();
}

public function getDevotionalWithLimit($offset = 10) {
    

    if($offset === null) {
    return $this->db->get('devotional')->result_array();
} else {
    $newOffset = $offset - 10;
 return $this->db->get('devotional', 10, $newOffset)->result_array();
}

}

public function jumlahData() {
    return$this->db->get("devotional")->num_rows();
}
}
