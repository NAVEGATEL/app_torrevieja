<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_id', 'product_name', 'supplier_company_name', 'seller_company_name',
        'language_code', 'location', 'service_flow', 'date_event', 'date_prebooking',
        'date_booking', 'date_modified', 'client_name', 'client_phone', 'client_email',
        'currency', 'total_price', 'payment_partial', 'ticket_type_count',
        'payment_transaction', 'status', 'source',
    ];

    protected $casts = [
        'ticket_type_count' => 'array',
        'payment_transaction' => 'array',
        'date_event' => 'datetime',
        'date_prebooking' => 'datetime',
        'date_booking' => 'datetime',
        'date_modified' => 'datetime',
    ];
}
