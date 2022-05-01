<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Los filtros en CI funcionan como los middlewares en Laravel
 * Toman la solicitud, la pueden transformar, y pasarle esa solicitud decorada a la siguiente función
 * 
 * En este caso no existe un next, por lo que si se retorna null, significa que el flujo debe continuar
 * si se retorna algo, se para la ejecución.
 * 
 * Se deben registrar en Config/Filters
 * e inyectarlos en las rutas
 */


class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Los filtros aceptan argumentos, los cuales se declaran separados por comas. Por lo que se espera que lleguen a manera de arreglo o null
        // dd($arguments);

        // Verificar si el usuario esta logeado
        if (!session()->is_logged) {
            // Cortamos el flujo de la petición, pues el usuario no esta logeado
            return redirect()->route('auth.login')->with('message', [
                'type' => 'danger',
                'body' => 'El acceso a la zona solicitada es reestringida'
            ]);
        }

        // Podemos declarar filtros encadenados al mencionarlos dentro de nuestras rutas, sin embargo, haremos mas de una logica en este mismo filtro

        // Verificar que el usuario actual este registrado en base de datos
        // Es posible que la sesion exista pero el usuario se haya borrado de la base de datos
        $modelUser = model('UserModel');

        if (!$user = $modelUser->getUserBy('id', session()->user_id)) {
            // Cortar el flujo, pues el usuario no existe
            // Buena idea destruir la session de este usuario
            session()->remove(['user_id', 'username', 'is_logged']);

            return redirect()->route('auth.login')->with('message', [
                'type' => 'danger',
                'body' => 'El usuario ya no se encuentra registrado en el sistema'
            ]);
        }

        // Verificar si el rol del usuario, se encuentra dentro del listado de los permitidos, y le permite continuar con su petición
        if (!in_array($user->getRole()->name, $arguments)) {
            // Buena idea enviarle una pagina 404 o 403
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}