<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Category;

class CategoryModel extends Model
{

    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $returnType = Category::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

}