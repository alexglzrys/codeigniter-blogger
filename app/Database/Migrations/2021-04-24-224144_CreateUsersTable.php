<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => 30,
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 80,
				'unique' => true
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 60,
			],
			'group_id' => [
				'type' => 'INT',
				'constraint' => 12,
				'unsigned' => true,
				'null' => true,
			],
			'created_at' => [
				'type' => 'DATETIME',
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true
			],
			'deleted_at' => [
				'type' => 'DATETIME',
				'null' => true
			]
		]);
		
		$this->forge->addPrimaryKey('id');
		$this->forge->addForeignKey('group_id', 'groups', 'id', 'CASCADE', 'SET NULL');
		$this->forge->createTable('users');
	}

	public function down()
	{
		//
		$this->forge->dropTable('users');
	}
}
