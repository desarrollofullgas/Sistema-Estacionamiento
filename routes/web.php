<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'data'])->middleware('auth')->name('dashboard');
	
    Route::get('/users', [UserController::class, 'index'])->middleware('permission:usuarios_index')->name('users');
    Route::delete('/users{user}', [UserController::class, 'destroy'])->name('users.destroy');
	Route::get("/trashed", [UserController::class, "trashed_users"])->name('users.trashed');
	Route::post("/restore", [UserController::class, "do_restore"])->name('user_restore');
	Route::post("/delete-permanently", [UserController::class, "delete_permanently"])->name('deleteuser_permanently');

    Route::view('tipos', 'modules.tipos')->middleware('permission:tipos_index','verified'); 
    Route::view('empresa', 'modules.empresa')->middleware('permission:empresa_index','verified'); 
	Route::view('cajones', 'modules.cajones')->middleware('permission:cajones_index','verified');
	Route::view('tarifas', 'modules.tarifas')->middleware('permission:tarifas_index','verified'); 
	Route::view('cortes', 'modules.cortes')->middleware('permission:cortes_index','verified');

	
	Route::view('rentas', 'modules.rentas')->middleware('permission:rentas_index','verified');
	//Route::view('cotizaciones', 'cotizaciones'); 
	//Route::view('cuentasxpagar', 'cuentasxpagar'); 

    Route::view('movimientos', 'modules.movimientos')->middleware('permission:movimientos_index','verified');	
	Route::view('extraviados', 'modules.extraviados')->middleware('permission:extraviados_index','verified');
	Route::view('permisos', 'modules.permisos')->middleware('permission:roles_index','verified');

	Route::view('ventasdiarias', 'modules.ventasdiarias')->middleware('permission:reporte_ventasdiarias_index','verified'); 
	Route::view('ventasporfechas', 'modules.ventasporfechas')->middleware('permission:reporte_ventasporfecha_index','verified');
	Route::view('proximasrentas', 'modules.proximasrentas')->middleware('permission:reporte_rentasavencer_index','verified');

    //rutas de impresión
Route::get('print/order/{id}', [PrinterController::class, 'TicketVisita'])->name('print/order');
Route::get('ticket/pension/{id}', [PrinterController::class, 'TicketPension'])->name('#');
});
