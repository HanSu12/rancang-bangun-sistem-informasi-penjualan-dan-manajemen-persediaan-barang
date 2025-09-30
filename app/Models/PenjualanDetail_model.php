<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanDetail_model extends Model
{
	protected $table            = 'penjualan_detail';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;

	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;

	protected $allowedFields    = [
		'id_penjualan',
		'id_barang',
		'harga_saat_transaksi',
		'jumlah',
		'sub_total',
	];

	protected $useTimestamps = false;
}
