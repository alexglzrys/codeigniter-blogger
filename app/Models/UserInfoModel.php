<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\UserInfo;

class UserInfoModel extends Model
{

    protected $table = ['users_info'];
    protected $primaryKey = 'id';

    protected $returnType = UserInfo::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['first_name', 'last_name', 'country_id', 'user_id'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

}