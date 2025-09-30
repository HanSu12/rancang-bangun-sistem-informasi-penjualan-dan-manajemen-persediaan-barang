<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'parent_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
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
        $this->forge->addUniqueKey('name');
        $this->forge->addUniqueKey('slug');
        $this->forge->addForeignKey('parent_id', 'categories', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories', true);
    }
}
