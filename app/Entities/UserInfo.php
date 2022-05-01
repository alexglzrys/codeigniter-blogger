<?php
namespace App\Entities;

use CodeIgniter\Entity;

class UserInfo extends Entity
{

    protected $dates = ['created_at', 'updated_at'];

    // Getter que devuelve el nombre completo del usuario o autor
    public function getFullName()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

}