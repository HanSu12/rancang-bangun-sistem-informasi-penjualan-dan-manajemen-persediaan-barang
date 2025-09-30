<?php

namespace App\Models;

use CodeIgniter\Model;

class StokMasuk_model extends Model
{
	protected $table            = 'stok_masuk';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;

	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;

	protected $allowedFields    = [
		'id_barang',
		'id_supplier',
		'jumlah',
		'tanggal_masuk',
		'keterangan',
	];

	protected $useTimestamps = false;
}
