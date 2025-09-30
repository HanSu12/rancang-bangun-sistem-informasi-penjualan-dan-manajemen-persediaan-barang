<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Bahan Baku',
                'slug' => 'bahan-baku',
                'description' => 'Kategori bahan baku produksi',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Produk Jadi',
                'slug' => 'produk-jadi',
                'description' => 'Kategori produk siap jual',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('categories')->ignore(true)->insertBatch($data);
    }
}
