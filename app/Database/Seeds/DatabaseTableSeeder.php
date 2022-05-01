<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabasetableSeeder extends Seeder
{
	public function run()
	{
		$this->call('CountryTableSeeder');
		$this->call('GroupTableSeeder');
		$this->call('CategoryTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('UserinfoTableSeeder');
		$this->call('PostTableSeeder');
		$this->call('CategoryPostTableSeeder');
	}
}
