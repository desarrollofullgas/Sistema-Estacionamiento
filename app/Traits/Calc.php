<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Renta;
use App\Models\Tarifa;
use App\Models\Cajon;
use App\Models\Tolerancia;

//Los trait son un mecanismo de reutilizacion de codigo que nos permiten emular la herencia múltiple a partir de la version 5.4 de PHP
//Son similares a una clase, pero su objetivo es agrupar funcionalidades especificas y comunes
//No se pueden instanciar directamente
//Se inician con la palabra clave trait
trait Calc
{

  public static function DameTotal($barcode, $fromDate, $tarifaId, $toDate = '')
  {
    $tarifaID=Renta::select('tarifa_id')->where('barcode',$barcode)->first()->tarifa_id;
    $tipo=Tarifa::select('tipo_id')->where('id',$tarifaID)->first()->tipo_id;
    $tarifaTipo=$tipo;
   $fraccion = 0;
   $tolerancia= Tolerancia::select('*')->first();
//$tarifa = Tarifa::where('id', $tarifaId)->first();
$tarifa = Tarifa::where('tiempo','Hora')->where('tipo_id',$tarifaTipo)->first();      
$tarifaInicial=Tarifa::where('id', $tarifaId)->first();
$start  =  Carbon::parse($fromDate);
   $toleranciaTime=0;   
   $end    =  new \DateTime(Carbon::now());
   if(!$toDate =='')   $end = Carbon::parse($toDate);

  //dif en horas + dif en min y seg
   $tiempo= $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');

   $minutos = $start->diffInMinutes($end); 
   $horasCompletas = $start->diffInHours($end);
   
   
   if($tolerancia->count()>0){
    $toleranciaTime = $tolerancia->tiempo;
   }
   else{
    $toleranciaTime=0;
   }


   if($minutos <= 65){
   	$fraccion = $tarifa->costo; 
   }
   /* else {
   	$m = ($minutos % 60);
    if ( in_array($m, range(0,5)) ) { // después de la 1ra hora, se dan 5 minutos de tolerancia al cliente
           //
    }
    else if ( in_array($m, range(6,15)) ){
      $fraccion = ($tarifa->costo / 4);
    } 
    else if ( in_array($m, range(16,30)) ){
      $fraccion = ($tarifa->costo / 2);   //después de la 1ra hora, del minuto 6 al 30 se cobra 50% de la tarifa ($6.50)
    }
    else if ( in_array($m, range(31,45)) ){
      $fraccion = ($tarifa->costo * 0.75);   //después de la 1ra hora, del minuto 6 al 30 se cobra 50% de la tarifa ($6.50)
    }
    else if ( in_array($m, range(46,59)) ){
          $fraccion = $tarifa->costo;    //después de la 1ra hora, del minuto 31-60 se cobra tarifa completa ($13.00)
        } */
        
    /* else if ( in_array($m, range(6,30)) ){
        $fraccion = ($tarifa->costo / 2);   //después de la 1ra hora, del minuto 6 al 30 se cobra 50% de la tarifa ($6.50)
      }
      else if ( in_array($m, range(31,59)) ){
            $fraccion = $tarifa->costo;    //después de la 1ra hora, del minuto 31-60 se cobra tarifa completa ($13.00)
          }  */
/*       switch($m){
        case in_array($m, range(6,15)):
          $fraccion = ($tarifa->costo / 4);
          break;
        case in_array($m, range(16,30)):
          $fraccion = ($tarifa->costo / 2);
          break;
        case in_array($m, range(31,59)):
          $fraccion = $tarifa->costo;
          break;
      } */
        //}
        $m=($minutos % 60);
        $segundos=($start->diffInSeconds($end)-($minutos*60));
        switch($m) {
          case ($m>0 && $m <(15+$toleranciaTime) && $segundos>=0 && $segundos<60):
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
          case ($m>=(15+$toleranciaTime) && $m <(30+$toleranciaTime) && $segundos>=0 && $segundos<60 ):
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
          case ($m>=(30+$toleranciaTime) && $m <(45+$toleranciaTime) && $segundos>=0 && $segundos<60 /* && 1>($m/60) */):
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
          case ($m>=(45+$toleranciaTime)&& $segundos>=0 && $segundos<60):
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
        //retornamos el total a cobrar
        $total = (($horasCompletas * $tarifa->costo) + $fraccion);
        $fraccion=0;
        $tipo=0;
        return $total;

      }
      
  public function CalculaTiempo($fechaEntrada)
      {
       $start  =  Carbon::parse($fechaEntrada);
       $end    = new \DateTime(Carbon::now());     
       $tiempo = $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S P');  
       return $tiempo;
  }



//método para salida de vehículos
     public function Salidas($barcode = '', $multaDesc ='')
     {      

      $nuevoTotal = 0;          


      //validamos estatus del ticket
      $ticket = Renta::where('barcode', $barcode)->select('*')->first();
      if($ticket)
      {
        if($ticket->estatus == 'CERRADO') 
        {
          $this->emit('msg-ops', 'El ticket ya tiene registrada la salida');          
          return; 
        }
      }
      else{
       $this->emit('msg-ops', 'El código de ticket no existe en sistema');       
       return; 
     }


   //obtenemos la tarifa
     $tarifa = Tarifa::where('id', $ticket->tarifa_id)->first();        

   //obtenemos el tiempo
     $tiempo = $this->CalculaTiempo($ticket->acceso);

   //obtenemos el total
     $nuevoTotal =  $this->DameTotal($ticket->barcode,$ticket->acceso, $ticket->tarifa_id);

   //guardamos la salida
     $ticket->salida = Carbon::now();
     $ticket->estatus = 'CERRADO';
     $ticket->concepto_multa = $multaDesc;
     $ticket->total = $nuevoTotal + 50 ; 
     $ticket->multa = 50; 
     $ticket->hours = $tiempo;  
     $ticket->save();

   //ponemos el cajón disponible
     $cajon = Cajon::where('id', $ticket->cajon_id)->first();
     $cajon->estatus = 'DISPONIBLE';
     $cajon->save();


   //feedback al user
     if($ticket){     
       $this->emit('getout-ok', 'Salida Registrada Con Éxito');
    $this->emit('print', $ticket->id);  //descomentar para imprimir
     }   
     else {  
      $this->emit('getout-error', 'No se pudo registrar La salida :/');
    }

  }



}
