<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Renta;
use Illuminate\Support\Facades\DB;
use App\Traits\Calc;


class ExtraviadosController extends Component
{
	use WithPagination;
	use Calc;

	public $search;
	

	public function render()
	{

		if(strlen($this->search) > 0)
		{
			$rentas = Renta::leftjoin('tarifas as t', 't.id', 'rentas.tarifa_id')
			->leftjoin('users as u', 'u.id', 'rentas.user_id')
			->select('rentas.*', 't.costo as tarifa','t.descripcion as vehiculo', 'u.name as usuario',DB::RAW("0 as pago"))
			->where('estatus','ABIERTO')->where('rentas.descripcion', 'like', "%". $this->search ."%")->where('vehiculo_id',null)
			// ->orderBy('id','desc')
			->paginate(10);
		}
		else {
			$rentas = Renta::leftjoin('tarifas as t', 't.id', 'rentas.tarifa_id')
			->leftjoin('users as u', 'u.id', 'rentas.user_id')
			->select('rentas.*', 't.costo as tarifa','t.descripcion as vehiculo', 'u.name as usuario',DB::RAW("0 as pago"))
			->where('estatus','ABIERTO')->where('vehiculo_id',null)
			// ->orderBy('id','desc')
			->paginate(10);
		}

		foreach ($rentas as $r) {
			$total= $this->DameTotal($r->acceso, $r->tarifa_id);			
			$r->pago = number_format($total,2);
		}

		return view('livewire.extraviados.component',
			['info' => $rentas ]
		);

	}

	public function updatingSearch()
	{
		$this->gotoPage(1);
	}

	protected $listeners = [ 
		'doCheckOut' => 'SalidaVehiculo'
	];

	
	public function SalidaVehiculo($barcode)
	{		
		$this->Salidas($barcode, 'multa por ticket extraviado $50.00');	
	}


}
