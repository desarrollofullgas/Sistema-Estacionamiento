<?php

namespace App\Http\Livewire;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Livewire\Component;
use Livewire\WithPagination;
use App\Cotizacion;
use Carbon\Carbon;
use App\Pago;
use App\Empresa;
use DB;

class CotizacionesController extends Component
{
	use WithPagination;

	public $titular,$descripcion,$salida,$regreso,$adultos=0,$infantes=0,$menores=0,$total=0,$anticipo=0,$estatus;
	public $search,  $action = 1, $selected_id, $pagos, $abono, $coti_id; 
	private $pagination = 5;        


	public function render()
	{
		//$this->PrintCoti(1);
		$info = null;

		if(strlen($this->search) > 0){
			$info = Cotizacion::select('*', DB::RAW("0 as debe"))
			->where('titular', 'like', '%' .  $this->search . '%')
			->orWhere('descripcion', 'like', '%' .  $this->search . '%')
			->paginate($this->pagination);
		}
		else {
			$info = Cotizacion::select('*', DB::RAW("0 as debe"))
			->orderBy('id','desc')
			->paginate($this->pagination);

		}

		foreach ($info as $c) {
			$pagos = Pago::where('cotizacion_id', $c->id)->sum('monto');
			$c->debe = $c->total - $pagos;
		}

		return view('livewire.cotizaciones.component', ['info' => $info ]);
	}


	public $listeners = [
		'getPays' => 'getPays',
		'RegisterPay' => 'RegisterPay'
	];

	public function getPays($id)
	{
		$this->pagos = Pago::where('cotizacion_id', $id)->select('*')->get();
		$this->emit('paysLoaded','Pagos cargados');
	}


	public function RegisterPay($coti_id, $monto)
	{
		$pay = Pago::create([
			'monto' => $monto,
			'cotizacion_id' => $coti_id,
			'user_id' => auth()->user()->id
		]);

		$pagos = Pago::where('cotizacion_id', $coti_id)->sum('monto');
		$coti = Cotizacion::find($coti_id);
		
		if($pagos >= $coti->total) {
			$coti->estatus = 'Pagada';
			$coti->save();
		}


		$this->emit('pay-ok','Pago registrado correctamente');
		$this->PrintPay($pay->id);


	}

	public function doAction($action)
	{
        $this->resetInput();
		$this->action = $action;

	}

	public function Store()
	{   	

		$this->validate([
			'titular' => 'required',
			'descripcion' => 'required',
			'salida' => 'required',
			'regreso' => 'required',
			'total' => 'required|gt:0',
			'adultos' => 'required|gt:0'
		]);


		$coti = Cotizacion::create([
			'titular' => $this->titular,
			'descripcion' => $this->descripcion,
			'salida' => $this->salida,
			'regreso' => $this->regreso,
			'adultos' => $this->adultos,
			'menores' => $this->menores,
			'infantes' => $this->infantes,
			'total' => $this->total,
			'anticipo' => $this->anticipo,
			'estatus' => $this->estatus,
		]);

		if($coti) {
			if($coti->anticipo > 0) {
				$pay = Pago::create([
					'monto' => $coti->anticipo,
					'cotizacion_id' => $coti->id,
					'user_id' => auth()->user()->id
				]);

			}
		}

		$this->resetInput();
		$this->emit('msg-ok','Cotización registrada con éxito');
		$this->PrintCoti($coti->id);



	}

	public function Update()
	{   	

		$this->validate([
			'titular' => 'required',
			'descripcion' => 'required',
			'salida' => 'required',
			'regreso' => 'required',
			'total' => 'required|gt:0',
			'adultos' => 'required|gt:0'
		]);


		$coti = Cotizacion::find($this->selected_id);		
		$coti->titular = $this->titular;
		$coti->descripcion = $this->descripcion;
		$coti->salida = $this->salida;
		$coti->regreso = $this->regreso;
		$coti->adultos = $this->adultos;
		$coti->menores = $this->menores;
		$coti->infantes = $this->infantes;
		$coti->total = $this->total;
		$coti->anticipo = $this->anticipo;
		$coti->estatus = $this->estatus;
		$coti->save();


/*
		if($coti) {
			if($coti->anticipo > 0) {
				$pay = Pago::create([
					'monto' => $coti->anticipo,
					'cotizacion_id' => $coti->id,
					'user_id' => auth()->user()->id
				]);

			}
		}
*/
		$this->resetInput();
		$this->emit('msg-ok','Cotización actualizada con éxito');



	}


	public function edit($id)
	{
		$record = Cotizacion::find($id);
		$this->selected_id = $id;
		$this->descripcion = $record->descripcion;
		$this->titular = $record->titular;
		$this->adultos = $record->adultos;        
		$this->menores = $record->menores;        
		$this->infantes = $record->infantes;        
		$this->salida = $record->salida;        
		$this->regreso = $record->regreso;        
		$this->total = $record->total;        
		$this->estatus = $record->estatus;        
		$this->anticipo = $record->anticipo;        
		$this->action = 2;

	}


	private function resetInput()
	{
		$this->estatus = 'Pendiente';
		$this->descripcion = '';
		$this->titular = '';
		$this->salida = '';
		$this->regreso = '';
		$this->adultos = 0;       
		$this->menores = 0;       
		$this->infantes = 0;       
		$this->total = 0;       
		$this->anticipo = 0;       
		$this->selected_id = null;       
		$this->action = 1;
		$this->search = '';
	}



	//METODOS DE IMPRESIONES
	public function PrintPay($payId)
	{
		$nombreImpresora = "eQual";
		$connector = new WindowsPrintConnector($nombreImpresora);
		$impresora = new Printer($connector);

		$coti = Pago::leftjoin('cotizaciones as c', 'c.id', 'pagos.cotizacion_id')
					->select('c.id as cotizacion_id','c.total','pagos.monto')
					->where('pagos.id', $payId)->first();

		$empresa = Empresa::all();
		
		$totalPagos = Pago::where('cotizacion_id', $coti->cotizacion_id)->sum('monto');
	

		$debe = $coti->total - $totalPagos;
		

		$impresora->setJustification(Printer::JUSTIFY_CENTER);
		$impresora->setTextSize(2,2);    	
		$impresora->text("ESTACIONAMIENTO\n Y PENSIÓN PLAZA \n");
		$impresora->setTextSize(1,1);
		$impresora->text($empresa[0]->direccion . "\n");
		$impresora->text("Teléfono:". $empresa[0]->telefono ."\n");
		$impresora->text("** Recibo de Pago ** \n");

		$impresora->setJustification(Printer::JUSTIFY_LEFT);
		$impresora->text("================================\n");
		$impresora->text("Cotizacion #: ". $coti->cotizacion_id . "\n");
		$impresora->text("Folio Pago #: ". $payId . "\n");
		$impresora->text("Fecha de Pago: ". Carbon::today()->format('d/m/Y') . "\n");

		$impresora->text("--------------------\n");
		$impresora->text("Total: $". number_format($coti->total,2) . "\n" );
		$impresora->text("Abono: $". number_format($coti->monto,2) . "\n" );
		$impresora->text("Debe: $". number_format($debe,2) . "\n" );		
		$impresora->text("================================\n");

		$impresora->feed(2);
		$impresora->setJustification(Printer::JUSTIFY_CENTER);
		$impresora->text("Gracias por su pago \n");

		$impresora->feed(3);
		$impresora->cut();
		$impresora->close();

	}

	public function PrintCoti($cotiId)
	{
		$nombreImpresora = "eQual";
		$connector = new WindowsPrintConnector($nombreImpresora);
		$impresora = new Printer($connector);

		$coti = Cotizacion::find($cotiId);
		$empresa = Empresa::all();

		$totalPagos = Pago::where('cotizacion_id', $cotiId)->sum('monto');	

		$debe = $coti->total - $totalPagos;
		

		$impresora->setJustification(Printer::JUSTIFY_CENTER);
		$impresora->setTextSize(2,2);    	
		$impresora->text("ESTACIONAMIENTO\n Y PENSIÓN PLAZA \n");
		$impresora->setTextSize(1,1);
		$impresora->text($empresa[0]->direccion . "\n");
		$impresora->text("Teléfono:". $empresa[0]->telefono ."\n");
		$impresora->text("** Cotización ** \n\n");

		$impresora->setJustification(Printer::JUSTIFY_LEFT);
		//$impresora->text("================================\n");
		$impresora->text("Folio : ". $coti->id . "\n");
		$impresora->text("Estatus : ". $coti->estatus . "\n");
		$impresora->text("Cliente : ". $coti->titular . "\n");

		$impresora->text("================================\n");
		$impresora->text($coti->descripcion . "\n");
		$impresora->text("================================\n\n");

		$impresora->text("Salida: ". Carbon::parse($coti->salida)->format('d/m/Y') . "\n");
		$impresora->text("Regreso: ".Carbon::parse($coti->regreso)->format('d/m/Y') . "\n");
		$impresora->text("Adultos: ". $coti->adultos . "\n");
		$impresora->text("Menores: ". $coti->menores . "\n");
		$impresora->text("Infantes: ". $coti->infantes . "\n");

		$impresora->text("Total: $". number_format($coti->total,2) . "\n" );
		$impresora->text("Anticipo: $". number_format($coti->anticipo,2) . "\n" );
		$impresora->text("Debe: $". number_format($debe,2) . "\n" );		
		//$impresora->text("================================\n");

		$impresora->feed(2);
		$impresora->setJustification(Printer::JUSTIFY_CENTER);
		$impresora->text("Gracias por su preferencia \n");

		$impresora->feed(4);
		$impresora->cut();
		$impresora->close();


	}


}
