<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel user
        $this->forge->addField([
            'user_id'             => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'username'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'pin'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '6'
            ],
            'age'       => [
                'type'           => 'INT',
                'constraint'     => '3',
                'null'           => true,
            ],
            'hobby' => [
                'type'           => 'TEXT',
                'constraint'     => '255',
                'null'           => true,
            ],
            'role'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '5'
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);

        // Membuat primary key
        $this->forge->addKey('user_id', TRUE);

        // Membuat tabel user
        $this->forge->createTable('users', TRUE);
    }

    public function down()
    {
        //
    }
}
