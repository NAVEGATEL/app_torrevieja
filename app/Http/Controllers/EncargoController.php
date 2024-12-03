<?php

namespace App\Http\Controllers;

use App\Models\Encargo;
use App\Models\Product;
use Illuminate\Http\Request;

class EncargoController extends Controller
{

    //Muestra la lista de encargos con fecha de entrega futura
    public function index()
    {
        $encargos = Encargo::where('hora_entrega', '>', now())
            ->with('product') // Carga la relación del producto
            ->orderBy('hora_entrega')
            ->get();

        return view('admin.encargos.index', ['encargos' => $encargos]);
    }

    // Muestra la vista de creación de un nuevo encargo.
    public function create()
    {

        return view('admin.encargos.create');
    }


    // Guarda un nuevo encargo desde el panel de administración y redirige con un mensaje de éxito.
    public function storePanel(Request $request)
    {
        // Validar los campos del formulario
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'date' => 'required|date',
        //     'hora_pedido' => 'required|date_format:H:i', 
        // ]);

        // Crear un nuevo objeto Encargo con los datos del formulario
        $encargo = new Encargo([
            'nombre_apellidos' => $request->name,
            'hora_entrega' => $request->date . " " . $request->hora_pedido,
            'detalles' => $request->description,
            'pollo_encargo' => $request->pollo_encargo,
            'confirmado' => true
        ]);

        $encargo->save();

        return redirect()->route('encargos.index')->with('success', 'Encargo creado exitosamente');
    }
 
    public function storeAlexa(Request $request)
    {
        // Validar los datos que llegan desde Alexa
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'hora' => 'required'
        ]);
        
        // Convertir la hora a formato de 24 horas asumiendo que es por la tarde
        $horaFormat = \Carbon\Carbon::createFromFormat('g:i A', $request->hora . ' PM'); // Siempre PM

        // Crear el encargo con los datos de Alexa
        $encargo = new Encargo([
            'nombre_apellidos' => $request->nombre,
            'hora_entrega' => now()->toDateString() . " " . $request->hora, // Combina la fecha de hoy con la hora recibida
            'detalles' => "{$request->cantidad} pollo(s)", // Detalle del pedido
            'pollo_encargo' => $request->cantidad,
            'confirmado' => true
        ]);
    
        $encargo->save();
    
        // Responder a Alexa en el formato esperado
        return response()->json([
            "version" => "1.0",
            "response" => [
                "outputSpeech" => [
                    "type" => "PlainText",
                    "text" => "Pedido registrado correctamente para {$request->nombre}, cantidad de pollos: {$request->cantidad}, entrega a las {$request->hora}."
                ],
                "shouldEndSession" => true
            ]
        ]);
    }    



    // Guarda un nuevo encargo desde una solicitud externa y devuelve una respuesta de éxito.
    public function store(Request $request)
    {
        $datos = json_decode($request[0]);
        // Encuentra el producto utilizando el nombre recibido
        $producto = Product::where('name', $datos->{"pedido-usuario"})->first();
        // Crear un nuevo objeto Encargo con los datos recibidos
        $encargo = new Encargo([
            'nombre_apellidos' =>$datos->{"identidad-usuario"} ,
            'menu_id' => $producto->id,
            'pollo_encargo' =>$datos->{"pollo_encargo"},
            'detalles' =>$datos->{"detalles"},
            'hora_entrega' => $datos->{"hora-usuario"},
            'email' =>$datos->{"email-usuario"} ,
            'telefono' => $datos->{"telefono-usuario"}, 
            'confirmado' => false
        ]);


        $encargo->save();

        return response()->json($encargo);
        //return redirect()->back()->with('success', 'Encargo realizado con éxito');
    }


    // Actualiza y muestra la tabla de encargos con fecha de entrega futura.
    public function refresh()
    {
        $encargos = Encargo::where('hora_entrega', '>', now())
            ->orderBy('hora_entrega')
            ->get();
        return view('admin.encargos._table', compact('encargos'));
    }

    public function actualizarEncargo(Request $request)
    {
        // Validar los datos recibidos desde la solicitud POST
        $request->validate([
            'encargoId' => 'required|integer',
            'confirmado' => 'required|boolean'
        ]);
    
        $encargoId = $request->input('encargoId');
        $confirmado = $request->input('confirmado');
    
        try {
            // Buscar el encargo por su ID
            $encargo = Encargo::findOrFail($encargoId);
    
            // Actualizar el estado del encargo
            $encargo->confirmado = $confirmado;
            $encargo->save();
    
            // Si todo es exitoso, retornar una respuesta con estado HTTP 200
            return response()->json(['message' => 'El estado del encargo ha sido actualizado con éxito'], 200);
        } catch (\Throwable $th) {
            // En caso de error, retornar una respuesta con estado HTTP 500 y el mensaje de error
            return response()->json(['message' => 'Error al actualizar el estado del encargo'], 500);
        }
    }


    // Marca un encargo como entregado y redirige con un mensaje de éxito.
    public function entregado(Encargo $encargo)
    {
        $encargo->entregado = true;
        $encargo->save();

        return redirect()->back()->with('success', 'Encargo entregado con éxito.');
    }

    public function destroy($id)
    {
        $encargo = Encargo::findOrFail($id);

        // Aquí puedes realizar alguna validación adicional si es necesario

        $encargo->delete();

        return back()->with('success', 'Encargo borrado con éxito');
    }

}
