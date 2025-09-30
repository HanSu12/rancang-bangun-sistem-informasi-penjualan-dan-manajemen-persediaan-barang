<?php

namespace App\Controllers;

use App\Models\Kategori_model;
use CodeIgniter\HTTP\ResponseInterface;

class Kategori extends BaseController
{
	public function index()
	{
		$model = new Kategori_model();
		$items = $model->orderBy('nama_kategori', 'ASC')->findAll();
		return view('kategori/index', [
			'title' => 'Manajemen Kategori',
			'items' => $items,
		]);
	}

	public function create()
	{
		$rules = [ 'nama_kategori' => 'required|min_length[2]|max_length[100]|is_unique[kategori.nama_kategori]' ];
		if (! $this->validate($rules)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
				->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
		}
		$model = new Kategori_model();
		$id = $model->insert(['nama_kategori' => $this->request->getPost('nama_kategori')]);
		$row = $model->find($id);
		return $this->response->setJSON(['status' => 'ok', 'data' => $row]);
	}

	public function update($id)
	{
		$model = new Kategori_model();
		if (! $model->find($id)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
		}
		$rule = 'required|min_length[2]|max_length[100]|is_unique[kategori.nama_kategori,id,{id}]';
		$rule = str_replace('{id}', (string)$id, $rule);
		if (! $this->validate(['nama_kategori' => $rule])) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
		}
		$model->update($id, ['nama_kategori' => $this->request->getPost('nama_kategori')]);
		return $this->response->setJSON(['status' => 'ok', 'data' => $model->find($id)]);
	}

	public function delete($id)
	{
		$model = new Kategori_model();
		if (! $model->find($id)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
		}
		$model->delete($id);
		return $this->response->setJSON(['status' => 'ok']);
	}
}
