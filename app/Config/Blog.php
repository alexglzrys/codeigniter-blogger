<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;


/**
 * Los archivos de configuración permiten almacenar datos por defecto para
 * poder realizar algun tipo de operación en el sistema.
 * 
 * La mayoría de los servicios de CI tienen asociado un archivo de configuración:
 * Email, Database, etc,
 * 
 * Esto también se puede hacer mediante el archivo .env
 * sin que exista la necesidad de generar una clase dentro del directorio Config
 */

class Blog extends BaseConfig
{

    // Todos los usuarios registrados se asignaran al grupo Operador por defecto.
    public $defaultGroupUsers = 'Administrador';
    public $regPerPage = 2;

}