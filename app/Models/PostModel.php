<?php

namespace App\Models;

use App\Entities\Post;
use CodeIgniter\Model;

/**
 * Modelo generado a partir de: php spark make:model PostModel
 */

class PostModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'posts';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 1;
	protected $returnType           = Post::class;
	protected $useSoftDelete        = true;
	protected $protectFields        = true;
	protected $allowedFields        = ['title', 'slug', 'body', 'cover', 'user_id', 'published_at'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Callbacks
	protected $allowCallbacks       = true;
	protected $afterInsert         	= ['storeCategories'];

	// Propiedades de utilidad
	protected $categories = [];

	// Función de utilidad para asignar las categorías en la propiedad del modelo
	public function assignCategories(array $categories)
	{
		$this->categories = $categories;
	}

	// Función callback que se ejecuta una vez guardado este post
	// Su intensión es registrar las categorías asociadas a este post en la tabla pivote

	/* IMPORTANTE: Este es un enfoque inteligente, ya que CI no cuenta con un ORM potente que me permita
				   usar funciones para guardar o consultar registros asociados a un modelo de
				   forma directa.
				   Se crean metodos, internamente esos metodos llaman al modelo correcto,
				   y le indican si ha de guardar, registrar, editar o eliminar pasando la data
				   con el id de este modelo en cuestion.

				   Pueden estar declarados en la entidad o modelo, pero en este caso como se trata
				   de un registro nuevo y a su vez asociar data con ese nuevo registro, se requiere
				   forzosamente del id, por ello se declará en el modelo, ya que con los callbacks
				   tengo acceso a la $data, la cual incluye un key con el id generado para el nuevo registro
	*/
	protected function storeCategories(array $data)
	{
		// Si existe al menos una categoría se procede con su registro
		if (!empty($this->categories)) {

			$myCategories = [];
			// Recorrer todas las categorías asociadas y generar la estructura de registro
			foreach ($this->categories as $value) {
				$myCategories[] = [
					'category_id' => $value,
					'post_id' => $data['id'],  // Una vez almacenado el post, el callback recibe un arreglo con data relacionada. En este caso me interesa el id generado para este post
				];
			}
			
			// Invocar modelo de tabla pivote y guardar información
			$pivotModel = model('CategoriesPostsModel');
			// Guardar el registro como un batch (pueden ser muchas categorías asociadas)
			$pivotModel->insertBatch($myCategories);
		}

		// Siempre es importante devolver la data
		return $data;
	}

	/**
	 * FILTROS
	 * 
	 * Son funciones que permiten condicionar/filtrar los resultados de una consulta
	 * a una base de datos. Para este caso los registros de la tabla posts
	 * 
	 * Deben retornar la propia instancia del modelo, es decir $this, para que se
	 * pueda encadenar con otras funciones del QueryBuilder
	 */

	// Función que filtra los posts por su fecha de publicación, retorna solo los que deben publicarse y no post futuristas
	public function published()
	{
		$this->where('published_at <=', date('Y-m-d H:i:s'));
		return $this;
	}

	// Quizá este metodo le corresponda al modelo categoría, pero en fin
	// Localizar todos los posts correspondientes a una categoría
	public function getPostsByCategory(string $category)
	{
		// Solo me interesa que me retorne los campos de los posts
		// Cuyo nombre de categoría se corresponda a la pasada como parametro
		// Relaciono este post con el pivote y la categoría
		// Del conjunto de resultados se omite el id del post pasado como parametro
		return $this->select('posts.*')
					->join('category_post', 'posts.id = category_post.post_id')
					->join('categories', 'categories.id = category_post.category_id')
					->where('categories.name', $category);

					// Devolvemos solo el query y no los resultados para poder seguir
					// encadenando (decorando) mi consulta desde donde se le llame
					// ya al final se le pide findAll,
	}
}
