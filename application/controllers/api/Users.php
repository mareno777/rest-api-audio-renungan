<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Users extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model', 'user');

        $this->methods['index_get']['limit'] = 60;
    }

    public function index_get() {

        $email = $this->get('email');
        $page = $this->get('page');
        $jumlahData = $this->user->jumlahData();


        if ($email === null) {

        if($page === null) {
            $page = 1;
            $user = $this->user->getUsersWithLimit($page * 10);
        } else {
            $user = $this->user->getUsersWithLimit($page * 10);
        }

            
        } else {
            $user = $this->user->getUsers($email);
        }
        
        if($user) {
            $this->response([
                'status' => REST_Controller::HTTP_OK,
                'data' => $user,
                'current_page' => (int) $page,
                'total_pages' => ceil($jumlahData /10)
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => REST_Controller::HTTP_NOT_FOUND,
                'message' => 'User tidak ditemukan',
                'data' => []
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete() {

        $email = $this->delete('email');

        if($email === null) {
            $this->response([
                'status' => REST_Controller::HTTP_BAD_REQUEST,
                'message' => 'Provde an email!',
                'data' => $email
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->user->deleteUser($email) > 0) {
                $this->response([
                    'status' => REST_Controller::HTTP_OK,
                    'message' => 'User Dihapus'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => REST_Controller::HTTP_BAD_REQUEST,
                    'message' => 'email tidak ditemukan!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            
        }
    }

    public function index_post() {
        $data = [
            'email' => $this->post('email'),
            'nik' => $this->post('nik'),
            'no_hp' => $this->post('no_hp'),
            'nama_lengkap' => $this->post('nama_lengkap')
        ];

        if($this->user->createUser($data) > 0) {
            $this->response([
                'status' => REST_Controller::HTTP_CREATED,
                'message' => 'berhasil ditambahkan'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => REST_Controller::HTTP_BAD_REQUEST,
                'message' => 'Gagal menambah user'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put() {

        $email = $this->put('email');
        $data = [
            'nik' => $this->put('nik'),
            'no_hp' => $this->put('no_hp'),
            'nama_lengkap' => $this->put('nama_lengkap')
            
        ];

        if($this->user->updateUser($data, $email) > 0) {
            $this->response([
                'status' => REST_Controller::HTTP_OK,
                'message' => 'berhasil diperbarui'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => REST_Controller::HTTP_BAD_REQUEST,
                'message' => 'Gagal memperbarui user'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}