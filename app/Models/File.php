<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'nombre_cliente',
        'dni',
        'email',
        'telefono',
        'fechaFirma',
        'anyoNacimiento',
        'short_id',       
        'client_kind',
        'email_news'  
    ];
}
