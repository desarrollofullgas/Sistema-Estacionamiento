<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Renta;
use Carbon\Carbon;

class VentasPorFecha extends Component
{
	public $fecha_ini, $fecha_fin;

	
   
    public function render()
    {
    	
    	$fi = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
    	$ff = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';

    	if($this->fecha_ini !== '')
    	{
    		$fi = Carbon::parse($this->fecha_ini)->format('Y-m-d').' 00:00:00';
    		$ff = Carbon::parse($this->fecha_fin)->format('Y-m-d').' 23:59:59';
    	}

    	
		$ventas = Renta::leftjoin('tarifas as t', 't.id', 'rentas.tarifa_id')
					->leftjoin('users as u', 'u.id', 'rentas.user_id')
					->select('rentas.*', 't.costo as tarifa','t.descripcion as vehiculo', 'u.name as usuario')
					->whereBetween('rentas.created_at',[$fi , $ff ])
					->paginate();


        $total = Renta::whereBetween('rentas.created_at',[$fi , $ff ])->where('estatus','CERRADO')->sum('total');
	

        return view('livewire.reportes.ventas-por-fecha',[
        	'info' => $ventas,
        	'sumaTotal' => $total
        ]);
    }


   
   
    



}
