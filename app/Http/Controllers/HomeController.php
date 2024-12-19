<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;  

use App\Models\Booking;  
use App\Models\EmailTemplate;
use App\Models\File;
use App\Http\Controllers\BookingController;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        // Recupera 15 registros por página
        $bookings = Booking::paginate(15);
         
        return view('admin.panel', compact('bookings'));
    }

    public function users(Request $request)
    {
        // Inicializa las consultas de Booking y File
        $bookingQuery = Booking::query();
        $fileQuery = File::query();

        // Aplica filtros si se reciben en el request por name,email,phone,short_id,dni,filename
        if ($request->filled('searchQuery')) {
            $searchQuery = '%' . $request->searchQuery . '%';

            $bookingQuery->where(function ($query) use ($searchQuery) {
                $query->where('client_name', 'like', $searchQuery)
                    ->orWhere('client_email', 'like', $searchQuery)
                    ->orWhere('client_phone', 'like', $searchQuery)
                    ->orWhere('short_id', 'like', $searchQuery);
            });

            $fileQuery->where(function ($query) use ($searchQuery) {
                $query->where('client_name', 'like', $searchQuery)
                    ->orWhere('client_email', 'like', $searchQuery)
                    ->orWhere('client_phone', 'like', $searchQuery)
                    ->orWhere('short_id', 'like', $searchQuery)
                    ->orWhere('dni', 'like', $searchQuery)
                    ->orWhere('filename', 'like', $searchQuery);
            });
        }
        // Aplica filtros si se reciben en el request por fecha
        if ($request->filled('startDate')) {
            if ($request->filled('exactDate')) {
                $bookingQuery->whereDate('date_booking', $request->startDate);
                $fileQuery->whereDate('date_booking', $request->startDate);
            } elseif ($request->filled('endDate')) {
                $bookingQuery->whereBetween('date_booking', [$request->startDate, $request->endDate]);
                $fileQuery->whereBetween('date_booking', [$request->startDate, $request->endDate]);
            } else {
                $bookingQuery->whereDate('date_booking', '>=', $request->startDate);
                $fileQuery->whereDate('date_booking', '>=', $request->startDate);
            }
        }

        // Obtén los primeros 50 registros filtrados de cada tabla
        $bookings = $bookingQuery->take(50)->get();
        $files = $fileQuery->take(50)->get();

        // Mapea los datos de ambas colecciones
        $listaFront = $bookings->map(function ($booking) {
            return [
                'client_name' => $booking->client_name,
                'client_email' => $booking->client_email,
                'client_phone' => $booking->client_phone,
                'client_kind' => $booking->client_kind,
                'short_id' => $booking->short_id,
                'date_booking' => $booking->date_booking,
            ];
        })->toArray();

        $filesMapped = $files->map(function ($file) {
            return [
                'client_name' => $file->client_name,
                'client_email' => $file->client_email,
                'client_phone' => $file->client_phone,
                'client_kind' => $file->client_kind,
                'short_id' => $file->short_id,
                'date_booking' => $file->date_booking,
                'dni' => $file->dni,
                'filename' => $file->filename,
            ];
        })->toArray();

        // Unifica ambas colecciones bajo la misma variable
        $listaFront = array_merge($listaFront, $filesMapped);

        return view('admin.users.index', compact('listaFront'));
    }

    public function userActions(Request $request)
    {  
    
        $shortId = $request->input('short_id');
        $newClientKind = $request->input('new_client_kind');
     
        // Inicializa los contadores de cambios
        $bookingUpdated = 0;
        $fileUpdated = 0;
    
        // Buscar y actualizar en Booking
        $bookingUpdated = Booking::where('short_id', $shortId)
            ->update(['client_kind' => $newClientKind]);
    
        // Buscar y actualizar en File
        $fileUpdated = File::where('short_id', $shortId)
            ->update(['client_kind' => $newClientKind]);
    
        // Verificar si se realizó algún cambio
        if ($bookingUpdated === 0 && $fileUpdated === 0) {
            return response()->json([
                'message' => 'Short ID not found in any database.'
            ], 400);
        }
    
        // Respuesta exitosa con el número de registros modificados
        return response()->json([
            'message' => 'Client kind updated successfully.',
            'booking_updated' => $bookingUpdated,
            'file_updated' => $fileUpdated,
        ]); 
        
        
    }

    public function emails(Request $request)
    {
        // Obtener productos seleccionados (actividades)
        $selectedProducts = $request->input('activities', []);
        // Obtener ubicaciones seleccionadas
        $selectedLocations = $request->input('locations', []);
    
        // Obtener plantillas de correos que no están eliminadas (deleted = false)
        $emailTemplates = File::where('deleted', false)->get();
    
        // Obtener todas las actividades únicas (productos) desde el modelo Booking
        $productNames = Booking::pluck('product_name')->unique()->toArray();
    
        // Obtener todas las ubicaciones únicas (solo países) desde el modelo Booking
        $locations = Booking::pluck('location')
            ->map(function ($location) {
                // Tomar solo la primera parte de la ubicación antes de la coma
                return explode(',', $location)[0];
            })
            ->unique()
            ->toArray();
    
        // Obtener correos electrónicos únicos de los clientes desde el modelo Booking
        $clientEmails = Booking::when($selectedProducts, function ($query) use ($selectedProducts) {
            return $query->whereIn('product_name', $selectedProducts);
        })
        ->when($selectedLocations, function ($query) use ($selectedLocations) {
            return $query->whereIn('location', $selectedLocations);
        })
        ->pluck('client_email')
        ->filter(function ($email) {
            return $email && trim($email) !== "" && !str_ends_with(trim($email), '@reply.getyourguide.com');
        })
        ->unique()
        ->toArray();
    
        // Recuperar archivos asociados (si es necesario, ajusta según el caso)
        $files = File::all();  // Si necesitas recuperar archivos, ajusta la consulta según lo que se necesite
    
        // Pasar los datos a la vista
        return view('admin.emails.index', compact('clientEmails', 'productNames', 'locations', 'emailTemplates', 'files'));
    }

    public function _emails(Request $request)
    {
        // Obtener productos seleccionados
        $selectedProducts = $request->input('activities', []);
        // Obtener ubicaciones seleccionadas
        $selectedLocations = $request->input('locations', []);

        $emailTemplates = EmailTemplate::where('deleted', false)->get();
    
        // Obtener todas las actividades únicas
        $productNames = Booking::pluck('product_name')->unique()->toArray();
    
        // Obtener todas las ubicaciones únicas (solo países)
        $locations = Booking::pluck('location')
            ->map(function ($location) {
                return explode(',', $location)[0];
            })
            ->unique()
            ->toArray();
    
        // Obtener correos electrónicos únicos, excluyendo ciertos dominios
        $clientEmails = Booking::when($selectedProducts, function ($query) use ($selectedProducts) {
            return $query->whereIn('product_name', $selectedProducts);
        })
        ->when($selectedLocations, function ($query) use ($selectedLocations) {
            return $query->whereIn('location', $selectedLocations);
        })
        ->pluck('client_email')
        ->filter(function ($email) {
            return $email && trim($email) !== "" && !str_ends_with(trim($email), '@reply.getyourguide.com');
        })
        ->unique()
        ->toArray();
    
        // Pasar los datos a la vista
        return view('admin.emails.index', compact('clientEmails', 'productNames', 'locations', 'emailTemplates'));
    }
    
    public function send(Request $request)
    {
        // dd([
        //     'to' => $request->input('to'),
        //     'subject' => $request->input('subject'),
        //     'body' => $request->input('body'),
        //     'attachments' => $request->file('attachments'), // Mostrar archivos adjuntos
        // ]);
        foreach ($recipients as $email) {
            try {
                // Enviar correo
                Mail::html($body, function ($message) use ($email, $subject, $request) {
                    $message->to($email)
                            ->subject($subject);
    
                    // Adjuntar archivos
                    if ($request->hasFile('attachments')) {
                        foreach ($request->file('attachments') as $file) {
                            $message->attach($file->getRealPath(), [
                                'as' => $file->getClientOriginalName(),
                                'mime' => $file->getMimeType(),
                            ]);
                        }
                    }
                });
                
                \Log::info("Correo enviado a {$email} exitosamente.");
                $varControl++;
    
                // Pausar cada 5 correos
                if ($varControl % 5 == 0) {
                    sleep(30); 
                }
            } catch (\Exception $e) {
                // Registrar errores
                \Log::error("Error enviando correo a {$email}: " . $e->getMessage());
                continue;
            }
        }
    
        return redirect()->route('emails.index')->with('success', 'Correos enviados exitosamente.');
    }
    
    public function settings()
    {
        // Recupera 15 registros por página
        $bookings = Booking::paginate(15);
         
        return view('admin.settings.index', compact('bookings'));
    }
}
