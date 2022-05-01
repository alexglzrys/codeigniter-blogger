<?php
namespace App\Entities;

use CodeIgniter\Entity;

/**
 * Las entidades son una capa adicional (opcional) al modelo de datos 
 * que surgen con la intensión de agrupar acciones complejas, filtros, o decoración de información
 * En ella se declaran funciones de conveniencia para:
 * Obtener el nombre completo de un usuario, información proveniente de varias relaciones (los grupos a los que pertenece este usuario)
 * Hasher una contraseña, retornar fechas preformateadas, info predefinida en caso de no existir valores, etc.
 */
class User extends Entity 
{

    // Campos en la base de datos que se desean convertir en objetos de tipo Time (Humanizar, Establecer uso horario, Convertir a string)
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Getters y Setters
    // Permiten realizar acciones antes de guardar o recuperar información en el modelo
    // Pueden generar nuevas propiedades para la entidad con datos a partir de calculos complejos
    public function setPassword(string $password)
    {
        // La data enviada a la entidad se almacena en la propiedad $attributes
        $this->attributes['password'] = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getFullName()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function generateUsername()
    {
        $this->attributes['username'] = strtolower('@' . explode(' ', $this->attributes['first_name'])[0] . explode(' ', $this->attributes['last_name'])[0] . '_' . rand());
    }

    // Obtener información completa del grupo correspondiente a este usuario
    // Recordar que this hace referencia a este usuario
    public function getRole()
    {
        $groupModel = model('GroupModel');
        // Retornamos una instancia de grupo de este usuario
        return $groupModel->where('id', $this->group_id)->first();
    }

}