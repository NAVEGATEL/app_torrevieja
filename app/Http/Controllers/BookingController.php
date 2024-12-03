<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

}
