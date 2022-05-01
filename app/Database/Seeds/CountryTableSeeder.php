<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CountryTableSeeder extends Seeder
{
	public function run()
	{	
		$countries = [];

		for ($i=1; $i<=15; $i++) {
			$countries[] = [
				'name' => static::faker()->unique()->country,
				'created_at' => static::faker()->dateTime()->format('Y-m-d H:i:s'),
			];
		}

		$this->db->table('countries')->insertBatch($countries);
	}
}
