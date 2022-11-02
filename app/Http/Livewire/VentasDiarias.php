<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Renta;
use Carbon\Carbon;


class VentasDiarias extends Component
{

   protected $paginationTheme = 'bootstrap';

	public $fecha_ini, $fecha_fin;

    public function render()
    {
    	

    	
       $ventas = Renta::leftjoin('tarifas as t', 't.id', 'rentas.tarifa_id')
       ->leftjoin('users as u', 'u.id', 'rentas.user_id')
       ->select('rentas.*', 't.costo as tarifa','t.descripcion as vehiculo', 'u.name as usuario')
       ->whereDate('rentas.created_at', Carbon::today())
    //    ->orderBy('id','desc')
       ->paginate();

       
       $total = Renta::whereDate('rentas.created_at', Carbon::today())->where('estatus','CERRADO')->sum('total');

       return view('livewire.reportes.ventas-diarias',[
           'info' => $ventas,
           'sumaTotal' => $total
       ]);
   }


   public function VentasDelDia()
   {





   }
   public function VentasPorFecha()
   {
    /*
       $fi = Carbon::parse($this->fecha_ini)->format('Y-m-d').' 00:00:00';
       $ff = Carbon::parse($this->fecha_fin)->format('Y-m-d').' 23:59:59';


       $ventas = Renta::whereBetween('created_at',[$fi , $ff ])->get();
*/
   }




}
