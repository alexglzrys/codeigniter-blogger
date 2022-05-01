<?php
namespace App\Controllers\Admin;

use Hashids\Hashids;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class CategoryController extends BaseController
{

    public function index()
    {
        $categoryModel = model('CategoryModel');
        
        $categories = $categoryModel->orderBy('created_at', 'DESC')->paginate(config('Blog')->regPerPage);
        $pager = $categoryModel->pager;

        return view('admin/categories/index', compact('categories', 'pager'));

    }

    public function create()
    {

        return view('admin/categories/create');

    }

    public function store()
    {

        // Validar información 
        if (!$this->validate([
            'name' => [
                'label' => 'nombre de categoría',
                'rules' => 'trim|required|max_length[70]|alpha_name',
                'errors' => [
                    'alpha_name' => 'El {field} parece ser un dato no válido',
                    'required' => 'El {field} es un dato requerido'
                ]
            ]
        ])) {
            //$this->form_validation->set_message('alpha_name', 'hla');
            // Redireccionar a la vista anterior con la data, errores y mensaje
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('message', [
                'type' => 'danger',
                'body' => 'Existen datos incorrectos en la solicitud de registro'
            ]);
        }

        // Almacenar la categoría en base de datos
        $categoryModel = model('CategoryModel');

        // Importante sanar información
        $categoryModel->save([
            'name' => trim($this->request->getPost('name'))
        ]);

        return redirect()->route('categories.index')->with('message', [
            'type' => 'success',
            'body' => 'Categoría registrada exitosamente en el sistema'
        ]);

    }

    public function edit($id)
    {
        $modelCategory = model('CategoryModel');

        // Si la categoría no es encontrada retornamos un 404
        if (!$category = $modelCategory->find($id)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/categories/edit', compact('category'));
    }

    public function update($id)
    {
        // Validar datos de entrada
        if (!$this->validate([
            'name' => [
                'label' => 'nombre de categoría',
                'rules' => 'trim|required|max_length[70]|alpha_name',
                'errors' => [
                    'required' => 'El {field} es un dato requerido',
                    'max_length' => 'El {field} no debe exceder los {param} caracteres',
                    'alpha_name' => 'El {field} para ser un dato no válido'
                ]
            ]
        ])) {
            // Redireccionar a la vista anterior con las entradas, errores, y mensaje
            return redirect()->back()->withInput()
                                     ->with('errors', $this->validator->getErrors())
                                     ->with('message', [
                                         'type' => 'danger',
                                         'body' => 'Se detectaron algunos errores en tu solicitud'
                                     ]);
        }

        // Tomar los datos de entrada y actualizar el registro
        $name = trim($this->request->getPost('name'));
        $categoryModel = model('CategoryModel');

        // Si se pasa el id al método save, se realiza una actualización sobre ese registro
        $categoryModel->save([
            'id' => $id,
            'name' => $name
        ]);
        
        // Redireccionar a la vista de todas las categorías
        return redirect()->route('categories.index')->with('message', [
            'type' => 'success',
            'body' => 'Categoría actualizada correctamente en el sistema'
        ]);

    }

    public function destroy($id)
    {

        // Decodificar el parametro enviado por URL
        // Hashids es una librería que codifica ids numéricos al estilo youtube (youtube.com/vy45sd) para no exponer estos valores a nuestros usuarios
        $hash = new Hashids();
        $id = $hash->decode($id);

        // Eliminar el registro
        $categoryModel = model('CategoryModel');
        $categoryModel->delete($id);

        // Redireccionar a la vista principal de categorías
        return redirect()->route('categories.index')->with('message', [
            'type' => 'success',
            'body' => 'Categoría eliminada satisfactoriamente'
        ]);

    }

}