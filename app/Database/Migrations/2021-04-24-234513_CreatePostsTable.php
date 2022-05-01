<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 12,
				'auto_increment' => true,
				'unsigned' => true
			],
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
			],
			'slug' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
				// El slug  fungirá como una clave para realizar las busquedas de posts
				'unique' => true,
			],
			'body' => [
				'type' => 'TEXT',
			],
			'cover' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
			],
			'user_id' => [
				'type' => 'INT',
				'constraint' => 12,
				'unsigned' => true,
				// Si se elimina un usuario relacionado con este registro, se establece en nulo
				'null' => true,
			],
			'published_at' => [
				'type' => 'DATETIME',
			],
			'created_at' => [
				'type' => 'DATETIME'
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
		
		$this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
		$this->forge->createTable('posts');
	}

	public function down()
	{
		$this->forge->dropTable('posts');
	}
}
