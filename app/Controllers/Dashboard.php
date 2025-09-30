<?php

namespace App\Controllers;

use App\Models\Barang_model;
use App\Models\Penjualan_model;

class Dashboard extends BaseController
{
	public function index()
	{
		$barang = new Barang_model();
		$penjualan = new Penjualan_model();

		$today = date('Y-m-d');

		$totalProduk = $barang->countAllResults();
		$totalPenjualanHariIni = $penjualan
			->where('DATE(created_at)', $today)
			->selectSum('total_harga', 'total')
			->get()->getRowArray()['total'] ?? 0;
		$transaksiHariIni = $penjualan->where('DATE(created_at)', $today)->countAllResults();

		$data = [
			'title' => 'Dashboard',
			'summary' => [
				'totalProduk' => (int) $totalProduk,
				'transaksiHariIni' => (int) $transaksiHariIni,
				'penjualanHariIni' => (float) $totalPenjualanHariIni,
				'placeholderLainnya' => 0,
			],
		];

		return view('dashboard', $data);
	}
}
