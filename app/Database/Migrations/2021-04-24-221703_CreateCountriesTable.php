<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCountriesTable extends Migration
{
	public function up()
	{
		// Lanzar la migración
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 12,
				'auto_increment' => true,
				'unsigned' => true,
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => 80,
			],
			'created_at' => [
				'type' => 'DATETIME',
			],
			'updated_ad' => [
				'type' => 'DATETIME',
				'null' => true
			]
		]);

		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('countries');
	}

	public function down()
	{
		// Eliminar esta migración
		$this->forge->dropTable('countries');
	}
}
