<?php

namespace App\Http\Controllers;

use App\Models\File;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FileUploadController extends Controller
{


    public function store(Request $request)
    {

        if ($request->hasFile('file')) {
            // Limpiar y formatear el nombre del archivo
            $filename = $request->query('filename', 'default.pdf');
            $filename = preg_replace('/[\/:*?"<>|\\\\]/', '_', $filename);
            $path = $request->file('file')->storeAs('uploads', $filename);
    
            // Convertir fechaFirma al formato correcto (YYYY-MM-DD)
            $fechaFirma = $request->input('fechaFirma');
            try {
                $fechaFirma = Carbon::createFromFormat('d/m/Y H:i', $fechaFirma)->format('Y-m-d');
            } catch (\Exception $e) {
                $fechaFirma = now()->format('Y-m-d');
            }
    
   
    
            // Guardar los datos en la base de datos
            File::create([
                'filename' => $filename,
                'nombre_cliente' => $request->input('nombre_cliente'),
                'dni' => $request->input('dni'),
                'email' => $request->input('email'),
                'telefono' => $request->input('telefono'),
                'fechaFirma' => $fechaFirma,
                'anyoNacimiento' => $request->input('anyoNacimiento')
            ]);
    
            return response()->json([
                'message' => 'Archivo y datos guardados correctamente.',
                'path' => $path,
                'filename' => $filename
            ], 200);
        }
    
        return response()->json(['message' => 'No se pudo subir el archivo.'], 400);
    }





    public function store2(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',
            'nombre_cliente' => 'required|string|max:255',
        ]);

        if ($request->hasFile('file')) {
            // Obtener y limpiar el nombre del archivo desde la URL
            $filename = $request->query('filename', 'default.pdf');
            $filename = preg_replace('/[\/:*?"<>|\\\\]/', '_', $filename);

            // Guardar el archivo
            $path = $request->file('file')->storeAs('uploads', $filename);

            // Guardar en la base de datos
            File::create([
                'filename' => $filename,
                'nombre_cliente' => $request->input('nombre_cliente'),
            ]);

            return response()->json([
                'message' => 'Archivo subido correctamente.',
                'path' => $path,
                'filename' => $filename
            ], 200);
        }

        return response()->json(['message' => 'No se pudo subir el archivo.'], 400);
    }




    public function store1(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);
    
        if ($request->hasFile('file')) {
            // Obtener el nombre del archivo desde la URL
            $filename = $request->query('filename', 'default.pdf');
    
            // Limpiar el nombre del archivo: reemplazar caracteres no válidos
            $filename = preg_replace('/[\/:*?"<>|\\\\]/', '_', $filename); // Reemplaza / \ : * ? " < > | con '_'
    
            // Guardar el archivo con el nombre limpio
            $path = $request->file('file')->storeAs('uploads', $filename);
    
            return response()->json([
                'message' => 'Archivo subido correctamente.',
                'path' => $path,
                'filename' => $filename
            ], 200);
        }
    
        return response()->json(['message' => 'No se pudo subir el archivo.'], 400);
    }
    
    
}
