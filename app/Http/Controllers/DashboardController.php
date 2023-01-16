<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Renta;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  
   public function data()
	{
    $currentYear =  date("Y");
  //ventas semana actual
    $start = date('Y-m-d', strtotime('monday this week')); //obtenemos el 1er dia de la semana actual
    $finish = date('Y-m-d', strtotime('sunday this week'));  //obtenemos el ultimo dia
          
    $d1 = strtotime($start); //convertir fecha inicial en formato unix
    $d2 = strtotime($finish); 
    $array = array(); 

    for ($currentDate = $d1; $currentDate <= $d2; $currentDate += (86400)) 
    { 
      $dia = date('Y-m-d', $currentDate); //convertimos el dia unix a formato ingles
      $array[] = $dia;            
    } 

    $sql ="SELECT c.fecha, IFNULL(c.total,0) as total FROM (
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

$chartVentaSemanal = new LarapexChart();
$chartVentaSemanal->setTitle('Ventas Semana Actual')
->setLabels(['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'])
->setType('pie')        
->setDataset([intval($weekSales[0]->total),
  intval($weekSales[1]->total),
  intval($weekSales[2]->total),
  intval($weekSales[3]->total),
  intval($weekSales[4]->total),
  intval($weekSales[5]->total),
  intval($weekSales[6]->total)
]);

//ventas por mes
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
$chartVentaxMes = (new LarapexChart)->setType('area')
->setTitle('Ventas Anuales')
->setSubtitle('Por Mes')
->setGrid()
->setXAxis([
  'Enero', 'Febrero', 'Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
])
->setDataset([
  [
    'name'  =>  'Ventas',
    'data'  =>  
    [
      $salesByMonth[0]->VENTAS,
      $salesByMonth[1]->VENTAS,
      $salesByMonth[2]->VENTAS,
      $salesByMonth[3]->VENTAS,
      $salesByMonth[4]->VENTAS,
      $salesByMonth[5]->VENTAS,
      $salesByMonth[6]->VENTAS,
      $salesByMonth[7]->VENTAS,
      $salesByMonth[8]->VENTAS,
      $salesByMonth[9]->VENTAS,
      $salesByMonth[10]->VENTAS,
      $salesByMonth[11]->VENTAS
    ]
  ]
]);
//balance anual
$listVentas;
for ($i=0; $i <12; $i++) { 
  $listVentas[$i] = Renta::whereMonth('acceso',$i+1)->whereYear('acceso', $currentYear)->sum('total');
}
$listGastos;
for ($i=0; $i <12; $i++) { 
  $listGastos[$i] = Caja::where('tipo','<>','Ingreso')->whereMonth('created_at',$i+1)->whereYear('created_at', $currentYear)->sum('monto');
}
$listBalance;
for ($i=0; $i <12; $i++) { 
  $listBalance[$i] = number_format($listVentas[$i] - $listGastos[$i],2);
}
$chartBalancexMes = (new LarapexChart)->setTitle('Balance Anual')        
->setType('bar')
->setXAxis(['Ene', 'Feb', 'Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'])
->setGrid(true)
->setDataset([
  [
    'name'  => 'Ventas',
    'data'  =>  $listVentas
  ],
  [
    'name'  => 'Gastos',
    'data'  => $listGastos
  ],
  [
    'name'  => 'Balance',
    'data'  => $listBalance
  ]
])
->setStroke(1)
->setColors(['#2ECC71', '#E74C3C', '#3498DB']);
return view('modules.dashboard', compact('chartVentaxMes','chartVentaSemanal','chartBalancexMes'));
}
}
