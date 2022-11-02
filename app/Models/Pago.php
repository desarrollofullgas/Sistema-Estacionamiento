<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $fillable =['monto','user_id','cotizacion_id'];

    protected $table ='pagos';

    public function cotizacion()
    {
    	return $this->belongsTo(Cotizacion::class);
    }
}
