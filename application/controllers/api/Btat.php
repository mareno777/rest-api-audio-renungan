<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Btat extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Btat_model', 'btat');

        $this->methods['index_get']['limit'] = 60;
    }

    public function index_get() {

        $vol = $this->get('vol');
        $page = $this->get('page');
        $jumlahData = $this->btat->jumlahData();


        if ($vol === null) {

        if($page === null) {
            $page = 1;
            $btat = $this->btat->getBtatWithLimit($page * 10);
        } else {
            $btat = $this->btat->getBtatWithLimit($page * 10);
        }

            
        } else {
            $btat = $this->btat->getBtat($vol);
        }
        
        if($btat) {
            $this->response([
                'status' => REST_Controller::HTTP_OK,
                'data' => $btat,
                'current_page' => (int) $page,
                'total_pages' => ceil($jumlahData /10)
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => REST_Controller::HTTP_NOT_FOUND,
                'message' => 'Btat tidak ditemukan',
                'data' => []
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete() {

        $vol = $this->delete('vol');

        if($vol === null) {
            $this->response([
                'status' => REST_Controller::HTTP_BAD_REQUEST,
                'message' => 'Provde an vol!',
                'data' => $vol
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->btat->deleteBtat($vol) > 0) {
                $this->response([
                    'status' => REST_Controller::HTTP_OK,
                    'message' => 'Btat Dihapus'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => REST_Controller::HTTP_BAD_REQUEST,
                    'message' => 'vol tidak ditemukan!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            
        }
    }

    public function index_post() {
        $data = [
            'vol' => $this->post('vol'),
            'nama' => $this->post('nama'),
            'alamat' => $this->post('alamat')
            
        ];

        if($this->btat->createBtat($data) > 0) {
            $this->response([
                'status' => REST_Controller::HTTP_CREATED,
                'message' => 'berhasil ditambahkan'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => REST_Controller::HTTP_BAD_REQUEST,
                'message' => 'Gagal menambah btat'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put() {

        $vol = $this->put('vol');
        $data = [
            'vol' => $this->put('vol'),
            'nama' => $this->put('nama'),
            'alamat' => $this->put('alamat')
            
        ];

        if($this->btat->updateBtat($data, $vol) > 0) {
            $this->response([
                'status' => REST_Controller::HTTP_OK,
                'message' => 'berhasil diperbarui'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => REST_Controller::HTTP_BAD_REQUEST,
                'message' => 'Gagal memperbarui btat'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}