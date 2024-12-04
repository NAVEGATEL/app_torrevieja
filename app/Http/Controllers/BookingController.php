<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Importa el modelo correctamente
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Crear una reserva individual.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'short_id' => 'required|string|unique:bookings',
            'product_name' => 'nullable|string',
            'supplier_company_name' => 'nullable|string',
            'seller_company_name' => 'nullable|string',
            'language_code' => 'nullable|string',
            'location' => 'nullable|string',
            'service_flow' => 'nullable|string',
            'date_event' => 'nullable|date',
            'date_prebooking' => 'nullable|date',
            'date_booking' => 'nullable|date',
            'date_modified' => 'nullable|date',
            'date_enjoyed' => 'nullable|date',
            'client_name' => 'nullable|string',
            'client_phone' => 'nullable|string',
            'client_email' => 'nullable|string',
            'client_id' => 'nullable|string', // Campo nuevo
            'currency' => 'nullable|string',
            'total_price' => 'nullable|numeric',
            'payment_partial' => 'nullable|numeric',
            'ticket_type_count' => 'nullable|array',
            'payment_transaction' => 'nullable|array',
            'status' => 'nullable|string',
            'source' => 'nullable|string',
        ]);

        $validatedData['location'] = $validatedData['location'] ?? 'N/A'; // Valor predeterminado para `location`

        $booking = Booking::create($validatedData);

        return response()->json(['success' => true, 'data' => $booking]);
    }

    /**
     * Crear reservas en lote.
     */
    public function storeBatch(Request $request)
    {
        try {
            $bookings = $request->input('bookings', []);

            foreach ($bookings as &$booking) {
                // Validar y asignar valores predeterminados
                $booking['location'] = isset($booking['location']) && !empty($booking['location']) ? trim($booking['location']) : 'N/A';
                $booking['client_id'] = $booking['client_id'] ?? null; // Valor predeterminado para `client_id`
                $booking['ticket_type_count'] = $booking['ticket_type_count'] ?? [];
                $booking['payment_transaction'] = $booking['payment_transaction'] ?? [];
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
            Log::error('Error guardando reservas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar reservas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
