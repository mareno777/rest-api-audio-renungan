<?php

class Btat_model extends CI_Model {

    public function getBtat($vol = null) {

        if($vol === null) {
            return $this->db->get('btat')->result_array();
        }
        return $this->db->get_where('btat', ['vol' => $vol ] )->result_array();
    }

    public function deleteBtat($vol) {
        $this->db->delete('btat', ['vol' => $vol]);
        return $this->db->affected_rows();
    }

    public function createBtat($data) {
        $this->db->insert('btat', $data);
        return $this->db->affected_rows();
    }

    public function updateBtat($data, $vol) {
        $this->db->update('btat', $data, ['vol' => $vol]);
        return $this->db->affected_rows();
    }

    public function getBtatWithLimit($offset = 10) {
        

        if($offset === null) {
        return $this->db->get('btat', 10)->result_array();
    } else {
        $newOffset = $offset - 10;
     return $this->db->get('btat', 10, $newOffset)->result_array();
    }

    }

    public function jumlahData() {
        return$this->db->get("btat")->num_rows();
    }
}