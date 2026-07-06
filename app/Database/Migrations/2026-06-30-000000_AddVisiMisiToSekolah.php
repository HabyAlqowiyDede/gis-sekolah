<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVisiMisiToSekolah extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_sekolah', [
            'visi' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'misi' => [
                'type'       => 'TEXT',
                'null'       => true,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_sekolah', ['visi', 'misi']);
    }
}
