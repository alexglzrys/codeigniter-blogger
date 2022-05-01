<?php

namespace App\Controllers\Blog;

use App\Controllers\BaseController;

class Home extends BaseController
{
	public function index()
	{
		// Todos los componentes de CI4 ya estan como servicios. (Se pueden invocar como funciones)
		// No es necesario cargarlos como en CI3
		$postModel = model('PostModel');

		// Los helpers es necesario invocarlos para poder usarlos en la vista
		// Si es de uso general en el controlador, se propone declararlo en el constructor
		helper('text');

		

		// Cuando paginamos resultados siempre se debe pasar a la vista los links de navegación
		// Los cuales se encuentran dentro de la propiedad pager del modelo

		// Hacemos uso de un metodo personalizado del modelo que nos permite filtrar nuestros posts
        $posts = $postModel->published()->orderBy('published_at', 'desc')->paginate(6);
		$pager = $postModel->pager;

		return view('blog/home', compact('posts', 'pager'));
	}

	public function post($slug)
	{
		$postModel = model('PostModel');

		// Localizar si existe un registro con dicho slug, de ser así mostramos su detalle
		if (!$post = $postModel->where('slug', $slug)->first()) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		return view('blog/post', compact('post'));
	}

	public function relacionados(array $args)
	{
		// Las view cell pasan parametros a un metodo en forma de array

		$postModel = model('PostModel');
		helper('text');

		// Recuperar los primeros 5 post pertenecientes a una determinada categoría. 
		// Si no se pasa el limite se retornan todos (0),
		// Se omite el el post pasado como excepción (id)
		$posts = $postModel->getPostsByCategory($args['category']) 
						   ->where('posts.id !=', $args['except'])
						   ->findAll($args['limit'] ?? 0);

		return view('components/relacionados', compact('posts'));
	}
	
}
