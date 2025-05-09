<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\File as FileModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ConsentController extends Controller
{
    public function submit(Request $request) 
    {
        Log::info('Recibiendo solicitud de consentimiento');
        
        try {
            // Crear registro de reserva
            $booking = new Booking();
            $booking->short_id = $request->input('short_id', Str::random(10));
            $booking->product_name = 'Actividad Náutica';
            $booking->supplier_company_name = 'Actividades Náuticas Torrevieja';
            $booking->seller_company_name = 'Actividades Náuticas Torrevieja';
            $booking->language_code = 'es';
            $booking->location = 'Torrevieja';
            $booking->service_flow = 'formulario_web';
            
            // Datos del cliente principal
            $booking->client_name = $request->input('nombre_1');
            $booking->client_phone = $request->input('telefono_1');
            $booking->client_email = $request->input('email_1');
            $booking->client_id = $request->input('dni_1');
            $booking->client_kind = 'individual';
            
            $booking->date_booking = now();
            $booking->date_modified = now();
            $booking->currency = 'EUR';
            $booking->total_price = 0;
            $booking->payment_partial = 0;
            
            // Guardar información de actividades
            $actividades = [];
            if($request->input('actividad_parasailing')) {
                $actividades['parasailing'] = [
                    'num_personas' => $request->input('parasailing_num'),
                    'participantes' => $request->input('parasailing_participantes'),
                    'acompanantes' => $request->input('parasailing_acompanantes'),
                ];
            }
            if($request->input('actividad_hinchable')) {
                $actividades['hinchable'] = [
                    'tipo' => $request->input('hinchable_tipo'),
                    'num_personas' => $request->input('hinchable_num'),
                    'participantes' => $request->input('hinchable_participantes'),
                    'acompanantes' => $request->input('hinchable_acompanantes'),
                ];
            }
            if($request->input('actividad_flyboard')) {
                $actividades['flyboard'] = [
                    'tiempo' => $request->input('flyboard_tiempo'),
                    'num_personas' => $request->input('flyboard_num'),
                    'participantes' => $request->input('flyboard_participantes'),
                    'acompanantes' => $request->input('flyboard_acompanantes'),
                ];
            }
            
            $booking->ticket_type_count = json_encode($actividades);
            $booking->status = 'firmado';
            $booking->source = 'web';
            
            $booking->save();
            
            // Guardar archivo PDF
            if ($request->has('pdf_file')) {
                $this->savePdfFile($request, 'pdf_file', $booking);
            }
            else if ($request->has('file')) {
                $this->savePdfFile($request, 'file', $booking);
            }
            else if ($request->has('archivo_pdf')) {
                $this->savePdfFile($request, 'archivo_pdf', $booking);
            }
            else {
                Log::warning('No se encontró ningún archivo PDF en la solicitud');
            }
            
            return response()->json(['success' => true, 'message' => 'Formulario procesado correctamente']);
        } 
        catch (\Exception $e) {
            Log::error('Error al procesar el consentimiento: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al procesar el consentimiento: ' . $e->getMessage()], 500);
        }
    }
    
    private function savePdfFile(Request $request, $fieldName, $booking) 
    {
        try {
            // Recibir el archivo base64
            $base64Data = $request->input($fieldName);
            
            // Verificar si es un string y si contiene datos base64
            if (is_string($base64Data) && strpos($base64Data, 'base64') !== false) {
                // Extraer solo los datos en base64
                $base64Data = explode(';base64,', $base64Data)[1];
                
                // Decodificar los datos
                $fileData = base64_decode($base64Data);
                
                // Generar nombre de archivo con el mismo formato que el cliente
                $timestamp = time();
                $filename = 'consent_' . $booking->short_id . '_' . $timestamp . '.pdf';
                
                // Guardar el archivo en el almacenamiento
                Storage::put('uploads/' . $filename, $fileData);
                
                // Registrar en modelo File
                $file = new FileModel();
                $file->filename = $filename;
                $file->short_id = $booking->short_id;
                $file->client_name = $booking->client_name;
                $file->client_email = $booking->client_email;
                $file->client_phone = $booking->client_phone;
                $file->client_id = $booking->client_id;
                $file->client_kind = $booking->client_kind;
                $file->dni = $booking->client_id; // En File se usa 'dni' en vez de 'client_id'
                $file->date_booking = now();
                $file->save();
                
                Log::info('PDF guardado correctamente como: ' . $filename);
                return true;
            }
            // Si es un archivo subido normalmente
            else if ($request->hasFile($fieldName)) {
                $uploadedFile = $request->file($fieldName);
                
                if ($uploadedFile->isValid()) {
                    // Generar nombre de archivo con el mismo formato que el cliente
                    $timestamp = time();
                    $filename = 'consent_' . $booking->short_id . '_' . $timestamp . '.pdf';
                    
                    $path = $uploadedFile->storeAs('uploads', $filename);
                    
                    // Registrar en la base de datos
                    $file = new FileModel();
                    $file->filename = $filename;
                    $file->short_id = $booking->short_id;
                    $file->client_name = $booking->client_name;
                    $file->client_email = $booking->client_email;
                    $file->client_phone = $booking->client_phone;
                    $file->client_id = $booking->client_id;
                    $file->client_kind = $booking->client_kind;
                    $file->dni = $booking->client_id;
                    $file->date_booking = now();
                    $file->save();
                    
                    Log::info('Archivo PDF guardado correctamente: ' . $filename);
                    return true;
                }
            }
            
            Log::warning("El archivo $fieldName no es válido o no se pudo procesar");
            return false;
        }
        catch (\Exception $e) {
            Log::error('Error al guardar el archivo PDF: ' . $e->getMessage());
            return false;
        }
    }

    public function submitMoto(Request $request)
    {
        $booking = new Booking();

        $booking->short_id = uniqid();
        $booking->product_name = 'Moto Experience';
        $booking->supplier_company_name = 'TuEmpresaMoto';
        $booking->seller_company_name = 'TuEmpresaMoto';
        $booking->language_code = 'es';
        $booking->location = $request->input('poblacion') ?? 'desconocida';
        $booking->service_flow = 'formulario_web';

        $booking->date_booking = now();
        $booking->date_modified = now();

        $booking->client_name = $request->input('nombre_apellidos');
        $booking->client_phone = $request->input('telefono');
        $booking->client_email = $request->input('email');
        $booking->client_id = $request->input('documento_identidad') ?? '';
        $booking->client_kind = 'individual';

        $booking->currency = 'EUR';
        $booking->total_price = 0; // puedes ponerlo desde el formulario si quieres
        $booking->payment_partial = 0;

        $booking->ticket_type_count = json_encode([
            'personas' => $request->input('numero_personas'),
        ]);

        $booking->payment_transaction = json_encode([
            'metodo' => $request->has('pago_efectivo') ? 'efectivo' : 'otro',
        ]);

        $booking->status = 'pendiente';
        $booking->source = 'formulario_moto';

        $booking->save();

        return redirect()->back()->with('success', 'Formulario enviado y guardado correctamente.');
    }
}
