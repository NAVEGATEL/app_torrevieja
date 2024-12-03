<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $filable = ['name','description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
