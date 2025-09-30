<?php

namespace App\Controllers;

use App\Models\User_model;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
	public function index()
	{
		// If already logged-in redirect to dashboard
		if (session()->get('is_logged_in')) {
			return redirect()->to('/');
		}
		return view('auth/login');
	}

	public function login_process()
	{
		$validationRules = [
			'username' => 'required',
			'password' => 'required',
		];

		if (! $this->validate($validationRules)) {
			return redirect()->back()->withInput()->with('error', 'Masukkan username dan password.');
		}

		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');

		$userModel = new User_model();
		$user = $userModel->where('username', $username)->first();

		if (! $user) {
			return redirect()->back()->withInput()->with('error', 'Username tidak ditemukan.');
		}

		if (! password_verify($password, $user['password'])) {
			return redirect()->back()->withInput()->with('error', 'Password salah.');
		}

		session()->set([
			'user_id' => $user['id'],
			'username' => $user['username'],
			'nama_lengkap' => $user['nama_lengkap'],
			'level' => $user['level'],
			'is_logged_in' => true,
		]);

		return redirect()->to('/');
	}

	public function logout(): RedirectResponse
	{
		session()->destroy();
		return redirect()->to('/login');
	}
}
