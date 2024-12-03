<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Rol;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    // Muestra la lista de categorías o productos en una categoría específica
    public function index(Request $request)
    {
        $titulo = "Asador la Morenica a la carta";
        $productos = Category::all();

        // Verifica si se ha enviado el parámetro "category" en la URL
        if ($request->has("categoria")) {
            $categoria = Category::findOrFail($request->query("categoria"));
            $productos = $categoria->productos; // Collection
            // $productos = $categoria->productos()->where("name", "Cortezas")->first(); // Relation (hasMany, belongToMany, etc)
            $titulo = $categoria->name;
        }

        // Retorna la vista 'products' con las variables 'titulo' y 'productos'
        return view('products', ['titulo' => $titulo, 'productos' => $productos]);
    }


    // Muestra la lista de categorías en el panel de administración
    public function indexCrud(Request $request)
    {
        // Obtiene el valor del parámetro 'text' de la URL y lo almacena en la variable $text
        $text = trim($request->get('text'));

        // Realiza una consulta a la tabla de categorías buscando las coincidencias del texto ingresado 
        $categorias = DB::table('categories')
            ->where('name', 'LIKE', '%' . $text . '%')
            ->orderBy('id', 'asc')
            ->paginate(10);

        // Retorna la vista 'admin.categories.index' con las variables 'categorias' y 'text'
        return view('admin.categories.index', compact('categorias', 'text'));
    }

    //Muestra la vista de creación de categorías
    public function create()
    {
        return view('admin.categories.create');
    }

    // Almacena una nueva categoría en la base de datos
    public function store(Request $request)
    {
        try{
        // Valida los datos ingresados en el formulario de creación de categorías
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image',
        ]);

        // Subo la imagen
        // Antes cambio el nombre de la imagen añadiendole el tiempo para que siempre sea distinto
        // Utilizo move y no store ni storeAs "Guardarlo como" porque queremos por un lado mover solo la imagen con el nuevo nombre
        $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('img/products'), $imageName);

        // Crea una nueva categoría en la base de datos
        Category::create(array_merge($request->all(), ['image' => $imageName]));

        // Redirige al usuario a la lista de categorías en el panel de administración
        return redirect()->route('categories.indexCrud')->with('success', 'Producto creado correctamente.');
    }catch (Exception $e){
        return redirect()->back()->withInput()->withErrors(['image' => 'Error al subir la imagen: ' . $e->getMessage()]);
    }
    }

    // Muestra una categoría específica en una vista
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    // Muestra el formulario de edición para una categoría específica    
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Actualiza una categoría específica en la base de datos
    public function update(Request $request, Category $category)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $updatedData = $request->only(['name', 'description', 'category_id']);
        $hasChanges = false;

        foreach ($updatedData as $key => $value) {
            if ($category->$key != $value) {
                $hasChanges = true;
                break;
            }
        }


        if ($request->hasFile('image')) {
            // Subir la imagen y actualizar el registro del producto
            $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('img/products'), $imageName);
            $category->image = $imageName;
            $hasChanges = true;
        } 


        // Actualizar el registro del producto solo si hay cambios
        if ($hasChanges) {
            $category->update($updatedData);
            // $category->update($request->all());
            // return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente');
            return redirect()->route('categories.indexCrud')->with('success', 'Producto actualizado correctamente');
        } else {
            return redirect()->route('categories.indexCrud')->with('info', 'No se realizaron cambios en el producto');
            // return redirect()->route('products.index')->with('info', 'No se realizaron cambios en el producto');
        }

    }

    // Elimina una categoría específica de la base de datos
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        // Obtener el ID de la categoría "Sin categoría"
        $defaultCategoryId = Category::where('name', 'Sin categoría')->first()->id;

        // Actualizar los productos asociados a la categoría eliminada
        $category->productos()->update(['category_id' => $defaultCategoryId]);

        //Borrado completo
        $category->forceDelete();
        return redirect()->route('categories.indexCrud');
    }

    //Realiza el borrado lógico de una categoría especifica
    public function borrado($id)
    {
        $category = Category::findOrFail($id);
        // Obtener el ID de la categoría "Sin categoría"
        $defaultCategoryId = Category::where('name', 'Sin categoría')->first()->id;

        // Actualizar los productos asociados a la categoría eliminada
        $category->productos()->update(['category_id' => $defaultCategoryId]);

        //Borrado lógico
        $category->delete();
        return redirect()->route('categories.indexCrud');
    }

    //Restaura una categoría previamente borrada mediante el borrado lógico
    public function restore($id)
    {
        // Encuentra la categoría eliminada (con borrado lógico) por ID 
        $category = Category::withTrashed()->findOrFail($id);

        $category->restore();

        return redirect()->route('categories.indexCrud');
    }
}
