<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupTableSeeder extends Seeder
{
	public function run()
	{
		$groups = [
			[
				'name' => 'Administrador',
				// Instalar faker mediante composer, hace que CI coloque una instancia 
				// de este en la clase principal Seeder y sea accesible a todos los sembradores
				// mediante el metodo estatico faker()
				'created_at' => static::faker()->dateTime()->format('Y-m-d H:i:s')
			],
			[
				'name' => 'Operador',
				'created_at' => static::faker()->dateTime()->format('Y-m-d H:i:s')
			],
		];

		$this->db->table('groups')->insertBatch($groups);
	}
}
