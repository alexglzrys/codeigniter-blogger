<?php
namespace App\Entities;

use Hashids\Hashids;
use CodeIgniter\Entity;

class Category extends Entity
{

    // Permitir que los campos de auditoría regresen objetos de tiempo
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Función que retorna un enlace para editar este registro
    // No es necesario pero se puede hacer
    public function getEditLink()
    {
        // Recordar que la entidad retorna el objeto con el cual esta asociado, en este caso una categoría
        
        return base_url(route_to('categories.edit', $this->id));
    }

    // Función que retorna un enlace con el id codificado para eliminar este registro
    public function getDeleteLink()
    {
        // Una buena práctica es evitar exponer los ids de los registros a nuestros usuarios por URL
        // Esta librería codifica/decodifica valores numéricos o hexadecimales (mongoDB) 
        $hash = new Hashids();
        return base_url(route_to('categories.destroy', $hash->encode($this->id)));
    }

}