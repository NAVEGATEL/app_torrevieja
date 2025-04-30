<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class ConsentController extends Controller
{
    public function submit(Request $request)
    {
        return redirect()->back()->with('success', 'Formulario enviado correctamente.');
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

        dd($booking);
        $booking->save();

        return redirect()->back()->with('success', 'Formulario enviado y guardado correctamente.');
    }
}
