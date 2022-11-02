<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    protected $fillable = ['descripcion','salida','regreso','adultos','menores','infantes','total','anticipo','estatus','titular'];

    protected $table ='cotizaciones';


    public function pagos()
    {
    	return $this->hasMany(Pago::class);
    }
}
