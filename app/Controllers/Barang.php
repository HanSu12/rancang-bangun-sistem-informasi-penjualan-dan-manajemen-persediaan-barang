<?php

namespace App\Controllers;

use App\Models\Barang_model;
use App\Models\Kategori_model;
use CodeIgniter\HTTP\ResponseInterface;

class Barang extends BaseController
{
	public function index()
	{
		$barangModel = new Barang_model();
		$kategoriModel = new Kategori_model();

		// join kategori for display
		$barang = $barangModel
			->select('barang.*, kategori.nama_kategori')
			->join('kategori', 'kategori.id = barang.id_kategori')
			->orderBy('barang.created_at', 'DESC')
			->findAll();

		$kategori = $kategoriModel->orderBy('nama_kategori', 'ASC')->findAll();

		return view('barang/index', [
			'title' => 'Manajemen Barang',
			'barang' => $barang,
			'kategori' => $kategori,
		]);
	}

	public function create()
	{
		$rules = [
			'kode_barang' => 'required|min_length[2]|max_length[50]|is_unique[barang.kode_barang]',
			'nama_barang' => 'required|min_length[2]|max_length[150]',
			'id_kategori' => 'required|integer',
			'harga_beli' => 'required|decimal',
			'harga_jual' => 'required|decimal',
			'stok' => 'required|integer',
			'satuan' => 'required|max_length[20]',
		];

		if (! $this->validate($rules)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
				->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
		}

		$data = [
			'kode_barang' => $this->request->getPost('kode_barang'),
			'nama_barang' => $this->request->getPost('nama_barang'),
			'id_kategori' => (int) $this->request->getPost('id_kategori'),
			'harga_beli' => $this->request->getPost('harga_beli'),
			'harga_jual' => $this->request->getPost('harga_jual'),
			'stok' => (int) $this->request->getPost('stok'),
			'satuan' => $this->request->getPost('satuan'),
			'created_at' => date('Y-m-d H:i:s'),
		];

		$model = new Barang_model();
		$model->insert($data);
		$id = $model->getInsertID();

		// fetch with kategori name for UI
		$row = $model->select('barang.*, kategori.nama_kategori')->join('kategori', 'kategori.id = barang.id_kategori')->find($id);

		return $this->response->setJSON(['status' => 'ok', 'data' => $row]);
	}

	public function update($id)
	{
		$model = new Barang_model();
		$existing = $model->find($id);
		if (! $existing) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
				->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
		}

		$rules = [
			'kode_barang' => 'required|min_length[2]|max_length[50]|is_unique[barang.kode_barang,id,{id}]',
			'nama_barang' => 'required|min_length[2]|max_length[150]',
			'id_kategori' => 'required|integer',
			'harga_beli' => 'required|decimal',
			'harga_jual' => 'required|decimal',
			'stok' => 'required|integer',
			'satuan' => 'required|max_length[20]',
		];

		// bind id for is_unique exception
		$rules = str_replace('{id}', (string) $id, $rules);

		if (! $this->validate($rules)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
				->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
		}

		$data = [
			'kode_barang' => $this->request->getPost('kode_barang'),
			'nama_barang' => $this->request->getPost('nama_barang'),
			'id_kategori' => (int) $this->request->getPost('id_kategori'),
			'harga_beli' => $this->request->getPost('harga_beli'),
			'harga_jual' => $this->request->getPost('harga_jual'),
			'stok' => (int) $this->request->getPost('stok'),
			'satuan' => $this->request->getPost('satuan'),
		];

		$model->update($id, $data);

		$row = $model->select('barang.*, kategori.nama_kategori')->join('kategori', 'kategori.id = barang.id_kategori')->find($id);
		return $this->response->setJSON(['status' => 'ok', 'data' => $row]);
	}

	public function delete($id)
	{
		$model = new Barang_model();
		if (! $model->find($id)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
				->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
		}
		$model->delete($id);
		return $this->response->setJSON(['status' => 'ok']);
	}
}
