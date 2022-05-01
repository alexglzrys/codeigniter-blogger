<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoryPostTableSeeder extends Seeder
{
	public function run()
	{
		$pivot = [];

		// Cada Post
		for ($i=1; $i <= 20  ; $i++) { 
			// Asociar de una a 4 categorías como máximo
			for ($j=1; $j <= static::faker()->numberBetween(1,4); $j++) { 
				$pivot[] = [
					'category_id' => static::faker()->numberBetween(1, 10),
					'post_id' => $i
				];
			}
			
		}

		$this->db->table('category_post')->insertBatch($pivot);
	}
}
