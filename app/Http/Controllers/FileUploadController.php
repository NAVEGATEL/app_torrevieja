<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function store(Request $request)
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
