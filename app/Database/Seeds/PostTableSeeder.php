<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PostTableSeeder extends Seeder
{
	public function run()
	{
		$posts = [];

		for ($i=1; $i<=20; $i++) { 
			$posts[] = [
				'title' => static::faker()->sentence,
				'slug' => static::faker()->slug,
				'body' => static::faker()->text(700),
				'cover' => static::faker()->imageUrl(),
				'user_id' => static::faker()->numberBetween(1, 5),
				'published_at' => static::faker()->dateTime()->format('Y-m-d H:i:s'),
				'created_at' => static::faker()->dateTime()->format('Y-m-d H:i:s'),
			];
		}

		$this->db->table('posts')->insertBatch($posts);
	}
}
