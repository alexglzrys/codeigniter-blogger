<?php
namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{

    protected $table = 'groups';
    protected $primaryKey = 'id';

    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

}