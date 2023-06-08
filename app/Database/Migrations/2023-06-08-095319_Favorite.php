<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Favorite extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel favorite
        $this->forge->addField([
            'favorite_id'             => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id'       => [
                'type'           => 'INT',
                'constraint'     => '10'
            ],
            'animal_id'       => [
                'type'           => 'INT',
                'constraint'     => '10'
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);

        // Membuat primary key
        $this->forge->addKey('favorite_id', TRUE);

        // Membuat tabel favorite
        $this->forge->createTable('favorites', TRUE);
    }

    public function down()
    {
        //
    }
}
