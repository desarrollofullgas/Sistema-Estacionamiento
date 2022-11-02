<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Cuenta;
use App\Abono;
use DB;

class CuentasxPagarController extends Component
{
	use WithPagination;

	public $search,$action = 1,$selected_id,$pagos,$operadora,$precioadulto,$preciojr,$preciomenor,$total,$estatus, $sumaTotal;
	private $pagination = 10;   

	public function render()
	{
		if(strlen($this->search) > 0) {
			$info = Cuenta::where('operadora', 'like', '%' . $this->search . '%')->select('*',DB::RAW(" 0 as abonado "),DB::RAW(" 0 as debe "))->paginate($this->pagination);
		}
		else {
			$info = Cuenta::orderBy('id','desc')->select('*',DB::RAW(" 0 as abonado "),DB::RAW(" 0 as debe "))->paginate($this->pagination);
		}

		$totalAbonado = 0;
		foreach ($info as $c) {
			$totalAbonado += $c->abonos()->sum('monto');
		}
		$ctas = Cuenta::sum('total');

		$this->sumaTotal = $ctas - $totalAbonado;

		return view('livewire.cotizaciones.cuentasxpagar',[
			'info' => $info
		]);
	}

	public $listeners = [
		'getPays' => 'getPays',
		'RegisterPay' => 'RegisterPay'
	];


	public function getPays($id)
	{
		$this->pagos = Abono::where('cuenta_id', $id)->select('*')->get();
		$this->emit('paysLoaded','Abonos cargados');
	}


	public function RegisterPay($cuenta_id, $monto)
	{
		if($monto <=0)		{
			$this->emit('msg-error','EL MONTO DEL ABONO ES INCORRECTO');
			return;
		}

		$pay = Abono::create([
			'monto' => $monto,
			'cuenta_id' => $cuenta_id,
			'user_id' => auth()->user()->id
		]);

		$pagos = Abono::where('cuenta_id', $cuenta_id)->sum('monto');
		$cuenta = Cuenta::find($cuenta_id);
		
		if($pagos >= $cuenta->total) {
			$cuenta->estatus = 'Pagado';
			$cuenta->save();
		}


		$this->emit('pay-ok','Abono registrado correctamente');
		//$this->PrintPay($pay->id);


	}

	public function doAction($action)
	{
		$this->resetInput();
		$this->action = $action;

	}



	public function Store()
	{   	

		$this->validate([
			'operadora' => 'required',
			'precioadulto' => 'required|gt:0',
			'preciojr' => 'required',
			'preciomenor' => 'required',
			'total' => 'required|gt:0',
			'estatus' => 'required'
		]);


		$cta = Cuenta::create([
			'operadora' => $this->operadora,
			'precioadulto' => $this->precioadulto,
			'preciojr' => $this->preciojr,
			'preciomenor' => $this->preciomenor,			
			'total' => $this->total,		
			'estatus' => $this->estatus,
		]);

		if($cta) {
			if($cta->anticipo > 0) {
				$pay = Abono::create([
					'monto' => $cta->anticipo,
					'cuenta_id' => $cta->id,
					'user_id' => auth()->user()->id
				]);

			}
		}

		$this->resetInput();
		$this->emit('msg-ok','Cuenta registrada con éxito');
		//$this->PrintCoti($coti->id);



	}

	public function Update()
	{   	
		$this->validate([
			'operadora' => 'required',
			'precioadulto' => 'required|gt:0',
			'preciojr' => 'required|gt:0',
			'preciomenor' => 'required|gt:0',
			'total' => 'required|gt:0',
			'estatus' => 'required'
		]);


		$cta = Cuenta::find($this->selected_id);		
		$cta->operadora = $this->operadora;
		$cta->precioadulto = $this->precioadulto;
		$cta->preciojr = $this->preciojr;
		$cta->preciomenor = $this->preciomenor;			
		$cta->total = $this->total;		
		$cta->estatus = $this->estatus;
		$cta->save();


		$this->resetInput();
		$this->emit('msg-ok','Cuenta actualizada con éxito');



	}


	public function edit($id)
	{
		$record = Cuenta::find($id);
		$this->selected_id = $id;
		$this->operadora = $record->operadora;
		$this->precioadulto = $record->precioadulto;
		$this->preciojr = $record->preciojr;        
		$this->preciomenor = $record->preciomenor;        
		$this->estatus = $record->estatus;  
		$this->total = $record->total;        		
		$this->action = 2;

	}


	private function resetInput()
	{
		$this->estatus = 'Pendiente';
		$this->operadora = '';
		$this->precioadulto = 0;
		$this->preciojr =0;
		$this->preciomenor = 0;	
		$this->total = 0;
		$this->selected_id = null;       
		$this->search = '';
		$this->action = 1;
	}



}
