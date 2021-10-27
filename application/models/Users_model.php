<?php

class Users_model extends CI_Model {

    public function getUsers($email = null) {

        if($email === null) {
            return $this->db->get('users')->result_array();
        }
        return $this->db->get_where('users', ['email' => $email ] )->result_array();
    }

    public function deleteUser($email) {
        $this->db->delete('users', ['email' => $email]);
        return $this->db->affected_rows();
    }

    public function createUser($data) {
        $this->db->insert('users', $data);
        return $this->db->affected_rows();
    }

    public function updateUser($data, $email) {
        $queryUpdateLastLogin = "UPDATE users
        SET last_login = NOW()
        WHERE email = $email";
        $this->db->query($queryUpdateLastLogin);
        return $this->db->affected_rows();
    }

    public function getUsersWithLimit($offset = 10) {
        

        if($offset === null) {
        return $this->db->get('users', 10)->result_array();
    } else {
        $newOffset = $offset - 10;
     return $this->db->get('users', 10, $newOffset)->result_array();
    }

    }

    public function jumlahData() {
        return$this->db->get("users")->num_rows();
    }
}