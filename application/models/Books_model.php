<?php

class Books_model extends CI_Model {

public function getBook($id = null) {

    if($id === null) {
        return $this->db->get('books')->result_array();
    }
    return $this->db->get_where('books', ['book_id' => $id ] )->result_array();
}

public function deleteBook($id) {
    $this->db->delete('books', ['book_id' => $id]);
    return $this->db->affected_rows();
}

public function createBook($data) {
    $this->db->insert('books', $data);
    return $this->db->affected_rows();
}

public function updateBook($data, $id) {
    $this->db->update('books', $data, ['book_id' => $id]);
    return $this->db->affected_rows();
}

public function getBookWithLimit($offset = 10) {
    

    if($offset === null) {
    return $this->db->get('books', 10)->result_array();
} else {
    $newOffset = $offset - 10;
 return $this->db->get('books', 10, $newOffset)->result_array();
}

}

public function jumlahData() {
    return$this->db->get("books")->num_rows();
}
}