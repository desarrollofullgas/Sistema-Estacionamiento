<?php

namespace App\Http\Livewire;

use App\Http\Controllers\PrinterController;
use App\Models\ClienteVehiculo;
use Livewire\Component;
use App\Models\Cajon;
use App\Models\Renta;
use App\Models\Tarifa;
use App\Models\Tipo;
use App\Models\User;
use App\Models\Vehiculo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
//use Config\FPDF;
use Codedge\Fpdf\Fpdf\Fpdf;


class RentaController extends Component
{

	
	//properties
	public  $selected_id, $search,$buscarCliente,$barcode, $obj, $clientes, $clienteSelected,$concepto_multa,$printTicket = 1;
  public  $name,$nombre, $telefono,$celular,$email,$placa,$tipo,$total,$totalCalculado,$tiempo,$direccion,$modelo,$marca,$color,$fecha_ini, $fecha_fin,$nota,$arrayTarifas,$tarifaSelected, $vehiculo_id; //AGREGAR
  private $pagination = 5;    
  public  $section = 1;



//primer metodo que se ejecuta al montarse el componente
  public function mount()
  {
    $this->arrayTarifas = Tarifa::all();
    if($this->arrayTarifas->count() > 0) $this->tarifaSelected = $this->arrayTarifas[0]->id;  
    //$ticket = Renta::where('barcode', '0000185')->select('*')->first();
   //if($ticket->vehiculo_id == null) dd('es null');
  }

  //metodo que se ejecuta después del mount
  public function render()
  {
    $clientes = null;
    $cajones = Cajon::join('tipos as t', 't.id', 'cajons.tipo_id')
    ->select('cajons.*', 'descripcion as tipo','t.id as tipo_id',
      DB::RAW("'' as tarifa_id "), DB::RAW("'' as barcode "), DB::RAW("0 as folio "), DB::RAW("'' as descripcion_coche "))
    ->get();


    //buscar clientes    
    if(strlen($this->buscarCliente) > 0)
    {
      $clientes = ClienteVehiculo::leftjoin('users as u', 'u.id','cliente_vehiculos.user_id')
      ->leftjoin('vehiculos as v', 'v.id', 'cliente_vehiculos.vehiculo_id')
      ->select('v.id as vehiculo_id','v.placa','v.marca','v.color','v.nota','v.modelo','u.id as cliente_id','name','email')
      ->where('name', 'like', '%'. $this->buscarCliente .'%')
      ->get();      
    } 

    else {
     $clientes = User::where('tipo','Cliente')
     ->select('id','name','email',DB::RAW("'' as vehiculos "))
     ->take(1)->get();
   }

    //asignamos a la propiedad clientes el resultado dela búsqueda
   $this->clientes = $clientes;


   foreach ($cajones as $c) 
   {
   $tarifa = Tarifa::where('tipo_id', $c->tipo_id)->select('id')->first();               
  $c->tarifa_id = $tarifa['id'];

    $renta = Renta::where('cajon_id', $c->id)
    ->select('barcode','id','descripcion as descripcion_coche')
    ->where('estatus','ABIERTO')
    // ->orderBy('id','desc')
    ->first();

    $c->barcode = ($renta['barcode'] ?? '');
    //$c->barcode = ($renta['barcode'] == null ? '': $renta['barcode']);
    $c->folio = ($renta['id'] ?? '' );
    //$c->folio = ($renta['id'] == null ? '': $renta['id']);
    $c->descripcion_coche = ($renta['descripcion_coche'] ?? '');
    //$c->descripcion_coche = ($renta['descripcion_coche'] == null ? '': $renta['descripcion_coche']);
  }

  if($this->total == null) {
    $this->totalCalculado = 0;
  } else {
    $this->totalCalculado = $this->total;
  }

  return view('livewire.rentas.component', [
    'cajones' => $cajones
  ]);

}


  //eventos listeners
protected $listeners = [
  'RegistrarEntrada'   => 'RegistrarEntrada',
  'doCheckOut'       => 'doCheckOut',
  'doCheckIn' => 'RegistrarEntrada'
];




  //consulta la información de un ticket
public function doCheckOut($barcode, $section = 2,$tipo)
{        
  $bcode = ($barcode == '' ? $this->barcode : $barcode);
  $obj = Renta::where('barcode',$bcode)->select('*', DB::RAW("'' as tiempo "), DB::RAW("0 as total "))->first();

  if($obj !=null )
  { 
    $this->section = $section;
    $this->barcode = $bcode;

    $start  =  Carbon::parse($obj->acceso);
    $end    = new \DateTime(Carbon::now());   
    $obj->tiempo= $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');//diferencia en horas + dif en min y seg

    $obj->total = $this->calculateTotal($tipo,$obj->acceso, $obj->tarifa_id);
    $this->obj = $obj;
    $this->obj->tipo_id =$tipo;

  }else {
    $this->emit('msg-ok', 'No existe el código de barras');
    $this->barcode ='';
    return;
  }

}    

  //método que calcula el total a cobrar
public function calculateTotal($tipo,$fromDate, $tarifaId, $toDate = '')
{
  $tarifaTipo=$tipo;
 $fraccion = 0;
 //$tarifa = Tarifa::where('id', $tarifaId)->first();
 $tarifa = Tarifa::where('tiempo','Hora')->where('tipo_id',$tarifaTipo)->first();
 $tarifaInicial=Tarifa::where('id', $tarifaId)->first();       
 $start  =  Carbon::parse($fromDate);   
 $end    =  new \DateTime(Carbon::now());
 if(!$toDate =='')   $end = Carbon::parse($toDate);

   $tiempo= $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');//dif en horas + dif en min y seg

   $minutos = $start->diffInMinutes($end); 
   $horasCompletas = $start->diffInHours($end); 


   if($minutos <= 65){
     $fraccion = $tarifa->costo; 
   }
   /* else {
    $m=($minutos % 60);
        switch($m) {
          case $m>=0 && $m <=5:
            $fraccion = 0;
            break;
          case $m>5 && $m <=15:
            if($tarifaTipo==1){
              $fraccion = Tarifa::where('tiempo','15 minutos')->where('tipo_id','1')->first()->costo;
            }
            if($tarifaTipo==2) {
              $fraccion = Tarifa::where('tiempo','15 minutos')->where('tipo_id','2')->first()->costo;
            }
            if($tarifaTipo==3){
              $fraccion = Tarifa::where('tiempo','15 minutos')->where('tipo_id','3')->first()->costo;
            }
            //$fraccion = ($tarifa->costo*0.25);
            break;
          case $m>15 && $m <=30:
            if($tarifaTipo==1){
              $fraccion = Tarifa::where('tiempo','30 minutos')->where('tipo_id','1')->first()->costo;
            }
            if($tarifaTipo==2) {
              $fraccion = Tarifa::where('tiempo','30 minutos')->where('tipo_id','2')->first()->costo;
            }
            if($tarifaTipo==3){
              $fraccion = Tarifa::where('tiempo','30 minutos')->where('tipo_id','3')->first()->costo;
            }
            //$fraccion = ($tarifa->costo/2);
            break;
          case $m>30 && $m <=45:
            if($tarifaTipo==1){
              $fraccion = Tarifa::where('tiempo','45 minutos')->where('tipo_id','1')->first()->costo;
            }
            if($tarifaTipo==2) {
              $fraccion = Tarifa::where('tiempo','45 minutos')->where('tipo_id','2')->first()->costo;
            }
            if($tarifaTipo==3){
              $fraccion = Tarifa::where('tiempo','45 minutos')->where('tipo_id','3')->first()->costo;
            }
            //$fraccion = ($tarifa->costo*0.75);
            break;
          case $m>45:
            if($tarifaTipo==1){
              $fraccion = Tarifa::where('tiempo','Hora')->where('tipo_id','1')->first()->costo;
            }
            if($tarifaTipo==2) {
              $fraccion = Tarifa::where('tiempo','Hora')->where('tipo_id','2')->first()->costo;
            }
            if($tarifaTipo==3){
              $fraccion = Tarifa::where('tiempo','Hora')->where('tipo_id','3')->first()->costo;
            }
            //$fraccion = ($tarifa->costo);
            //$fraccion=$m;
            break;
        }
    /*$m = ($minutos % 60);
    if ( in_array($m, range(0,5)) ) { // después de la 1ra hora, se dan 5 minutos de tolerancia al cliente
           //
    }
    else if ( in_array($m, range(0,15)) ){
      $fraccion = ($tarifa->costo*0.25);
    } 
    else if ( in_array($m, range(16,30)) ){
      $fraccion = ($tarifa->costo / 2);   
    }
    else if ( in_array($m, range(31,45)) ){
      $fraccion = ($tarifa->costo * 0.75);  
    }
    else if ( in_array($m, range(46,59)) ){
          $fraccion = $tarifa->costo;    //después de la 1ra hora, del minuto 31-60 se cobra tarifa completa ($13.00)
        }
    /* else if ( in_array($m, range(6,30)) ){
        $fraccion = ($tarifa->costo / 2);   //después de la 1ra hora, del minuto 6 al 30 se cobra 50% de la tarifa ($6.50)
      }
      else if ( in_array($m, range(31,59)) ){
            $fraccion = $tarifa->costo;    //después de la 1ra hora, del minuto 31-60 se cobra tarifa completa ($13.00)
          } */
      //} 

      $m=($minutos % 60);
      switch($m) {
        case ($m>=0 && $m <=5):
          $fraccion = 0;
          break;
        case ($m>5 && $m <=15):
          if($tarifaTipo==1){
            $fraccion = Tarifa::where('tiempo','15 minutos')->where('tipo_id','1')->first()->costo;
          }
          if($tarifaTipo==2) {
            $fraccion = Tarifa::where('tiempo','15 minutos')->where('tipo_id','2')->first()->costo;
          }
          if($tarifaTipo==3){
            $fraccion = Tarifa::where('tiempo','15 minutos')->where('tipo_id','3')->first()->costo;
          }
          if($tarifaTipo==4){
            $fraccion = Tarifa::where('tiempo','15 minutos')->where('tipo_id','4')->first()->costo;
          }
          if($tarifaTipo==5){
            $fraccion = Tarifa::where('tiempo','15 minutos')->where('tipo_id','5')->first()->costo;
          }
          //$fraccion = ($tarifa->costo*0.25);
          break;
        case ($m>15 && $m <=30):
          if($tarifaTipo==1){
            $fraccion = Tarifa::where('tiempo','30 minutos')->where('tipo_id','1')->first()->costo;
          }
          if($tarifaTipo==2) {
            $fraccion = Tarifa::where('tiempo','30 minutos')->where('tipo_id','2')->first()->costo;
          }
          if($tarifaTipo==3){
            $fraccion = Tarifa::where('tiempo','30 minutos')->where('tipo_id','3')->first()->costo;
          }
          if($tarifaTipo==4){
            $fraccion = Tarifa::where('tiempo','30 minutos')->where('tipo_id','4')->first()->costo;
          }
          if($tarifaTipo==5){
            $fraccion = Tarifa::where('tiempo','30 minutos')->where('tipo_id','5')->first()->costo;
          }
          //$fraccion = ($tarifa->costo/2);
          break;
        case ($m>30 && $m <=45):
          if($tarifaTipo==1){
            $fraccion = Tarifa::where('tiempo','45 minutos')->where('tipo_id','1')->first()->costo;
          }
          if($tarifaTipo==2) {
            $fraccion = Tarifa::where('tiempo','45 minutos')->where('tipo_id','2')->first()->costo;
          }
          if($tarifaTipo==3){
            $fraccion = Tarifa::where('tiempo','45 minutos')->where('tipo_id','3')->first()->costo;
          }
          if($tarifaTipo==4){
            $fraccion = Tarifa::where('tiempo','45 minutos')->where('tipo_id','4')->first()->costo;
          }
          if($tarifaTipo==5){
            $fraccion = Tarifa::where('tiempo','45 minutos')->where('tipo_id','5')->first()->costo;
          }
          //$fraccion = ($tarifa->costo*0.75);
          break;
        case ($m>45):
          if($tarifaTipo==1){
            $fraccion = Tarifa::where('tiempo','Hora')->where('tipo_id','1')->first()->costo;
          }
          if($tarifaTipo==2) {
            $fraccion = Tarifa::where('tiempo','Hora')->where('tipo_id','2')->first()->costo;
          }
          if($tarifaTipo==3){
            $fraccion = Tarifa::where('tiempo','Hora')->where('tipo_id','3')->first()->costo;
          }
          if($tarifaTipo==4){
            $fraccion = Tarifa::where('tiempo','Hora')->where('tipo_id','4')->first()->costo;
          }
          if($tarifaTipo==5){
            $fraccion = Tarifa::where('tiempo','Hora')->where('tipo_id','5')->first()->costo;
          }
          //$fraccion = ($tarifa->costo);
          //$fraccion=$m;
          break;
        }
        /* if($m>5 && $m <=15){
            $fraccion = ($tarifa->costo*0.25);
        }
        if($m>15 && $m <=30){
          $fraccion = ($tarifa->costo/2);
        } */
        $total = (($horasCompletas * $tarifa->costo) + $fraccion);
        //$total=($fraccion);
        $fraccion=0;
        $tipo=0;
        return $total;

      }

  //este método registra la entrada de vehículos
      public function RegistrarEntrada($tarifa_id, $cajon_id, $estatus = '', $comment ='',$tipo)
      {

        if($estatus == 'OCUPADO')
        {    
         $this->emit('msg-ok','El cajón ya está ocupado');
         return;  
       }

     //ponemos cajón ocupado
      /*  $cajon = Cajon::where('id', $cajon_id)->first();
       $cajon->estatus = 'OCUPADO';
       $cajon->save();  */         


     //registrar entrada
      /*  $renta = Renta::create([
        'acceso' => Carbon::now(),
        'user_id' => auth()->user()->id,
        'tarifa_id' => $tarifa_id,
        'cajon_id' => $cajon_id,
        'descripcion' =>$comment
      ]); */


       /* //generamos el código de barras a 7 dígitos para imprimir el ticket con el estándar cod39
       $renta->barcode = sprintf('%07d', $renta->id); 
       $renta->save(); */
      /*  $txtOK=false;
       $txtPlaca=explode('',$comment);
       for($i=0;$i<strlen($comment);$i++){
          $txtPlaca[$i]
       } */
      $textPlaca=strtoupper(strval($comment));
      $PatronAuto = '/^[A-Z]{3}\w{4}$/';
      $PatronMoto='/^[0-9]{2}\w{4}$/';
      if(preg_match($PatronAuto,$textPlaca) || preg_match($PatronMoto,$textPlaca)){
        $cajon = Cajon::where('id', $cajon_id)->first();
        $cajon->estatus = 'OCUPADO';
        $cajon->save();
        //registrar entrada
        $renta = Renta::create([
          'acceso' => Carbon::now(),
          'user_id' => auth()->user()->id,
          'tarifa_id' => $tarifa_id,
          'cajon_id' => $cajon_id,
          'descripcion' =>$comment
        ]);
        //generamos el código de barras a 7 dígitos para imprimir el ticket con el estándar cod39
        $renta->barcode = sprintf('%07d', $renta->id); 
        $renta->save();      
        $this->barcode ='';   
        $this->descripcion ='';
        $this->emit('getin-ok','Entrada Registrada en Sistema');         
        $this->emit('print', $renta->id);

      }
      else{
        $this->emit('getin-error');
      }
       //enviamos feedback al user
       /* $this->barcode ='';   
       $this->descripcion ='';          
      //$this->emit('getin-ok','Entrada Registrada en Sistema');
       $this->emit('print', $renta->id); */


     }


 //método para calcular el tiempo que estuvo el vehículo en el estacionamiento
     public function CalcularTiempo($fechaEntrada)
     {
       $start  =  Carbon::parse($fechaEntrada);
       $end    = new \DateTime(Carbon::now());     
       $tiempo = $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');  
       return $tiempo;
     }


  //método para salida de vehículos
     public function BuscarTicket($tipo)
     {      

      $nuevoTotal = 0;


      //reglas de validación
      $rules = [
        'barcode'     => 'required'
      ];
      //mensajes personalizados
      $customMessages = [
        'barcode.required' => 'Ingresa o Escanea el Código de Barras'            
      ];

      $this->validate($rules, $customMessages);


      //validamos estatus del ticket
      $ticket = Renta::where('barcode', $this->barcode)->select('*')->first();
      if($ticket)
      {
        if($ticket->estatus == 'CERRADO') 
        {
          $this->emit('msg-ops', 'El ticket ya tiene registrada la salida-');
          $this->barcode ='';
          return; 
        }
      }
      else{
       $this->emit('msg-ops', 'El código de ticket no existe en sistema');
       $this->barcode ='';
       return redirect()->route('rentas'); 
     }


   //obtenemos la tarifa
     $tarifa = Tarifa::where('id', $ticket->tarifa_id)->first();        

   //obtenemos el tiempo
     $tiempo = $this->CalcularTiempo($ticket->acceso);

   //obtenemos el total
     $nuevoTotal =  $this->calculateTotal($tipo,$ticket->acceso, $ticket->tarifa_id);


   //guardamos la salida
     $ticket->salida = Carbon::now();
     $ticket->estatus = 'CERRADO';
     if($ticket->vehiculo_id == null)  $ticket->total = $nuevoTotal; 
     $ticket->hours = $tiempo; 
     $ticket->save();
    
   //ponemos el cajón disponible
     if($ticket->cajon_id > 0 )
     {
       $cajon = Cajon::where('id', $ticket->cajon_id)->first();
       $cajon->estatus = 'DISPONIBLE';
       $cajon->save();
     }

   //feedback al user
     if($ticket){
       $this->barcode ='';
       $this->section = 1;
       $this->emit('getout-ok', 'Salida Registrada Con Éxito');
    $this->emit('print', $ticket->id);  //descomentar para imprimir
 return;
     }   
     else {
      $this->barcode ='';
      $this->barcode ='';
      $this->emit('getout-error', 'No se pudo registrar la salida :/');
    }
    //genPDF();
  }
public function genPDF($id) {
  $ticket = Renta::where('barcode', $id)->select('*')->first();
		$tiempo = $this->CalcularTiempo($ticket->acceso);
		$ticket->hours = $tiempo;  
		$pdf = PDF::setPaper('A8');
		return $pdf->loadView('pdfs.vistaPDF' , ['datos' => $ticket])->stream();
}

//Ticket rápido de entrada de vehículos
  public function TicketVisita()
  {
  //obtenemos todas las tarifas ordenadas jerárquicamente
    $tarifas = Tarifa::select('jerarquia','tipo_id','id')->orderBy('jerarquia','desc')->get();
    // $tarifaID;

  //obtenemos el siguiente cajón disponible
    foreach ($tarifas as $j) {
     $cajon = Cajon::where('estatus','DISPONIBLE')->where('tipo_id',$j->tipo_id)->first(); 
     if($cajon) {
      $tarifaID = $j->id;
      break; 
    }                    
  }

 //cajones agotados
 if($cajon == null){
  $this->emit('msg-ops','Todos los espacios/cajones del estacionamiento están ocupados');
  return;
}

// //poner cajón ocupado                                
 $cajon->estatus = 'OCUPADO';
 $cajon->save();          


//registrar entrada
 $renta = Renta::create([
  'acceso' => Carbon::now(),
  'user_id' => auth()->user()->id,
  'tarifa_id' => $tarifaID, //????
  'cajon_id' => $cajon->id
 ]);

//creamos y guardamos el barcode
 $renta->barcode = sprintf('%07d', $renta->id); 
 $renta->save();


//feedback al user
 $this->barcode ='';
$this->emit('getin-ok','Entrada Registrada en Sistema');



}

public function doCheckIn($tarifa_id, $cajon_id, $estatus = '')
{
 $this->emit('checkin-ok','Entrada Registrada en Sistema');
}



//metodo registra ticket de renta
public function RegistrarTicketRenta()
{

  //reglas de validación
  $rules = [
    'name'     => 'required|min:3',
    'direccion'    => 'required',            
    'placa'    => 'required|max:7',
    'email' =>'nullable|email',     
  ];

  //mensajes personalizados
  $customMessages = [
    'name.required' => 'El campo Nombre es obligatorio',
    'direccion.required' => 'Por favor ingresa la Dirección',         
    'placa.required' => 'Debes ingresar el número de Placa',
    'placa.max' => 'La Placa no debe exceder 7 caracteres',          
  ];

  //ejecutamos las validaciones
  $this->validate($rules, $customMessages);

  //verificamos que el vehículo no tenga pensiones registradas con estatus abierto
  $exist = Renta::where('placa',$this->placa)->where('vehiculo_id', '>', 0)->where('estatus','ABIERTO')->count();
  if($exist > 0) {
    $this->emit('msg-error',"La placa $this->placa tiene una renta registrada aún con vigencia");
    
    return ;
  }


//iniciamos transacción
  DB::beginTransaction();

  try { 

  //paso 1 registrar cliente en users en caso necesario
    if($this->clienteSelected > 0)
    {
      $cliente = User::find($this->clienteSelected);
    }
    else {
      //si email viene vacío, generamos uno
      if(empty($this->email)) $this->email = str_replace(' ','_', $this->name) .'_@estacionamientofg.com';
      $cliente = User::create([
        'name' => $this->name,
        'telefono' => $this->telefono,
        'movil' => $this->celular,
        'direccion' => $this->direccion,
        'tipo' => 'Cliente',
        'email' =>  $this->email,
        'password' => bcrypt('secret2022.')
      ]);
    }

  //paso 2 registrar en vehiculos
    if($this->clienteSelected == null ) 
    {
      $vehiculo = Vehiculo::create([
        'placa' =>$this->placa,
        'modelo' =>$this->modelo,
        'marca' =>$this->marca,
        'color' =>$this->color,
        'nota' =>$this->nota
      ]);
    }

  //paso 3 registrar la asociacion de vehiculos y clientes
    if($this->clienteSelected == null ) 
    {
      $cv = ClienteVehiculo::create([
        'user_id' => $cliente->id,
        'vehiculo_id' => $vehiculo->id
      ]);
    }
    //calculamos el total entes de guardar la renta
    $tarifa=Tarifa::select('costo')->where('tipo_id',$this->tipo)->where('tiempo','Mes')->first()->costo;
    /* $inicio=Carbon::parse($this->fecha_ini);
    $fin=Carbon::parse($this->fecha_fin);
    $months=$inicio->diffInMonths($fin); */
    $total=$tarifa* $this->tiempo;
    //$this->total=$total;
  //paso 4 registrar el ticket en rentas      
    $renta = Renta::create([
      'acceso' => Carbon::parse($this->fecha_ini),
      'salida' => Carbon::parse($this->fecha_fin),
      'user_id' => auth()->user()->id,
      //'tarifa_id' => $this->tarifaSelected,            
      'placa' =>$this->placa,
      'modelo' =>$this->modelo,
      'marca' =>$this->marca,
      'color' =>$this->color,
      'descripcion' =>$this->nota,
      'direccion' =>$this->direccion,
      'vehiculo_id' => ($this->clienteSelected == null ? $vehiculo->id : $this->vehiculo_id), //AGREGAR
      'total' =>$total,
      'hours' =>$this->tiempo,
      'concepto_multa' =>$this->concepto_multa,
      'tarifa_id' =>$this->tipo
    ]);

    //generamos el barcode
    $renta->barcode = sprintf('%07d', $renta->id); 
    $renta->save();

    //enviamos feedback
    $this->barcode ='';             
    $this->emit('getin-ok','Se registró el cliente por Renta');
    if($this->printTicket == 1) $this->emit('print-pension', $renta->id);
    $this->action = 1;
    $this->limpiarCliente();

    //confirmamos transacción
    DB::commit();


  } catch (\Exception $e) {
    //para no tener inconsistencia de la info, deshacemos los cambios en caso de que algo falle
    DB::rollback();
    $status = $e->getMessage();       
    dd($e);     
  }

}


//obtener tarifa y calcular total a cobrar ticket de renta
public function getSalida()
{

  if($this->tiempo <=0)
  {
    $this->total = number_format(0,2);
    $this->fecha_fin = '';
  }
  else {
    $this->fecha_fin = Carbon::now()->addMonths($this->tiempo)->format('d-m-Y');
    $tarifa = Tarifa::where('tiempo','Mes')->where('tipo_id',$this->tipo)->select('costo')->first();    
    
    if ($this->tipo !=null && $this->tipo > 0){
      if($tarifa->count()) {
        $this->total = $this->tiempo * $tarifa->costo;      
      }
    }
    
    
  }

}


//buscar clientes
public function mostrarCliente($cliente)
{

  $this->clientes = '';
  $this->buscarCliente ='';
  $clienteJson = json_decode($cliente);

  $this->name = $clienteJson->name;
  // $this->telefono = $clienteJson->telefono;
  // $this->celular = $clienteJson->movil;
  $this->email = $clienteJson->email;
  // $this->direccion = $clienteJson->direccion;

  $this->placa = $clienteJson->placa;
  $this->modelo = $clienteJson->modelo;
  $this->color = $clienteJson->color;
  $this->marca = $clienteJson->marca;
  $this->nota = $clienteJson->nota;
  $this->vehiculo_id = $clienteJson->vehiculo_id; //AGREGAR
  $this->clienteSelected = $clienteJson->cliente_id;
  
}

public function limpiarCliente()
{
  $this->name = '';
  $this->telefono = '';
  $this->celular = '';
  $this->email = '';
  $this->direccion = '';

  $this->placa = '';
  $this->modelo = '';
  $this->color = '';
  $this->marca = '';
  $this->nota = '';
  $this->clienteSelected = null;
  $this->vehiculo_id = null; //AGREGAR
}



}
