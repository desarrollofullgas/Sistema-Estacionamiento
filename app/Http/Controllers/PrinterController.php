<?php

namespace App\Http\Controllers;

use App\Http\Livewire\RentaController;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Renta;
use App\Models\Tarifa;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Caja;
use App\Models\ClienteVehiculo;
use PDO;

class PrinterController extends Controller
{
	// public function TicketVista_Original(Request $request)
	// {
	// 	$folio = str_pad($request->id,13,"0", STR_PAD_LEFT);
	// 	$nombreImpresora = "TM20";
	// 	$connector = new WindowsPrintConnector($nombreImpresora);
	// 	$printer = new Printer($connector);

	// 	$empresa = Empresa::all();
	// 	$renta = Renta::find($request->id);
	// 	$tarifa = Tarifa::find($renta->tarifa_id);

	// 	//$nombreImpresora = "OrdersPrinter";
	// 	$connector = new WindowsPrintConnector($nombreImpresora);
	// 	$impresora = new Printer($connector);
	// 	$impresora->setJustification(Printer::JUSTIFY_CENTER);
	// 	$impresora->setTextSize(2, 2);
	// 	//$logo = EscposImage::load("img/logo/logo255.png", false);
	// 	//$impresora -> graphics($logo);
	// 	//$impresora->text($empresa[0]->nombre . "\n");
	// 	$impresora->text("ESTACIONAMIENTO\n FULLGAS\n");
	// 	$impresora->setTextSize(1, 1);
	// 	$impresora->text("$empresa->direccion \n");
	// 	$impresora->text("Teléfono: $empresa->telefono \n");
	// 	$impresora->text("** Recibo de Renta ** \n\n");

	// 	$impresora->setJustification(Printer::JUSTIFY_LEFT);		
	// 	$impresora->text("=============================================\n");
	// 	$impresora->text("Entrada: ". Carbon::parse($renta->created_at)->format('d/m/Y h:m:s') ."\n");
	// 	$impresora->text("Tarifa por hora: $". number_format($tarifa->costo,2) ." \n");				
	// 	if(!empty($renta->descripcion)) $impresora->text('Desc: '. $renta->descripcion ." \n");				
	// 	$impresora->text("=============================================\n");	

	// 	$impresora->setJustification(Printer::JUSTIFY_CENTER);
	// 	$impresora->text("Por favor conservar el ticket hasta el pago, en caso de extravio se pagará una multa de $50\n\n");

	// 	//barcode
	// 	$impresora->setJustification(Printer::JUSTIFY_CENTER);
	// 	$impresora->setBarcodeHeight(70);
	// 	$impresora->setBarcodeWidth(4);
	// 	$impresora->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);		
	// 	$impresora->selectPrintMode();

	// 	$impresora->text(' '  . "\n");
	// 	$impresora->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW );
	// 	$impresora->barcode($folio, Printer::BARCODE_JAN13);
	// 	$impresora->feed(2);

	// 	$impresora->text("Gracias por su preferencia ! \n");
	// 	$impresora->text("www.fullgas.com\n");
	// 	$impresora->feed(3);
	// 	$impresora->cut();
	// 	$impresora->close();
	// }

	// public function TicketPension(Request $request)
	// {	
	// 	//damos formato al folio con ceros a la izquierda
	// 	$folio = str_pad($request->id,7,"0", STR_PAD_LEFT);
	// 	$nombreImpresora = "TM20"; //nombre impresora
	// 	$connector = new WindowsPrintConnector($nombreImpresora); //creamos instancia del conector en windows
	// 	$printer = new Printer($connector);


	// 	$empresa = Empresa::all();
	// 	$renta = Renta::find($request->id);
	// 	$tarifa = Tarifa::where('tiempo','Mes')->select('costo')->first();
	// 	$cliente = Renta::leftjoin('cliente_vehiculos as cv', 'cv.vehiculo_id','rentas.vehiculo_id')
	// 	->leftjoin('users as u','u.id','cv.user_id')
	// 	->select('u.name')
	// 	->where('rentas.id',$renta->id)
	// 	->first();


	// 	//$nombreImpresora = "OrdersPrinter";
	// 	$connector = new WindowsPrintConnector($nombreImpresora);
	// 	$impresora = new Printer($connector);
	// 	$impresora->setJustification(Printer::JUSTIFY_CENTER);
	// 	$impresora->setTextSize(2, 2);
	// 	//$logo = EscposImage::load("img/logo/logo255.png", false);
	// 	//$impresora -> graphics($logo);
	// 	//$impresora->text($empresa[0]->nombre . "\n");
	// 	$impresora->text(strtoupper($empresa[0]->nombre));
	// 	$impresora->setTextSize(1, 1);
	// 	$impresora->text($empresa[0]->direccion . "\n");
	// 	$impresora->text("Teléfono:". $empresa[0]->telefono ."\n");
	// 	$impresora->text("** Recibo de Pensión ** \n\n");

	// 	$impresora->setJustification(Printer::JUSTIFY_LEFT);		
	// 	$impresora->text("=============================================\n");
	// 	$impresora->text("Cliente: ". $cliente->nombre ."\n");
	// 	$impresora->text("Entrada: ". Carbon::parse($renta->created_at)->format('d/m/Y h:m:s') ."\n");
	// 	$impresora->text("Salida: ". Carbon::parse($renta->salida)->format('d/m/Y h:m:s') ."\n");
	// 	$impresora->text("Tiempo: ". $renta->hours .  ' MES(ES)' ." \n"  );
	// 	$impresora->text("Tarifa: $". number_format($tarifa->costo,2) ." \n");		
	// 	$impresora->text("TOTAL: $". number_format($renta->total,2) ." \n");
	// 	$impresora->text('Placa:'. $renta->placa .' Marca:'. $renta->marca .' Color:'. $renta->color ." \n");
	// 	$impresora->text("=============================================\n");		



	// 	$impresora->setJustification(Printer::JUSTIFY_CENTER);
	// 	$impresora->text("Por favor conservar el ticket hasta el pago, en caso de extravio se pagará una multa de $50\n\n");



	// 	//barcode
	// 	$impresora->selectPrintMode();
	// 	//$impresora->setJustification(Printer::JUSTIFY_CENTER);
	// 	$impresora -> setBarcodeHeight(80);
	// 	$impresora -> barcode($folio, Printer::BARCODE_CODE39);
	// 	$impresora -> feed(2);	


	// 	$impresora->text("¡ Gracias por su preferencia ! \n");
	// 	$impresora->text("www.fullgas.com\n");
	// 	$impresora->feed(3);
	// 	$impresora->cut();
	// 	$impresora->close();
	// }





	// public function TicketVisita(Request $request)
	// {


	// 	$folio = str_pad($request->id,7,"0", STR_PAD_LEFT); //formato folio con ceros a la izquierda
	// 	$nombreImpresora = "EQUAL"; //nombre impresora
	// 	$connector = new WindowsPrintConnector($nombreImpresora); //creamos instancia de conexión a la impresora
	// 	$impresora = new Printer($connector);//le indicamos a la clase de impresión a cuál impresora debe mandarle el ticket

	// 	//obtenemos la info necesaria de la db
	// 	$empresa = Empresa::all();
	// 	$renta = Renta::find($request->id);
	// 	$tarifa = Tarifa::find($renta->tarifa_id);

	// 	//centramos y seteamos el font al nombre del negocio
	// 	$impresora->setJustification(Printer::JUSTIFY_CENTER);
	// 	$impresora->setTextSize(2, 2);		
	// 	$impresora->text(strtoupper($empresa[0]->nombre));
	// 	$impresora->setTextSize(1, 1); 
	// 	$impresora->text($empresa[0]->direccion . "\n");
	// 	$impresora->text("Teléfono:". $empresa[0]->telefono ."\n");
	// 	$impresora->text("** Recibo de Renta ** \n\n");

	// 	//alineamos a la izquierda los siguientes elementos
	// 	$impresora->setJustification(Printer::JUSTIFY_LEFT);		
	// 	$impresora->text("=============================================\n");
	// 	$impresora->text("Entrada: ". Carbon::parse($renta->created_at)->format('d/m/Y h:m:s') ."\n");
	// 	$impresora->text("Tarifa por hora: $". number_format($tarifa->costo,2) ." \n");				
	// 	if(!empty($renta->descripcion)) $impresora->text('Desc: '. $renta->descripcion ." \n");				
	// 	$impresora->text("=============================================\n");

	// 	//alineamos al centro los conceptos finales
	// 	$impresora->setJustification(Printer::JUSTIFY_CENTER);
	// 	$impresora->text("Por favor conservar el ticket hasta el pago, en caso de extravio se pagará una multa de $50\n\n");



	// 	//seteamos el modo de impresión para cambiar el height y width del código de barras
	// 	$impresora->selectPrintMode();
	// 	//$impresora->setJustification(Printer::JUSTIFY_CENTER);
	// 	$impresora -> setBarcodeHeight(80); //altura del barcode
	// 	$impresora -> barcode($folio, Printer::BARCODE_CODE39); //especificamos el estándar code39 (7 dígitos)
	// 	$impresora -> feed(2); // generamos 2 espacios/saltos de linea en papel 	

	// 	//mensaje de despedida
	// 	$impresora->text("¡ Gracias por su preferencia ! \n");
	// 	$impresora->text("www.fullgas.com\n"); //brandind
	// 	$impresora->feed(3); //damos 3 saltos de linea
	// 	$impresora->cut(); //cortamos papel
	// 	$impresora->close(); //cerramos la conexión a la impresora
	// }

	// public function TicketVista2(Request $request)
	// {



	// 	$connector = new WindowsPrintConnector('TM20');
	// 	$printer = new Printer($connector);

	// 	/* Barcodes */
	// 	/*
	// 	$barcodes = array(
	// 		Printer:::BARCODE_UPCA,
	// 		Printer:::BARCODE_UPCE,
	// 		Printer:::BARCODE_JAN13,
	// 		Printer:::BARCODE_JAN8,
	// 		Printer:::BARCODE_CODE39,
	// 		Printer:::BARCODE_ITF,
	// 		Printer:::BARCODE_CODABAR);
	// 	*/
	// 		$printer->selectPrintMode();
	// 		$printer->setJustification(Printer::JUSTIFY_CENTER);
	// 		//$printer -> setBarcodeHeight(80);
	// 		$printer -> barcode("0000007", Printer::BARCODE_CODE39);
	// 		$printer -> feed(2);	
	// 		$printer -> cut();
	// 		$printer -> close();
	// 	}
	/* function genPDF ($id) {
		$fpd=new Fpdf();
		$fpdf->AddPage();
		$fpdf->SetFont('Courier', 'B', 18);
		$f->Output();
		exit;
	pdf->Cell(50, 25, 'Hello World!'.$id.'--------------------------------');
		$fpdf
	}  */ //alt-shif-a

	function InPDF($id)
	{
		$ticket = Renta::where('id', $id)->select('*')->first();
		$pdf = PDF::setPaper('A8');
		return $pdf->loadView('pdfs.vistaEntradaPDF', ['datos' => $ticket])->stream();
	}
	function PDF($id)
	{
		$ticket = Renta::where('id', $id)->select('*')->first();
		$tiempo = $this->CalcularTiempo($ticket->acceso);
		$ticket->hours = $tiempo;
		$tipo = Tarifa::where('id', $ticket->tarifa_id)->first()->tipo_id;
		$ticket->tarifa = Tarifa::where('tipo_id', $tipo)->select('costo', 'tiempo')->get();
		//$pdf = PDF::setPaper('A8');//a8
		$pdf = PDF::setPaper(array(0, 0, 147.40, 309.76));
		return $pdf->loadView('pdfs.vistaPDF', ['datos' => $ticket])->stream(); //download('TICKET'.$ticket->barcode.'.pdf');

	}
	public function CalcularTiempo($fechaEntrada)
	{
		$start  =  Carbon::parse($fechaEntrada);
		$end    = new \DateTime(Carbon::now());
		$tiempo = $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');
		return $tiempo;
	}
	function chartWeek()
	{
		$currentYear =  date("Y");
		//ventas semana actual
		$start = date('Y-m-d', strtotime('monday this week')); //obtenemos el 1er dia de la semana actual
		$finish = date('Y-m-d', strtotime('sunday this week'));  //obtenemos el ultimo dia

		$d1 = strtotime($start); //convertir fecha inicial en formato unix
		$d2 = strtotime($finish);
		$array = array();

		for ($currentDate = $d1; $currentDate <= $d2; $currentDate += (86400)) {
			$dia = date('Y-m-d', $currentDate); //convertimos el dia unix a formato ingles
			$array[] = $dia;
		}

		$sql = "SELECT c.fecha, IFNULL(c.total,0) as total FROM (
		  SELECT '$array[0]' AS fecha 
		  UNION 
		  SELECT '$array[1]' AS fecha 
		  UNION 
		  SELECT '$array[2]' AS fecha 
		  UNION 
		  SELECT '$array[3]' AS fecha 
		  UNION 
		  SELECT '$array[4]' AS fecha
		  UNION
		  SELECT '$array[5]' AS fecha
		  UNION
		  SELECT '$array[6]' AS fecha
		) d
		LEFT JOIN(
		SELECT SUM(total)AS total, DATE(created_At)AS fecha FROM rentas WHERE created_at BETWEEN '$start' AND '$finish' AND estatus ='CERRADO'
		GROUP BY DATE(created_At)
	  )c  ON d.fecha = c.fecha";
		$weekSales = DB::select(DB::raw($sql));

		$url = "https://quickchart.io/chart?c={ 
		type: 'pie', 
		data: { 
				datasets: [ 
					{ data: [" . $weekSales[0]->total . ", " . $weekSales[1]->total . ", " . $weekSales[2]->total . "," . $weekSales[3]->total . "," . $weekSales[4]->total . ", " . $weekSales[5]->total . ", " . $weekSales[6]->total . "],
		backgroundColor: [
		'rgb(253, 159, 179)',
		'rgb(255, 159, 64)',
		'rgb(255, 205, 86)',
		'rgb(75, 192, 192)',
		'rgb(54, 162, 235)',
		'rgb(218, 247, 166)',
		'rgb(181, 241, 164)',
	  ], }, ], 
	  labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes','Sábado','Domingo'], 
	},
 }";
		return $pdf = PDF::loadView('pdfs.vistaChartPDF', ['chart' => $url])->stream();
		//return view('pdfs.vistaChartPDF',['chart' =>$chartVentaSemanal]);
	}
	function chartMonth()
	{
		$currentYear =  date("Y");
		$salesByMonth = DB::select(DB::raw("
		SELECT m.MONTH AS MES, IFNULL(c.ventas,0)AS VENTAS, IFNULL(c.rentas,0) as TRANSACCIONES  FROM(
		SELECT 'January' AS MONTH  UNION  SELECT 'February' AS MONTH 
		UNION   SELECT 'March' AS MONTH  UNION 
		SELECT 'April' AS MONTH  UNION  SELECT 'May' AS MONTH 
		UNION  SELECT 'june' AS MONTH  UNION 
		SELECT 'July' AS MONTH  UNION  SELECT 'August' AS MONTH 
		UNION  SELECT 'September' AS MONTH  UNION 
		SELECT 'October' AS MONTH  UNION  SELECT 'November' AS MONTH 
		UNION  SELECT 'December' AS MONTH 
		)m
		left join(
		SELECT MONTHNAME(acceso) AS MONTH, COUNT(*) AS rentas, SUM(total)AS ventas 
		FROM rentas 
		WHERE YEAR(acceso)=$currentYear
		GROUP BY MONTHNAME(acceso),MONTH(acceso) 
		ORDER BY MONTH(acceso)
		)  c ON m.MONTH =c.MONTH
		"));

		$url = "https://quickchart.io/chart?c={ 
			type: 'line', 
			data: { 
				labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiember', 'Octubre', 'Noviembre', 'Diciembre'], 
				datasets: [ { 
					backgroundColor: 'rgba(0,143,251, 0.5)', 
					borderColor: 'rgb(0,143,251)', 
					data: [" . $salesByMonth[0]->VENTAS . ", " . $salesByMonth[1]->VENTAS . ", " . $salesByMonth[2]->VENTAS . ", "
			. $salesByMonth[3]->VENTAS . ", " . $salesByMonth[4]->VENTAS . "," . $salesByMonth[5]->VENTAS . ","
			. $salesByMonth[6]->VENTAS . "," . $salesByMonth[7]->VENTAS . "," . $salesByMonth[8]->VENTAS . ","
			. $salesByMonth[9]->VENTAS . "," . $salesByMonth[10]->VENTAS . "," . $salesByMonth[11]->VENTAS . "], 
					label: 'Año " . $currentYear . "', fill: 'start', }, ], }, 
					 }";
		return $pdf = PDF::loadView('pdfs.vistaChartPDF', ['chart' => $url])->stream();
	}
	function chartBalanceAnual()
	{
		$currentYear =  date("Y");
		$listVentas;
		for ($i = 0; $i < 12; $i++) {
			$listVentas[$i] = Renta::whereMonth('acceso', $i + 1)->whereYear('acceso', $currentYear)->sum('total');
		}
		$listGastos;
		for ($i = 0; $i < 12; $i++) {
			$listGastos[$i] = Caja::where('tipo', '<>', 'Ingreso')->whereMonth('created_at', $i + 1)->whereYear('created_at', $currentYear)->sum('monto');
		}
		$listBalance;
		for ($i = 0; $i < 12; $i++) {
			$listBalance[$i] = $listVentas[$i] - $listGastos[$i];
		}
			//$url="".$listBalance[0]."---".implode(",",$listBalance);
		; //el array lo pasamos a un estring, cada dato separado por una coma

		$url = "https://quickchart.io/chart?v=2.9.4&c={ 
			type: 'bar', 
			data: { 
				labels: ['Ene', 'Feb', 'Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'], 
				datasets: [ 
					{ label: 'Ventas', data: [" . implode(",", $listVentas) . "],backgroundColor: 'rgb(46,204,113)', }, 
					{ label: 'Gastos', data: [" . implode(",", $listGastos) . "],backgroundColor: 'rgb(231,76,60)' }, 
					{ label: 'Balance', data: [" . implode(",", $listBalance) . "],backgroundColor: 'rgb(0,143,251)' }, 
				], }, 
				options: {
					title: {
					  display: true,
					  text: 'Balance Anual',
					}
				  }}";
		return $pdf = PDF::loadView('pdfs.vistaChartPDF', ['chart' => $url])->stream();
	}

	function ReportDaily()
	{
		//$ticket = Renta::select('*')->whereDate('created_at', Carbon::today())->get();

		$ventas = Renta::leftjoin('tarifas as t', 't.id', 'rentas.tarifa_id')
			->leftjoin('users as u', 'u.id', 'rentas.user_id')
			->select('rentas.*', 't.costo as tarifa', 't.descripcion as vehiculo', 'u.name as usuario')
			->whereDate('rentas.created_at', Carbon::today())
			->get();
		$total = Renta::whereDate('rentas.created_at', Carbon::today())->where('estatus', 'CERRADO')->sum('total');

		//ExReport($data);
		$pdf = PDF::setPaper('a4', 'landscape');
		return $pdf->loadView('pdfs.vistaReportTablePDF', ['datos' => $ventas, 'total' => $total])->stream();
	}
	function ReportDates($date)
	{
		$arrayDates = explode("+", $date);
		$dateIn = $arrayDates[0];
		$dateEnd = $arrayDates[1];
		
		$fi = Carbon::parse(Carbon::now())->format('Y-m-d').' 00:00:00';
    	$ff = Carbon::parse(Carbon::now())->format('Y-m-d').' 23:59:59';

		if ($dateIn !== '') {
			$fi = Carbon::parse($dateIn)->format('Y-m-d') . ' 00:00:00';
		}
		if ($dateEnd !== '') {
			$ff = Carbon::parse($dateEnd)->format('Y-m-d') . ' 23:59:59';
		}

		$ventas = Renta::leftjoin('tarifas as t', 't.id', 'rentas.tarifa_id')
			->leftjoin('users as u', 'u.id', 'rentas.user_id')
			->select('rentas.*', 't.costo as tarifa', 't.descripcion as vehiculo', 'u.name as usuario')
			->whereBetween('rentas.created_at', [$fi, $ff])
			->paginate();
			
		$total = Renta::whereBetween('rentas.created_at', [$fi, $ff])->where('estatus', 'CERRADO')->sum('total');
		$pdf = PDF::setPaper('a4', 'landscape');
		return $pdf->loadView('pdfs.vistaReportTablePDF', ['datos' => $ventas, 'total' => $total])->stream();
	}
	function ReportComming(){
		$info = Renta::leftjoin('vehiculos as v','v.id','rentas.vehiculo_id')
		->leftjoin('cliente_vehiculos as cv','cv.vehiculo_id', 'v.id')
		->leftjoin('users as u','u.id','cv.user_id')        			  
		->where('rentas.vehiculo_id', '>', 0)
		->where('rentas.estatus','ABIERTO')
		->select('rentas.*','u.name as cliente','v.placa','v.modelo','v.marca'/* , 
			DB::RAW("'' as restantemeses "),
			DB::RAW("'' as restantedias "),
			DB::RAW("'' as restantehoras "),
			DB::RAW("'' as restanteyears "),
			DB::RAW("'' as dif "),
			DB::RAW("'' as estado ") */)
		// ->orderBy('rentas.salida','asc')
		->get();

		foreach ($info as $r) {
			$start = Carbon::now(); //::parse($r->acceso);
			$end = Carbon::parse($r->salida);						
			
			if(Carbon::now()->greaterThan($end))  
			{
				$r->estado = "VENCIDO";
				$years =0;
				$months =0;
				$days =0;
				$hours =0;
			}
			else {
				$days = $start->diffInDays($end); 
				$r->estado = ($days > 3 ? "ACTIVO" : "PRÓXIMO");
				$r->dif = Carbon::parse($r->salida)->diffForHumans();
			}
			
			$r->restantedias =  $days;
		}
		$pdf = PDF::setPaper('a4', 'landscape');
		return $pdf->loadView('pdfs.vistaReportCommingPDF', ['info' => $info])->stream();
		//return $info;
	}
	function ticketRenta($name){
		$userID= User::select('id')->where('name',$name)->first()->id;
		$vehiculo= ClienteVehiculo::select('vehiculo_id')->where('user_id',$userID)->first()->vehiculo_id;
		$info = Renta::leftjoin('vehiculos as v','v.id','rentas.vehiculo_id')
		->leftjoin('cliente_vehiculos as cv','cv.vehiculo_id', 'v.id')
		->leftjoin('users as u','u.id','cv.user_id')        			  
		->where('rentas.vehiculo_id',$vehiculo)
		->where('rentas.estatus','ABIERTO')
		->select('rentas.*','u.name as cliente','v.placa','v.modelo','v.marca')
		->orderBy('u.id','desc')
		->first();
		$start = Carbon::parse($info->acceso);
		$end = Carbon::parse($info->salida);
		$days = $start->diffInDays($end);
		$info->meses= $start->diffInMonths($end);
		$info->dias=$days;
		$pdf = PDF::setPaper(array(0, 0, 147.40, 260));
		return $pdf->loadView('pdfs.vistaPDFticketRenta', ['datos' => $info])->stream();	
		//return $info;
	}
	function ReportCommingEnd($data){

		$array=explode('+',$data);
		$id=$array[0];
		$name=$array[1];
		
		$userID= User::select('id')->where('name',$name)->first()->id;
		$vehiculo= ClienteVehiculo::select('vehiculo_id')->where('user_id',$userID)->first()->vehiculo_id;
		$info = Renta::leftjoin('vehiculos as v','v.id','rentas.vehiculo_id')
		->leftjoin('cliente_vehiculos as cv','cv.vehiculo_id', 'v.id')
		->leftjoin('users as u','u.id','cv.user_id')        			  
		->where('rentas.vehiculo_id',$vehiculo)
		->where('rentas.id',$id)
		->where('rentas.estatus','ABIERTO')
		->select('rentas.*','u.name as cliente','v.placa','v.modelo','v.marca')
		->orderBy('u.id','desc')
		->first();
/* 		$start = Carbon::parse($info->acceso);
		$end = Carbon::parse($info->salida);
		$days = $start->diffInDays($end);
		$info->meses= $start->diffInMonths($end);
		$info->dias=$days; */
		$info->finalSalida=Carbon::now()->toDateString();
		$info->horaSalida=Carbon::now()->toTimeString();
		$pdf = PDF::setPaper(array(0, 0, 147.40, 320));
		return $pdf->loadView('pdfs.vistaPDFticketRenta', ['datos' => $info])->stream();
		//return $info;
	}
	/* function ExReport($data){
		return $pdf=PDF::loadView('pdfs.vistaReportTablePDF',['datos' =>$data])->stream();
	} */
}
