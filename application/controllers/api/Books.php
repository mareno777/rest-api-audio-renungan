<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Books extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Books_model', 'books');

        $this->methods['index_get']['limit'] = 60;
    }

    public function index_get() {

        $bookId = $this->get('bookId');
        $page = $this->get('page');
        $jumlahData = $this->books->jumlahData();


        if ($bookId === null) {

        if($page === null) {
            $page = 1;
            $books = $this->books->getBookWithLimit($page * 10);
        } else {
            $books = $this->books->getBookWithLimit($page * 10);
        }
            
        } else {
            $books = $this->books->getBook($bookId);
        }
        
        if($books) {
            $this->response([
                'status' => REST_Controller::HTTP_OK,
                'data' => $books,
                'current_page' => (int) $page,
                'total_pages' => ceil($jumlahData /10)
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => REST_Controller::HTTP_NOT_FOUND,
                'message' => 'Buku tidak ditemukan',
                'data' => []
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete() {

        $bookId = $this->delete('bookId');

        if($bookId === null) {
            $this->response([
                'status' => REST_Controller::HTTP_BAD_REQUEST,
                'message' => 'Provde an bookId!',
                'data' => $bookId
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->books->deleteBook($bookId) > 0) {
                $this->response([
                    'status' => REST_Controller::HTTP_OK,
                    'message' => 'Buku Dihapus'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => REST_Controller::HTTP_BAD_REQUEST,
                    'message' => 'bookId tidak ditemukan!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            
        }
    }

    public function index_post() {
        $data = [
            'book_id' => $this->post('book_id'),
            'title' => $this->post('title'),
            'image_url' => $this->post('image_url'),
            'book_url' => $this->post('book_url')
            
        ];

        if($this->books->createBook($data) > 0) {
            $this->response([
                'status' => REST_Controller::HTTP_CREATED,
                'message' => 'berhasil ditambahkan'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => REST_Controller::HTTP_BAD_REQUEST,
                'message' => 'Gagal menambah buku'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put() {

        $bookId = $this->put('book_id');
        $data = [
            'book_id' => $this->post('book_id'),
            'title' => $this->post('title'),
            'image_url' => $this->post('image_url'),
            'book_url' => $this->post('book_url')
            
        ];

        if($this->books->updateBook($data, $bookId) > 0) {
            $this->response([
                'status' => REST_Controller::HTTP_OK,
                'message' => 'berhasil diperbarui'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => REST_Controller::HTTP_BAD_REQUEST,
                'message' => 'Gagal memperbarui buku'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}