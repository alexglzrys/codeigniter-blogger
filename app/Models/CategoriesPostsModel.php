<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesPostsModel extends Model
{

	protected $DBGroup              = 'default';
	protected $table                = 'category_post';
	protected $returnType           = 'object';
	protected $protectFields        = true;
	protected $allowedFields        = ['category_id', 'post_id'];

}
