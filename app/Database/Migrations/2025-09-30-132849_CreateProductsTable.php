<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'sku' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 170,
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => true,
            ],
            'unit' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'pcs',
            ],
            'cost_price' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => '0.00',
            ],
            'sell_price' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => '0.00',
            ],
            'stock' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'min_stock' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('sku');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('name');
        $this->forge->addKey('category_id');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products', true);
    }
}
