<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Devotional extends REST_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Devotional_model', 'devotional');

		//$this->methods['index_get']['limit'] = 60;
	}

	public function index_get()
	{

		$mediaId = $this->get('mediaId');
		$page = $this->get('page');
		$jumlahData = $this->devotional->jumlahData();


		if ($mediaId === null) {

			if ($page === null) {
				$page = 1;
				$devotional = $this->devotional->getDevotional();
			} else {
				$devotional = $this->devotional->getDevotionalWithLimit($page * 10);
			}


		} else {
			$devotional = $this->devotional->getDevotional($mediaId);
		}

		if ($devotional) {
			$this->response([
				'status' => REST_Controller::HTTP_OK,
				'music' => $devotional,
				'current_page' => (int)$page,
				'total_pages' => ceil($jumlahData / 10)
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => REST_Controller::HTTP_NOT_FOUND,
				'message' => 'Devotional tidak ditemukan',
				'data' => []
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_delete()
	{

		$mediaId = $this->delete('mediaId');

		if ($mediaId === null) {
			$this->response([
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Provde an mediaId!',
				'data' => $mediaId
			], REST_Controller::HTTP_BAD_REQUEST);
		} else {
			if ($this->devotional->deleteDevotional($mediaId) > 0) {
				$this->response([
					'status' => REST_Controller::HTTP_OK,
					'message' => 'Devotional Dihapus'
				], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => REST_Controller::HTTP_BAD_REQUEST,
					'message' => 'mediaId tidak ditemukan!'
				], REST_Controller::HTTP_BAD_REQUEST);
			}

		}
	}

	public function index_post()
	{
		$data = [
			'id' => $this->post('mediaId'),
			'title' => $this->post('mediaId'),
			'album' => $this->post('album'),
			'artist' => $this->post('artist'),
			'source' => $this->post('source'),
			'image' => $this->post('image')

		];

		if ($this->devotional->createDevotional($data) > 0) {
			$this->response([
				'status' => REST_Controller::HTTP_CREATED,
				'message' => 'berhasil ditambahkan'
			], REST_Controller::HTTP_CREATED);
		} else {
			$this->response([
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Gagal menambah devotional'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_put()
	{

		$mediaId = $this->put('mediaId');
		$data = [
			'mediaId' => $this->put('mediaId'),
			'nama' => $this->put('nama'),
			'alamat' => $this->put('alamat')

		];

		if ($this->devotional->updateDevotional($data, $mediaId) > 0) {
			$this->response([
				'status' => REST_Controller::HTTP_OK,
				'message' => 'berhasil diperbarui'
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => REST_Controller::HTTP_BAD_REQUEST,
				'message' => 'Gagal memperbarui devotional'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}
