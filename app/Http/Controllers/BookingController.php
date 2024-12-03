<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Importa el modelo correctamente
use Illuminate\Support\Facades\Log;
class BookingController extends Controller
{
    //
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'short_id' => 'required|string|unique:bookings',
            'product_name' => 'required|string',
            'supplier_company_name' => 'required|string',
            'seller_company_name' => 'required|string',
            'language_code' => 'required|string',
            'location' => 'required|string',
            'service_flow' => 'required|string',
            'date_event' => 'nullable|date',
            'date_prebooking' => 'nullable|date',
            'date_booking' => 'nullable|date',
            'date_modified' => 'nullable|date',
            'date_enjoyed' => 'nullable|date',
            'client_name' => 'required|string',
            'client_phone' => 'required|string',
            'client_email' => 'nullable|string',
            'currency' => 'required|string',
            'total_price' => 'required|numeric',
            'payment_partial' => 'required|numeric',
            'ticket_type_count' => 'required|array',
            'payment_transaction' => 'nullable|array',
            'status' => 'required|string',
            'source' => 'required|string',
        ]);

        $booking = Booking::create($validatedData);

        return response()->json(['success' => true, 'data' => $booking]);
    }

    public function storeBatch(Request $request)
    {
        // Log::info($request->all()); // Inspecciona los datos recibidos
        // dd($request->all());        // Detén la ejecución para revisar los datos
        try {
            $bookings = $request->input('bookings', []);
    
            foreach ($bookings as &$booking) {
                // Validar y asignar valores predeterminados
                $booking['location'] = isset($booking['location']) && !empty($booking['location']) ? trim($booking['location']) : 'N/A';

            }
    
            // Inserción en la base de datos
            $saved = 0;
            foreach ($bookings as $booking) {
                $exists = Booking::where('short_id', $booking['short_id'])->exists();
                if (!$exists) {
                    Booking::create($booking);
                    $saved++;
                }
            }
    
            return response()->json([
                'success' => true,
                'message' => "{$saved} reservas guardadas con éxito.",
            ]);
        } catch (\Exception $e) {
            \Log::error('Error guardando reservas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar reservas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    


}
