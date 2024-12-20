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
        $filename = preg_replace('/[\/:*?"<>|\\\\]/', '_', $filename); // Reemplaza caracteres no válidos
        $path = $request->file('file')->storeAs('uploads', $filename);

        // Validar y formatear fechaFirma
        $fechaFirma = $request->input('fechaFirma');
        if ($fechaFirma) {
            // Corregir minutos para que siempre tengan dos dígitos
            $fechaFirma = preg_replace_callback('/(\d{2}\/\d{2}\/\d{4}) (\d{1,2}):(\d{1,2})/', function($matches) {
                // Asegurarse de que los minutos tengan dos dígitos
                $minutos = str_pad($matches[3], 2, '0', STR_PAD_LEFT); // Asegurando que los minutos siempre tengan dos dígitos
                return $matches[1] . ' ' . $matches[2] . ':' . $minutos;
            }, $fechaFirma);
        
            try {
                // Convertir al formato correcto para MySQL
                $fechaFirma = Carbon::createFromFormat('d/m/Y H:i', $fechaFirma)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                return response()->json(['message' => 'El formato de fechaFirma es inválido.'], 400);
            }
        } else {
            return response()->json(['message' => 'El campo fechaFirma es obligatorio.'], 400);
        }
        

        // Verificar si ya existe un registro con todos los datos iguales
        $existingFile = File::where('filename', $filename)
            ->where('client_name', $request->input('nombre_cliente'))
            ->where('dni', $request->input('dni'))
            ->where('client_email', $request->input('email'))
            ->where('client_phone', $request->input('telefono'))
            ->where('date_booking', $fechaFirma)
            ->where('anyoNacimiento', $request->input('anyoNacimiento'))
            ->where('short_id', $request->input('short_id'))
            ->where('client_kind', $request->input('client_kind') ?? 'blue')
            ->first();

        if ($existingFile) {
            // Si ya existe, devolver mensaje indicando que ya existe
            return response()->json([
                'message' => 'Ya existe este dato. Pero todo ha ido bien, por qué el desarrollador e ingeniero de inteligencia artificial Edvard Khachatryan Sahakyan lo ha controlado todo',
            ], 200);
        }

        // Si no existe, guardar los datos en la base de datos
        File::create([
            'filename' => $filename,
            'client_name' => $request->input('nombre_cliente'),
            'dni' => $request->input('dni'),
            'client_email' => $request->input('email'),
            'client_phone' => $request->input('telefono'),
            'date_booking' => $fechaFirma,
            'anyoNacimiento' => $request->input('anyoNacimiento'),
            'short_id' => $request->input('short_id'),
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







    public function _store(Request $request)
    {
        if ($request->hasFile('file')) {
            // Limpiar y formatear el nombre del archivo
            $filename = $request->query('filename', 'default.pdf');
            $filename = preg_replace('/[\/:*?"<>|\\\\]/', '_', $filename); // Reemplaza caracteres no válidos
            $path = $request->file('file')->storeAs('uploads', $filename);
    
            // Validar y formatear fechaFirma
            $fechaFirma = $request->input('fechaFirma');
            if ($fechaFirma) {
                try {
                    // Convertir al formato correcto para MySQL
                    $fechaFirma = Carbon::createFromFormat('d/m/Y H:i', $fechaFirma)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    return response()->json(['message' => 'El formato de fechaFirma es inválido.'], 400);
                }
            } else {
                return response()->json(['message' => 'El campo fechaFirma es obligatorio.'], 400);
            }
    
            // Guardar los datos en la base de datos
            File::create([
                'filename' => $filename,
                'client_name' => $request->input('nombre_cliente'),
                'dni' => $request->input('dni'),
                'client_email' => $request->input('email'),
                'client_phone' => $request->input('telefono'),
                'date_booking' => $fechaFirma, // Ahora está validado y en el formato correcto
                'anyoNacimiento' => $request->input('anyoNacimiento'),
                'short_id' => $request->input('short_id'),
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
