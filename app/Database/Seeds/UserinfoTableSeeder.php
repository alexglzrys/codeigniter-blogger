<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserinfoTableSeeder extends Seeder
{
	public function run()
	{
		$info = [];

		for ($i=1; $i <= 5 ; $i++) { 
			$info[] = [
				'first_name' => static::faker()->name ,
				'last_name' => static::faker()->lastName ,
				'country_id' => static::faker()->numberBetween(1, 15) ,
				'user_id' => static::faker()->numberBetween(1, 5) ,
				'created_at' => static::faker()->dateTime()->format('Y-m-d H:i:s')
			];
		}

		$this->db->table('users_info')->insertBatch($info);
	}
}
