<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
	public function run()
	{
		$categories = [];

		for ($x = 1; $x <= 10; $x++) {
			$categories[] = [
				'name' => static::faker()->unique()->word,
				'created_at' => static::faker()->dateTime()->format('Y-m-d H:i:s')
			];
		}

		$this->db->table('categories')->insertBatch($categories);
	}
}
