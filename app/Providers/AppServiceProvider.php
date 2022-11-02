<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Empresa;
use App\Models\Cajon;
use App\Models\Tipo;
use App\Models\Tarifa;
use App\Models\Renta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.app', function($view)
        {

             //$view_name = str_replace('.', '-', $view->getName());

            //Global validation for setting up
            $empresa =  Empresa::count();
            $cajones =  Cajon::count();
            $tipos   =  Tipo::count();
            $tarifas =  Tarifa::count();
            $rentas  =  Renta::where('vehiculo_id', '>', 0)->where('estatus','ABIERTO')->select('acceso','salida')->get();

            $rentasVencidas  = 0;
            $rentasPorVencer = 0;
           
            foreach ($rentas as $r) {
                $start  =  Carbon::parse($r->acceso);
                $end    =  Carbon::parse($r->salida);                       

                if(Carbon::now()->greaterThan($end))  
                {
                    $rentasVencidas++;
                }
                else {                
                    $days = $start->diffInDays($end);                                    
                    if($days > 0 && $days <=3) $rentasPorVencer ++;
                }            

            }     

            
            $tiposSinTarifa = DB::table("tipos")->select('*')
            ->whereNOTIn('id',function($query){
             $query->select('tipo_id')->from('tarifas');
         })
            ->count();


            $view->with(['empresa'=> $empresa, 'cajones' => $cajones, 'tipos' => $tipos, 'tarifas'=> $tarifas, 'tiposSinTarifa' =>$tiposSinTarifa,
            'rentasVencidas' => $rentasVencidas, 'rentasPorVencer' => $rentasPorVencer ]);
        });
        
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.locale'));
    }
}
