<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersInfoTable extends Migration
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
			'first_name' => [
				'type' => 'VARCHAR',
				'constraint' => 30,
			],
			'last_name' => [
				'type' => 'VARCHAR',
				'constraint' => 80,
			],
			'country_id' => [
				'type' => 'INT',
				'constraint' => 12,
				'unsigned' => true,
				'null' => true,
			],		
			'user_id' => [
				'type' => 'INT',
				'constraint' => 12,
				'unsigned' => true,
			],
			'created_at' => [
				'type' => 'DATETIME',
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true,
			]
		]);
		
		// Definición de llave primaria
		$this->forge->addPrimaryKey('id');
		// Definición de llaves foraneas (campo, tablaPrimaria, campoTablaPrimaria, UPDATE, DELETE)
		$this->forge->addForeignKey('country_id', 'countries', 'id', 'CASCADE', 'SET NULL');
		$this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
		// Crear tabla
		$this->forge->createTable('users_info');
	}

	public function down()
	{
		// Eliminar tabla
		$this->forge->dropTable('users_info');
	}
}
