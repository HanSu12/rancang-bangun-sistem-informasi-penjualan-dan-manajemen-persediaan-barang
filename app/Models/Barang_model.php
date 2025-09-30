<?php

namespace App\Models;

use CodeIgniter\Model;

class Barang_model extends Model
{
	protected $table            = 'barang';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;

	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;

	protected $allowedFields    = [
		'kode_barang',
		'nama_barang',
		'id_kategori',
		'harga_beli',
		'harga_jual',
		'stok',
		'satuan',
		'created_at',
	];

	protected $useTimestamps = false;
}
