<?php

namespace App\Models;

use CodeIgniter\Model;

class Kategori_model extends Model
{
	protected $table            = 'kategori';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;

	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;

	protected $allowedFields    = [
		'nama_kategori',
	];

	protected $useTimestamps = false;
}
