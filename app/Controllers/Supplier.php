<?php

namespace App\Controllers;

use App\Models\Supplier_model;
use CodeIgniter\HTTP\ResponseInterface;

class Supplier extends BaseController
{
	public function index()
	{
		$model = new Supplier_model();
		$items = $model->orderBy('nama_supplier', 'ASC')->findAll();
		return view('supplier/index', [
			'title' => 'Manajemen Supplier',
			'items' => $items,
		]);
	}

	public function create()
	{
		$rules = [
			'nama_supplier' => 'required|min_length[2]|max_length[120]',
			'telepon' => 'permit_empty|max_length[30]',
			'alamat' => 'permit_empty',
		];
		if (! $this->validate($rules)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON(['status'=>'error','errors'=>$this->validator->getErrors()]);
		}
		$model = new Supplier_model();
		$id = $model->insert([
			'nama_supplier'=>$this->request->getPost('nama_supplier'),
			'telepon'=>$this->request->getPost('telepon'),
			'alamat'=>$this->request->getPost('alamat'),
		]);
		return $this->response->setJSON(['status'=>'ok','data'=>$model->find($id)]);
	}

	public function update($id)
	{
		$model = new Supplier_model();
		if (! $model->find($id)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['status'=>'error','message'=>'Data tidak ditemukan']);
		}
		$rules = [
			'nama_supplier' => 'required|min_length[2]|max_length[120]',
			'telepon' => 'permit_empty|max_length[30]',
			'alamat' => 'permit_empty',
		];
		if (! $this->validate($rules)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON(['status'=>'error','errors'=>$this->validator->getErrors()]);
		}
		$model->update($id, [
			'nama_supplier'=>$this->request->getPost('nama_supplier'),
			'telepon'=>$this->request->getPost('telepon'),
			'alamat'=>$this->request->getPost('alamat'),
		]);
		return $this->response->setJSON(['status'=>'ok','data'=>$model->find($id)]);
	}

	public function delete($id)
	{
		$model = new Supplier_model();
		if (! $model->find($id)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['status'=>'error','message'=>'Data tidak ditemukan']);
		}
		$model->delete($id);
		return $this->response->setJSON(['status'=>'ok']);
	}
}
