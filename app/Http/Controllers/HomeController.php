<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;  
use App\Services\UserDataService;
use Illuminate\Pagination\LengthAwarePaginator;

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
        // Matriz 1: Ventas Totales por Mes
        $salesData = [
            ['Enero', 'Febrero', 'Marzo', 'Abril'], // Nombres de los meses
            [1000, 2000, 3000, 4500],              // Valores correspondientes
        ];
    
        // Matriz 2: Reservas por Ciudad
        $reservationsData = [
            ['Madrid', 'Barcelona', 'Valencia'],  // Ciudades
            [20, 15, 10],                         // Reservas por ciudad
        ];
    
        // Matriz 3: Estados de Reservas
        $statusData = [
            ['Pendiente', 'Confirmado', 'Cancelado'], // Estados
            [10, 30, 15],                             // Cantidad por estado
        ];
    
        // Pasar los datos a la vista
        return view('admin.panel', compact('salesData', 'reservationsData', 'statusData'));
    }


    

    public function users(Request $request)
    {
        // Inicializa las consultas de Booking y File
        $bookingQuery = Booking::query();
        $fileQuery = File::query();
    
        $isFiltered = $request->filled('searchQuery') || $request->filled('startDate') || $request->filled('endDate');
    
        if ($isFiltered) {
            // Aplica filtros si se reciben en el request por name, email, phone, short_id, dni, filename
            if ($request->filled('searchQuery') && strlen($request->searchQuery) >= 3) {
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
    
            // Aplica filtros por fecha si están presentes
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
        } else {
            // Limita a los primeros 50 registros si no hay filtros
            $bookingQuery->limit(50);
            $fileQuery->limit(50);
        }
    
        // Obtén los registros filtrados
        $bookings = $bookingQuery->get();
        $files = $fileQuery->get();
    
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
        });
    
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
        });
    
        // Unifica ambas colecciones bajo una sola
        $mergedData = $listaFront->merge($filesMapped);
    
        // Pagina la colección combinada manualmente
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10; // Cambia este valor según el número de elementos que quieras por página
        $currentItems = $mergedData->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedData = new LengthAwarePaginator(
            $currentItems,
            $mergedData->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    
        return view('admin.users.index', compact('paginatedData'));
    }
    









    public function _usersusers(Request $request)
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

        // Obtén los registros paginados filtrados de cada tabla
        $bookings = $bookingQuery->paginate(50);
        $files = $fileQuery->paginate(50);

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
        });

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
        });

        // Unifica ambas colecciones bajo una sola
        $mergedData = $listaFront->merge($filesMapped);

        // Pagina la colección combinada manualmente
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10; // Cambia este valor según el número de elementos que quieras por página
        $currentItems = $mergedData->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedData = new LengthAwarePaginator(
            $currentItems,
            $mergedData->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('admin.users.index', compact('paginatedData'));
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
        // Verificar si no hay datos para filtrar (parámetros vacíos)
        if (!$request->has(['startDate', 'endDate'])) {
            return view('admin.emails.index', [
                'clientEmails' => [],
                'emailTemplates' => [],
            ]);
        }
    
        // Obtener el rango de fechas
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
    
        $emailTemplates = EmailTemplate::where('deleted', false)->get();
    
        // Obtener correos electrónicos únicos del modelo Booking en el rango de fechas
        $bookingEmails = Booking::whereBetween('date_booking', [$startDate, $endDate])
            ->pluck('client_email')
            ->filter(function ($email) {
                return $email && trim($email) !== "" && !str_ends_with(trim($email), '@reply.getyourguide.com');
            })
            ->unique()
            ->toArray();
    
        // Obtener correos electrónicos únicos del modelo File en el rango de fechas
        $fileEmails = File::whereBetween('date_booking', [$startDate, $endDate])
            ->pluck('client_email')
            ->filter(function ($email) {
                return $email && trim($email) !== "";
            })
            ->unique()
            ->toArray();
    
        // Combinar ambas listas de correos eliminando duplicados
        $clientEmails = array_unique(array_merge($bookingEmails, $fileEmails));
    
        // Pasar los datos a la vista
        return view('admin.emails.index', compact('clientEmails', 'emailTemplates'));
    }
    
    public function send(Request $request)
    {
        // Devolver un error 403 Forbidden mientras ajustas el controlador
        abort(403, 'Funcionalidad no disponible. Pongase en contacto con el equipo de desarrollo edvard@navegatel.es www.edvardks.com.');


        // Obtener datos del formulario
        $recipients = explode(',', $request->input('to'));
        $subject = $request->input('subject');
        $body = $request->input('body');
        $attachments = $request->file('attachments', []);
    
        $varControl = 0;

        // Segundo control de seguridad para evitar lanzar los correos electrónicos
        dd($recipients);
        foreach ($recipients as $email) {
            try {
                // Enviar correo
                Mail::html($body, function ($message) use ($email, $subject, $attachments) {
                    $message->to(trim($email))
                            ->subject($subject);
    
                    // Adjuntar archivos
                    foreach ($attachments as $file) {
                        $message->attach($file->getRealPath(), [
                            'as' => $file->getClientOriginalName(),
                            'mime' => $file->getMimeType(),
                        ]);
                    }
                });
    
                \Log::info("Correo enviado a {$email} exitosamente.");
                $varControl++;
    
                // Pausar cada 5 correos
                if ($varControl % 5 == 0) {
                    sleep(30); // Pausa de 30 segundos cada 5 correos
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
