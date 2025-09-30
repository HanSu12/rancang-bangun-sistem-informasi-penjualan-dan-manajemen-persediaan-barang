<?php

namespace App\Models;

use CodeIgniter\Model;

class Penjualan_model extends Model
{
	protected $table            = 'penjualan';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;

	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;

	protected $allowedFields    = [
		'no_faktur',
		'total_harga',
		'jumlah_uang',
		'kembalian',
		'id_user',
		'created_at',
	];

	protected $useTimestamps = false;
}
