<?php
namespace App\Controllers\Admin;

use App\Entities\Post;
use App\Controllers\BaseController;

class PostController extends BaseController
{

    public function index()
    {
        return view('admin/posts/index');
    }

    public function create()
    {

        $categoryModel = model('CategoryModel');
        $categories = $categoryModel->findAll();
        return view('admin/posts/create', compact('categories'));
    }

    public function store()
    {
        // Recuperar información plana del formulario
        // dd($this->request->getPost());
        // Recuperar información de archivos
        // dd($this->request->getFiles());

        

        // Validar datos de entrada
        if (!$this->validate([
            'title' => [
                'label' => 'titulo de la publicación',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'El {field} es un dato requerido'
                ]
            ],
            'body' => [
                'label' => 'contenido detallado de la publicación',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => 'El {field} es un dato requerido'
                ]
            ],
            'published_at' => [
                'label' => 'fecha de publicación',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'La {field} es un dato requerido',
                    'valid_date' => 'La {field} no es una fecha válida'
                ]
            ],
            // .* Revisa cada elemento adjunto en el arreglo categories[]
            'categories.*' => [
                'label' => 'categoría(s) asociadas a la publicación',
                // Se permiten valores vacios (en caso de no seleccionar una categoria), y de haber seleccionadas, su valor debe existir dentro del campo id de la tabla categorias
                'rules' => 'permit_empty|is_not_unique[categories.id]',
                'errors' => [
                    'is_not_unique' => 'La {field} parece ser un dato no válido'
                ]
            ],
            // Los campos de tipo file tienen sus propias reglas de validación, no se deben mezclar con los de datos planos
            'cover' => [
                'label' => 'imagen asociada a la publicación',
                'rules' => 'uploaded[cover]|is_image[cover]',
                'errors' => [
                    'uploaded' => 'La {field} es un dato requerido',
                    'is_image' => 'La {field} debe ser de tipo imagen'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()
                                     ->with('errors', $this->validator->getErrors())
                                     ->with('message', [
                                         'type' => 'danger',
                                         'body' => 'Se detectaron algunos errores asociados con la publicación'
                                     ]);
        }

        // Recuperar el archivo enviado
        $file = $this->request->getFile('cover');

        // La entidad solo seteará las keys que coincidan con sus propiedades
        // Hacemos esto ya que necesitamos decorar la info antes de almacenarla en base de datos
        $post = new Post($this->request->getPost());
        // Setear un slug para esta publicación - Internamente la entidad hace logica para generarlo 
        $post->slug = $this->request->getPost('title');
        // Setear el id de este usuario como dueño de la publicación
        $post->user_id = session()->user_id;
        // Setear el nombre del archivo - Genear un nombre de archivo unico (ya incluye la extension)
        $post->cover = $file->getRandomName();

        // Seetear las categorías asociadas a este post.
        // No puedo hacerlo mediante la entidad, ya que para poder asociarlas necesito el id del post
        // para guardar su referencia en la tabla pivote.
        // Aqui viene de maravilla un callback after, una vez guardado el post, se guardan sus categoriías
        
        // Guardar información en base de datos
        $postModel = model('PostModel');
        $postModel->assignCategories($this->request->getPost('categories'));

        $postModel->save($post);

        // Mover el archivo al directorio de destino
        // Por defecto CI guarda los archivos dentro de writable/uploads. En este sentido como ese directorio tiene permisos de lectura/escritura, no es necesario anticiparse a crear la carpeta
        // Este metodo retorna el path donde se guarda el archivo

        // Si se desea guardar dentro del directorio public, es necesario apuntar al rootPath
        // ../public/carpeta o ROOTPATH.'/public/cartpeta'
        $file->store('covers/', $post->cover);
        
        // Redireccionar a la vista principal de publicaciones
        return redirect()->route('posts.index')->with('message', [
            'type' => 'success',
            'body' => 'Post almacenado correctamente en el sistema'
        ]);
        
    }

}