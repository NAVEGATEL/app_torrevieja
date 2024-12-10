<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BookingController;
use App\Models\Booking; // Importa el modelo correctamente
use Illuminate\Support\Collection;


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
    
        // Paginación de resultados
        $bookings = $query->paginate(74);
    
        return view('admin.users.index', compact('bookings', 'activities'));
    }
    








    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function emails()
    {
        // Recupera 15 registros por página
        $bookings = Booking::paginate(15);
         
        return view('admin.emails.index', compact('bookings'));
    }
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
