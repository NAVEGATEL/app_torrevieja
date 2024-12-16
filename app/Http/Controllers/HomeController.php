<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;  

use App\Models\Booking;  
use App\Models\EmailTemplate;

use App\Http\Controllers\BookingController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // Recupera 15 registros por página
        $bookings = Booking::paginate(15);
         
        return view('admin.panel', compact('bookings'));
    }

    


    public function users(Request $request)
    {
        $activities = Booking::pluck('product_name')->unique()->toArray();


        $query = Booking::query();
    
        // Filtro por búsqueda escrita
        if ($request->filled('searchQuery')) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('client_name', 'like', '%' . $request->searchQuery . '%')
                         ->orWhere('client_email', 'like', '%' . $request->searchQuery . '%')
                         ->orWhere('client_phone', 'like', '%' . $request->searchQuery . '%');
            });
        }
    
        // Filtro por actividad
        if ($request->filled('activityFilter')) {
            $query->where('product_name', $request->activityFilter);
        }
    
        // Filtro por fechas
        if ($request->filled('startDate')) {
            if ($request->filled('exactDate')) {
                $query->whereDate('date_event', $request->startDate);
            } elseif ($request->filled('endDate')) {
                $query->whereBetween('date_event', [$request->startDate, $request->endDate]);
            } else {
                $query->whereDate('date_event', '>=', $request->startDate);
            }
        }
        // Excluir clientes con nombre "N/A"
        $query->where('client_name', '!=', 'N/A');
        // Paginación de resultados
        $bookings = $query->paginate(74);
    
        return view('admin.users.index', compact('bookings', 'activities'));
    }
    








    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function emails(Request $request)
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
    
    

    
    // public function upload(Request $request)
    // {
    //     // Valida que se haya enviado un archivo
    //     $request->validate([
    //         'upload' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
    //     ]);

    //     // Guarda la imagen en la carpeta public con un nombre único
    //     $path = $request->file('upload')->store('images', 'public');
        
    //     // Construye la URL completa al archivo
    //     $url = asset('storage/' . $path);

    //     // Retorna la respuesta en el formato que CKEditor espera
    //     return response()->json([
    //         'url' => $url
    //     ]);
    // }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        // Recupera 15 registros por página
        $bookings = Booking::paginate(15);
         
        return view('admin.settings.index', compact('bookings'));
    }
}
