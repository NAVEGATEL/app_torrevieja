<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;  
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

use Carbon\Carbon;

use App\Services\UserDataService;
use App\Models\Booking;  
use App\Models\EmailTemplate;
use App\Models\File;
use App\Http\Controllers\BookingController;

class HomeController extends Controller
{
    private function getSelectedYear(Request $request)
    {
        // Obtener el año seleccionado o el actual (si no se pasa el parámetro 'year')
        return $request->input('year', Carbon::now()->year);
    }

    private function getYears()
    {
        // Obtener los años con reservas, asegurando que el año mínimo sea 2014
        return Booking::selectRaw('YEAR(date_booking) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->push(2014) // Agregar 2014 como mínimo
            ->unique() // Eliminar duplicados
            ->sortDesc(); // Ordenar de manera descendente
    }

    private function getSalesDataByMonth($years)
    {
        $salesData = [];
    
        // Datos de ventas sin fecha (N/A)
        $missingData = Booking::whereNull('date_booking')->sum('total_price'); // Total de ventas sin fecha
        $salesData['N/A'] = [
            ['N/A'],
            [$missingData] // Agregar los datos de "N/A"
        ];
    
        foreach ($years as $year) {
            $sales = Booking::selectRaw('MONTH(date_booking) as month, SUM(total_price) as total_sales')
                ->whereYear('date_booking', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->map(function ($item) {
                    return [
                        'month' => $item->month,
                        'total_sales' => $item->total_sales,
                    ];
                });
    
            // Generar matriz para el año
            $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            $salesMatrix = [
                $months,
                array_map(function ($monthIndex) use ($sales) {
                    $data = $sales->firstWhere('month', $monthIndex + 1);
                    return $data ? $data['total_sales'] : 0;
                }, range(0, 11)),
            ];
    
            $salesData[$year] = $salesMatrix;
        }
    
        return $salesData;
    }

    private function getReservationsByMonth($years)
    {
        $reservationsData = [];
        
        // Contamos las reservas sin fecha y las distribuimos por mes como 0 si no hay dato
        $missingReservations = Booking::whereNull('date_booking')->count();
        $reservationsData['N/A'] = [
            ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            array_fill(0, 12, $missingReservations)  // Asignamos las reservas sin fecha a todos los meses
        ];

        foreach ($years as $year) {
            // Contamos las reservas por mes para el año
            $monthlyReservations = Booking::selectRaw('MONTH(date_booking) as month, COUNT(*) as total_reservations')
                ->whereYear('date_booking', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->map(function ($item) {
                    return [
                        'month' => $item->month,
                        'total_reservations' => $item->total_reservations,
                    ];
                });

            // Generar matriz para el año
            $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            $reservationsMatrix = [
                $months,
                array_map(function ($monthIndex) use ($monthlyReservations) {
                    $data = $monthlyReservations->firstWhere('month', $monthIndex + 1);
                    return $data ? $data['total_reservations'] : 0;
                }, range(0, 11)),
            ];

            $reservationsData[$year] = $reservationsMatrix;
        }

        return $reservationsData;
    }

    private function getCantidadActividades()
    {
        // Obtener las actividades y contar cuántas veces se ha realizado cada tipo de actividad
        $statusData = Booking::select('product_name', DB::raw('count(*) as total'))
            ->groupBy('product_name')  // Agrupar por el tipo de actividad (product_name)
            ->get();
    
        // Formatear los datos para enviarlos a la vista
        $activityTypes = $statusData->pluck('product_name')->toArray();  // Tipos de actividades (product_name)
        $activityCounts = $statusData->pluck('total')->toArray();  // Cantidades de actividades realizadas
    
        // Decodificar las entidades HTML en los nombres de actividades
        $activityTypes = array_map('html_entity_decode', $activityTypes);
    
        // Retornar los datos de actividades
        return [$activityTypes, $activityCounts];
    }
   
    public function index(Request $request)
    {
        // Paso 1: Obtener el año seleccionado o el actual
        $selectedYear = $this->getSelectedYear($request);
    
        // Paso 2: Obtener los años disponibles para las gráficas
        $years = $this->getYears();
    
        // Paso 3: Obtener los datos de ventas por mes
        $salesData = $this->getSalesDataByMonth($years);
    
        // Paso 4: Obtener las reservas por ciudad
        $reservationsData = $this->getReservationsByMonth($years);
    
        // Paso 5: Obtener los estados de las reservas
        $statusData = $this->getCantidadActividades();
    
        // Paso 6: Pasar los datos a la vista
        return view('admin.panel', compact('salesData', 'reservationsData', 'statusData', 'years', 'selectedYear'));
    }
    
    public function users(Request $request)
    {
        // Inicializa las consultas de Booking y File
        $bookingQuery = Booking::query();
        $fileQuery = File::query();
        
        $isFiltered = $request->filled('searchQuery') || $request->filled('startDate') || $request->filled('endDate');
    
        if ($isFiltered) {
            // Filtros de búsqueda
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
    
            // Filtros por fecha
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
            // Limitar a los primeros 50 registros sin filtros
            $bookingQuery->limit(997);
            $fileQuery->limit(997); 
        }
    
        $bookingQuery->whereNotNull('date_booking');
        $fileQuery->whereNotNull('date_booking');
        // Obtén los registros
        $bookings = $bookingQuery->get();
        $files = $fileQuery->get();
    
        $listaFront = collect($bookings)->map(function ($booking) {
            if (is_object($booking)) {
                return [
                    'client_name' => $booking->client_name,
                    'client_email' => $booking->client_email,
                    'client_phone' => $booking->client_phone,
                    'client_kind' => $booking->client_kind,
                    'short_id' => $booking->short_id,
                    'date_booking' => $booking->date_booking,
                ];
            }
        })->filter();
        
        $filesMapped = collect($files)->filter(fn($file) => is_object($file))->map(function ($file) {
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
        
        // Unir las colecciones
        $mergedData = $listaFront->merge($filesMapped);
    
        // Ordenar por fecha y realizar paginación manual
        $mergedData = $mergedData->sortByDesc('date_booking');
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 50; // Cambia según tus necesidades
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
