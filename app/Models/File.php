<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'client_name',       // Cambiado para coincidir
        'dni',
        'client_email',      // Cambiado para coincidir
        'client_phone',      // Cambiado para coincidir
        'date_booking',      // Cambiado para coincidir
        'anyoNacimiento',
        'short_id',       
        'client_kind',
        'email_news',  
    ];
    
}
