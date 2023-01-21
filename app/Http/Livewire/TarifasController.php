<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Tarifa;
use App\Models\Tipo;
use App\Models\Renta;

class TarifasController extends Component
{
    // use WithPagination;

	//properties
	public  $tiempo ='Elegir',$descripcion,$costo,$tipo ='Elegir',$jerarquia; //campos de la tabla/modelo
	public  $selected_id, $search;   						//para búsquedas y fila seleccionada
    public  $action = 1;             						//manejo de ventanas
    private $pagination;         						//paginación de tabla
    public  $tipos;

    public function mount()
    {
        $tarifas = Tarifa::count();
        if($tarifas > 0)
        {
           $tarifa = Tarifa::select('jerarquia')->orderBy('jerarquia', 'desc')->first();
           $this->jerarquia = $tarifa->jerarquia + 1;
             //dd($tarifa->jerarquia);
       }
       else 
       {
        $this->jerarquia = 0;
    }

}

    //método que se ejecuta al inciar el componente
public function render()
{

 $this->tipos = Tipo::all();
 if(strlen($this->search) > 0)
 {
    return view('livewire.tarifas.component', [
        'info' => Tarifa::where('descripcion', 'like', '%' .  $this->search . '%')
        ->paginate($this->pagination),
    ]);
}
else {

    $tarifas = Tarifa::leftjoin('tipos as t', 't.id', 'tarifas.tipo_id')
    ->select('tarifas.*', 't.name as tipo')
    // ->orderBy('tarifas.tiempo', 'desc')
    ->orderBy('t.name')
    ->paginate($this->pagination);

    return view('livewire.tarifas.component', [
        'info' => $tarifas,
    ]);
}
}

    //permite la búsqueda cuando se navega entre el paginado
public function updatingSearch(): void
{
    $this->gotoPage(1);
}

    //activa la vista edición o creación
public function doAction($action)
{
    $this->resetInput();
    $this->action = $action;

}

	//método para reiniciar variables
private function resetInput()
{
    $this->descripcion = '';
    $this->tiempo = 'Elegir';
    $this->costo = '';
    $this->tipo = 'Elegir';
    $this->selected_id = null;       
    $this->action = 1;
    $this->search = '';
        //$this->jerarquia =null;
}

    //buscamos el registro seleccionado y asignamos la info a las propiedades
public function edit($id)
{
    $record = Tarifa::findOrFail($id);
    $this->selected_id = $id;
    $this->descripcion = $record->descripcion;
    $this->tiempo = $record->tiempo;
    $this->costo = $record->costo;
    $this->tipo = $record->tipo->id;
    $this->descripcion = $record->descripcion;
    $this->jerarquia = $record->jerarquia;
    $this->action = 2;

}


    //método para registrar y/o actualizar registros
public function StoreOrUpdate()
{         	

    $this->validate([
        'tiempo' => 'required',
        'costo'  => 'required',
        'tipo'   => 'required',
        'tiempo' => 'not_in:Elegir',
        'tipo'   => 'not_in:Elegir'
    ]);


    if($this->selected_id > 0) {
        $existe = Tarifa::where('tiempo', $this->tiempo)
        ->where('tipo_id', $this->tipo)
        ->where('id', '<>', $this->selected_id)
        ->select('tiempo')->get();
    }
    else 
    {
        $existe = Tarifa::where('tiempo', $this->tiempo)
        ->where('tipo_id', $this->tipo)
        ->select('tiempo')->get();
    }    


    if( $existe->count() > 0){
       session()->flash('msg-error', 'Ya existe la tarifa');
       $this->resetInput();
       return;
   }




   if($this->selected_id <= 0) {        
    $costFinal=str_replace(',','',$this->costo);
    $tarifa =  Tarifa::create([
        'tiempo' => $this->tiempo,            
        'descripcion' => $this->descripcion,            
        'costo' =>$costFinal, //$this->costo,            
        'tipo_id' => $this->tipo,
        'jerarquia' => $this->jerarquia
    ]);


}
else 
{

    $tarifa = Tarifa::find($this->selected_id);
    $tarifa->update([
        'tiempo' => $this->tiempo,            
        'descripcion' => $this->descripcion,            
        'costo' => $this->costo,            
        'tipo_id' => $this->tipo,
        'jerarquia' => $this->jerarquia
    ]);                    


}
if($this->jerarquia == 1)
{
    Tarifa::where('id','<>',$tarifa->id)->update([
        'jerarquia' => 0
    ]);
}

if($this->selected_id) 
   session()->flash('message', 'Tarifa Actualizada');
else
   session()->flash('message', 'Tarifa Creada');


$this->resetInput();
}


    //escuchar eventos y ejecutar acción solicitada
protected $listeners = [
    'deleteRow'     => 'destroy'        
];  


   //método para eliminar un registro dado
public function destroy($id)
{
    if ($id) {
        $records = Renta::where('tarifa_id', $id)->count();
        if($records > 0){
           $this->emit('msg-error', "No es posible eliminar el registro porque existen ventas cobradas con esta tarifa");      
       }
       else {
        $record = Tarifa::where('id', $id);
        $record->delete();
        $this->resetInput();
        $this->emit('msgok', "Tarifa eliminada de sistema");    
    }
}

}


}
