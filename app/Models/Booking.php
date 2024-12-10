<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings'; // Nombre de la tabla en la base de datos

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array
     */
    protected $fillable = [
        'short_id',
        'product_name',
        'supplier_company_name',
        'seller_company_name',
        'language_code',
        'location',
        'service_flow',
        'date_event',
        'date_prebooking',
        'date_booking',
        'date_modified',
        'date_enjoyed',

        'client_name',
        'client_phone',
        'client_email',
        'client_id',
        'client_status',
        
        'currency',
        'total_price',
        'payment_partial',
        'ticket_type_count',
        'payment_transaction',
        'status',
        'source',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'date_event' => 'datetime',
        'date_prebooking' => 'datetime',
        'date_booking' => 'datetime',
        'date_modified' => 'datetime',
        'date_enjoyed' => 'datetime',
        'total_price' => 'decimal:2',
        'payment_partial' => 'decimal:2',
        'ticket_type_count' => 'array',
        'payment_transaction' => 'array',
    ];
}
