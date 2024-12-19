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
                'client_name' => $request->input('nombre_cliente'),
                'dni' => $request->input('dni'),
                'client_email' => $request->input('email'),
                'client_phone' => $request->input('telefono'),
                'date_booking' => $fechaFirma,
                'anyoNacimiento' => $request->input('anyoNacimiento'),
                'short_id' => $request->input('short_id'), // Agregado para capturar el short_id
                'client_kind' => $request->input('client_kind') ?? 'blue', // Usa 'blue' si no se proporciona un valor
            ]);
            
    
            return response()->json([
                'message' => 'Archivo y datos guardados correctamente.',
                'path' => $path,
                'filename' => $filename
            ], 200);
        }
    
        return response()->json(['message' => 'No se pudo subir el archivo.'], 400);
    }

 
    
    
}
