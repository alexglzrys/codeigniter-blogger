<?php 
namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Entities\UserInfo;

class RegisterController extends BaseController
{

    protected $configBlog;

    public function __construct()
    {
        // Cargar el archivo de configuración almacenado en el archivo Blog
        $this->configBlog = config('Blog');
    }

    public function register()
    {
        // Cargar el helper que incluye funciones de utilidad para formularios (set_select)
        helper('form');
        // Cargar los paises registrados en la base de datos
        $countriesModel = model('CountryModel');
        $countries = $countriesModel->orderBy('name')->findAll();

        return view('auth/register', compact('countries'));
    }

    public function store()
    {
        // Invocar el servicio de validaciones
        $validation = service('validation');
        // Establecer reglas de validación para las entradas
        $validation->setRules([
            'first_name' => 'required|alpha_space',
            'last_name' => 'required|alpha_space',
            'email' => 'required|valid_email|is_unique[users.email]',
            'country_id' => 'required|is_not_unique[countries.id]', // pueede repetirse, pero el valor debe estar presente en algunos de los ids de dicha tabla
            'password' => 'required|matches[confirm_password]', // Debe coincidir con el campo confirm_password
        ]);
        // Verificar que las reglas se han pasado con exito
        if (!$validation->withRequest($this->request)->run()) {
            // dd($validation->getErrors());

            // Redireccionar al formulario enviando las entradas y errores de validaciones
            // with generar variables de session tipo flash para pasarselas a vista
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Vincular data con la entidad de usuario
        // Internamente hashea el password y tiene metodos de utilidad para generar usernames

        // Las Entidades solo toman los valores de las propiedades que coinciden con las keys del arreglo
        $user = new User($this->request->getPost());
        $user->generateUsername();
        
        // Llamar al modelo
        $userModel = model('UserModel');
        // Asociar a un grupo el usuario (se le asignara por defecto con base en el archivo de config. de Blog)
        // En caso de asignar otro grupo, solo se le pasa el nombre como un string.
        $userModel->withGroup($this->configBlog->defaultGroupUsers);

        // Asociar información de este usuario
        $userInfo = new UserInfo($this->request->getPost());
        $userModel->addUserInfo($userInfo);

        // Insertar datos en el modelo
        // Internamente asocia el grupo de usuario y genera el registro de los datos asociados a la tabla user_info
        $userModel->save($user);

        //d($user);

        // Redireccionar a la vista de login con un mensaje flash (el mensaje es un array para personalizar el componente que lo mostrará en pantalla "exito/error")
        return redirect()->route('auth.login')->with('message', [
            'type' => 'success',
            'body' => 'Usuario registrado con éxito'
        ]);
    }

}