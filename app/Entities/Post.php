<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Post extends Entity
{
	protected $datamap = [];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
		// La fecha de publicación será un objeto Date/Time
		'published_at',
	];
	protected $casts   = [];

	// Setter para generar un slug válido para este post
	protected function setSlug(string $title)
	{
		// Helper CI para generar slugs (omitiendo caracteres especiales)
		// Separador -, convertir todo a minusculas
		$slug = mb_url_title($title, '-', true);

		// Buscar en base de datos si el slug generado ya existe, de ser así se procede a generar
		// otro de forma iterativa hasta que se consiga generar uno que sea unico
		$postModel = model('PostModel');

		// Si existe retorna una entidad, caso contrario retorna nulo
		while($postModel->where('slug', $slug)->find() != null) {
			// Generar un nuevo slug colocando como sufijo -1, -2, ...
			$slug = increment_string($slug, '-');
		}

		// Setear el nuevo slug como propiedad de esta entidad
		$this->attributes['slug'] = $slug;
		
	}

	// Getter para obtener el nombre completo del autor
	// Los getters pueden llamar a otros modelos que le retornen información, y si hay una entidad de por medio
	// se pueden invocar getters para obtener información decorada
	public function getAuthor()
	{
		// Los datos del autor se encuntran relacionados con la tabla users_info
		$userInfoModel = model('UserInfoModel');
		// Buscar en la tabla, el registro que coincide con el autor relacionado con esta publicación
		// Como no queremos mostrar toda la info del registro, lo mas conveniente es que nos retorne una entidad que cuente con un getter que me arroje la info deseada
		return $userInfoModel->where('user_id', $this->user_id)->first();
	}

	public function getCategories()
	{
		// Buscar las posibles categorías asociadas a este post
		$categoriesPostsModel = model('CategoriesPostsModel');
		// Si la consulta no encuentra registros retorna nulo, por tanto, en esos casos retorno un array vacio
		// Primero busco los registros en la tabla pivote, luego hago un join hacia la tabla que tiene la data que quiero proyectar
		return $categoriesPostsModel->where('post_id', $this->id)->join('categories', 'categories.id = category_post.category_id')->findAll() ?? [];
	}

	public function getLinkImage()
	{
		// Por defecto CI guarda los uploads en writable. Para tener acceso publico, es necesario crear un enlace simbólico
		// En Win10 usar el comando mklink, que se genere dentro de public/carpeta_contenedora y que apunte a writable/uploads/carpeta_contenedora
		// Linux usar comando ln -s origen destino
		// ln -s /opt/lampp/htdocs/Projects/Codeigniter/blog/writable/uploads/covers ./public 
		return base_url('covers/' . $this->cover);
	}

	// Este metodo se encarga de generar la url para visitar el contenido de este post.
	// Pasando como parametro al la URL el slug de esta publicación
	public function getLinkPost()
	{
		return base_url(route_to('posts.show', $this->slug));
	}

}
