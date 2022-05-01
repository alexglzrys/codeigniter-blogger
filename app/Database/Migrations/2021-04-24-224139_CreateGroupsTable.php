<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupsTable extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 12,
				'auto_increment' => true,
				'unsigned' => true
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => 20,
				'unique' => true,
			],
			'created_at' => [
				'type' => 'DATETIME'
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true
			]
		]);

		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('groups');
	}

	public function down()
	{
		//
		$this->forge->dropTable('groups');
	}
}
