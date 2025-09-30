<?php

namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model
{
	protected $table            = 'users';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;

	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;

	protected $allowedFields    = [
		'nama_lengkap',
		'username',
		'password',
		'level',
		'created_at',
		'updated_at',
	];

	protected $useTimestamps = false;
}
