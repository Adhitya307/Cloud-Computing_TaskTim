<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectMembersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'project_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'user_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'role'         => ['type' => 'ENUM', 'constraint' => ['ketua', 'anggota']],
            'invited_at'   => ['type' => 'DATETIME', 'null' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['active', 'pending'], 'default' => 'active'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('project_members');
    }

    public function down()
    {
        $this->forge->dropTable('project_members');
    }
}
