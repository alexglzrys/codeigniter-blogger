<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;
use App\Entities\UserInfo;

class UserModel extends Model
{

    protected $table = 'users';
    protected $primaryKey = 'id';

    // Vincular la entidad con este modelo
    protected $returnType = User::class;
    protected $useSoftDeletes = true;

    // Campos que se permiten asignar en el modelo para guardar en la base de datos
    protected $allowedFields = ['username', 'email', 'password'];

    // Agregar datos de auditoría automáticamente al registrar, actualizar y eliminar
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Almacenar el ID del grupo asociado con este usuario
    protected $assignGroup;
    // Almacenar información relacionada de este usuario
    protected $userInfo;
    // Indicar que funciones (callback) se debe llamar antes de registrar un usuario en la base de datos
    protected $beforeInsert = ['addGroup'];
    // Función que se llama despues de insertar el registro (apta para guardar información relacionada)
    protected $afterInsert = ['storeInfoUser'];

    // Metodo de utilidad para recuperar el ID de un nombre de grupo de usuario pasado como parametro
    // Esto se invocará pubicamente, y el resultado se almacenara en una propiedad del modelo
    public function withGroup(string $group)
    {
        $row = $this->db->table('groups')->where('name', $group)->get()->getRow();

        if ($row) {
            $this->assignGroup = $row->id;
        } 
    }

    // Metodo de utilidad para setear información relacionada del usuario por registrar
    public function addUserInfo(UserInfo $ui)
    {
        $this->userInfo = $ui;
    }

    // Este metodo se invoca antes de insertar un usuario, recibe como parametro un arreglo con
    // los pares/valor de los datos que se estan insertando, pero si se pasa un objeto o una instancia
    // de una clase de tipo entidad, ese objeto se convierte primero en un array, agrupando todos sus datos en la key data
    protected function addGroup($data) 
    {
        $data['data']['group_id'] = $this->assignGroup;
        return $data;
    }

    // Método que se invoca después de insertar un registro de tipo usuario
    // Guardar información relacionada de este usuario en tabla secundaria
    // El parametro que recibe es un arreglo con el id del registro insertado, data a registrar, y el resultado de la operación de registro
    protected function storeInfoUser($data)
    {
        // Guardar la referencia del id de usuario registrado
        $this->userInfo->user_id = $data['id'];
        $userInfoModel = model('UserInfoModel');
        // Insertar la información relacionada de este usuario
        $userInfoModel->insert($this->userInfo);
    }

    /**
     * FUNCIONES PERSONALIZADAS
     * 
     * Declaración de funciones de utilidad para el modelo User
     */

    // Buscar un usuario especificando el campo y valor
    public function getUserBy(string $column, string $value) 
    {
        // this hace referencia a este modelo, por tanto, hace referencia a la tabla users
        return $this->where($column, $value)->first();
    }

}