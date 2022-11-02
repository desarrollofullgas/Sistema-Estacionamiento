<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    public function tarifa()
    {
    	return $this->belongsTo(Tarifa::class, 'tipo_id');
    }

    public function cajon()
    {
    	return $this->belongsTo(Cajon::class, 'tipo_id');
    }
}
