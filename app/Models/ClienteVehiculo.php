<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteVehiculo extends Model
{
    use HasFactory;
    protected $table ='cliente_vehiculos';

    protected $fillable =['user_id','vehiculo_id'];
}
