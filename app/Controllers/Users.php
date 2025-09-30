<?php

namespace App\Controllers;

use App\Models\User_model;
use CodeIgniter\HTTP\ResponseInterface;

class Users extends BaseController
{
	public function index()
	{
		$model = new User_model();
		$items = $model->orderBy('id', 'DESC')->findAll();
		return view('users/index', [
			'title' => 'Manajemen Pengguna',
			'items' => $items,
		]);
	}

	public function create()
	{
		$rules = [
			'nama_lengkap' => 'required|min_length[2]|max_length[100]',
			'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
			'password' => 'required|min_length[6]',
			'level' => 'required|in_list[admin,kasir]',
		];
		if (! $this->validate($rules)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON(['status'=>'error','errors'=>$this->validator->getErrors()]);
		}
		$model = new User_model();
		$id = $model->insert([
			'nama_lengkap' => $this->request->getPost('nama_lengkap'),
			'username' => $this->request->getPost('username'),
			'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
			'level' => $this->request->getPost('level'),
			'created_at' => date('Y-m-d H:i:s'),
		]);
		$row = $model->find($id);
		unset($row['password']);
		return $this->response->setJSON(['status'=>'ok','data'=>$row]);
	}

	public function update($id)
	{
		$model = new User_model();
		$exists = $model->find($id);
		if (! $exists) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['status'=>'error','message'=>'Data tidak ditemukan']);
		}

		$usernameRule = 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]';
		$usernameRule = str_replace('{id}', (string)$id, $usernameRule);
		$rules = [
			'nama_lengkap' => 'required|min_length[2]|max_length[100]',
			'username' => $usernameRule,
			'level' => 'required|in_list[admin,kasir]',
			'password' => 'permit_empty|min_length[6]',
		];
		if (! $this->validate($rules)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)->setJSON(['status'=>'error','errors'=>$this->validator->getErrors()]);
		}
		$data = [
			'nama_lengkap' => $this->request->getPost('nama_lengkap'),
			'username' => $this->request->getPost('username'),
			'level' => $this->request->getPost('level'),
		];
		if ($pwd = $this->request->getPost('password')) {
			$data['password'] = password_hash($pwd, PASSWORD_DEFAULT);
		}
		$model->update($id, $data);
		$row = $model->find($id);
		unset($row['password']);
		return $this->response->setJSON(['status'=>'ok','data'=>$row]);
	}

	public function delete($id)
	{
		$model = new User_model();
		if (! $model->find($id)) {
			return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)->setJSON(['status'=>'error','message'=>'Data tidak ditemukan']);
		}
		$model->delete($id);
		return $this->response->setJSON(['status'=>'ok']);
	}
}
