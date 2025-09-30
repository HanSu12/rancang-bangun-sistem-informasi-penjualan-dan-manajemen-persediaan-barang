<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);

        // Ensure roles exist
        $role = $this->db->table('roles')->where('name', 'admin')->get()->getRowArray();
        if (!$role) {
            $this->call('RolesSeeder');
            $role = $this->db->table('roles')->where('name', 'admin')->get()->getRowArray();
        }

        // Create admin user if not exists
        $user = $this->db->table('users')->where('username', 'admin')->get()->getRowArray();
        if (!$user) {
            $this->db->table('users')->insert([
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password_hash' => $passwordHash,
                'full_name' => 'Administrator',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $userId = $this->db->insertID();
        } else {
            $userId = $user['id'];
        }

        // Assign admin role
        if (!empty($role) && !empty($userId)) {
            $exists = $this->db->table('user_roles')->where('user_id', $userId)->where('role_id', $role['id'])->get()->getRowArray();
            if (!$exists) {
                $this->db->table('user_roles')->insert([
                    'user_id' => $userId,
                    'role_id' => $role['id'],
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
