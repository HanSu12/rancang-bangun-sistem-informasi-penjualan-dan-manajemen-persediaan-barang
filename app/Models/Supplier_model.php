<?php

namespace App\Models;

use CodeIgniter\Model;

class Supplier_model extends Model
{
	protected $table            = 'supplier';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;

	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;

	protected $allowedFields    = [
		'nama_supplier',
		'telepon',
		'alamat',
	];

	protected $useTimestamps = false;
}
