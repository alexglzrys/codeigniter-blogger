<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class LoginController extends BaseController
{

    public function login()
    {
        // Solo usuarios invitados pueden acceder a la vista de login
        if (!session('is_logged')) {
            return view('auth/login');
        }

        return redirect()->route('posts.index');
    }

    public function signin()
    {
        // Verificar si llegan los datos con la librería Kint
        // dd($this->request->getPost());

        // BaseController internamente ya tiene una instancia del servicio de validacion, por tanto podemos usarla de forma alternativa
        // Nos evitamos llamar al servicio y setRules
        if (!$this->validate([
            'email' => 'required|valid_email',
            'password' => 'required'
        ])) {
            // Si la validacion es incorrecta regresamos atras y seteamos los erroes bajo la clave errors
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // CI no tiene funciones preconstruidas para sanar información
        $email = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        // Localizar el email en base de datos
        $userModel = model('UserModel');

        if (!$user = $userModel->getUserBy('email', $email)) {
            // Si el modelo no encuentra info retorna nulo. Por tanto es necesario mostrar el error al usuario
            return redirect()->back()->withInput()->with('message', [
                'type' => 'danger',
                'body' => 'Usuario no localizado en base de datos'
            ]);
        }

        // Verificar que el password es correcto
        if (!password_verify($password, $user->password))
        {
            return redirect()->back()->withInput()->with('message', [
                'type' => 'danger',
                'body' => 'Credenciales de acceso incorrectas'
            ]);
        }

        // Establecer la session para el usuario actualmente logeado en el sistema
        // CI por defecto guarda las sessiones en archivos, pero podemos configurarlo para BD
        session()->set([
            'user_id' => $user->id,
            'username' => $user->username,
            'is_logged' => true
        ]);
        
        // Redireccionar el usuario a un apartado privado
        return redirect()->route('posts.index')->with('message', [
            'type' => 'success',
            'body' => 'Bienvenido de nuevo ' . $user->username,
        ]);

    }

    public function signout()
    {
        // Destruir la session actual y redireccionar al usuario
        // Si usamos destroy se destruye toda la session incluida la de CI para saber en que url estaba y las sessiones flash
        // Un enfoque mas práctico es setear is_logged a false, o remover la data que identifica a el usuario
        session()->remove(['user_id', 'username', 'is_logged']);
        return redirect()->route('auth.login')->with('message', [
            'type' => 'success',
            'body' => 'Su sesión se cerró exitosamente'
        ]);
    }

}