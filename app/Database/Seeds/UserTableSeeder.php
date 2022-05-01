<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserTableSeeder extends Seeder
{
	public function run()
	{
		$users = [];

		for ($i=1; $i<=5; $i++) { 
			$users[] = [
				'username' => static::faker()->userName,
				'email' => static::faker()->unique()->email,
				'password' => static::faker()->password,
				'group_id' => static::faker()->numberBetween(1, 2),
				'created_at' => static::faker()->dateTime()->format('Y-m-d H:i:s')
			];
		}

		$this->db->table('users')->insertBatch($users);
	}
}
