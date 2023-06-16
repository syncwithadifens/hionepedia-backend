<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Animal extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel animal
        $this->forge->addField([
            'animal_id'             => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'slug'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '255'
            ],
            'description' => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'thumbnail'      => [
                'type'           => 'TEXT',
                'null'        => true,
            ],
            'sound'      => [
                'type'           => 'TEXT',
                'null'        => true,
            ],
            'model'      => [
                'type'           => 'TEXT',
                'null'        => true,
            ],
            'offline'      => [
                'type'           => 'VARCHAR',
                'constraint'        => '3',
                'default' => 'no'
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);

        // Membuat primary key
        $this->forge->addKey('animal_id', TRUE);

        // Membuat tabel hewan
        $this->forge->createTable('animals', TRUE);
    }


    public function down()
    {
        //
    }
}
