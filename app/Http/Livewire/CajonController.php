<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cajon;
use App\Models\Tipo;
use App\Models\Renta;

class CajonController extends Component
{   
    use WithPagination;

	//poublic properties
	public  $tipo ='Elegir',$descripcion, $estatus='DISPONIBLE'; //campos de la tabla cajones
	public  $selected_id, $search;   						     //para búsquedas y fila seleccionada
    public  $action = 1;             						     //manejo de ventanas
    private $pagination;         						     //paginación de tabla
    public  $tipos;


    //método que se ejecuta al inciar el componente
    public function render()
    {
      $this->tipos = Tipo::all();
       //retorna la vista:  livewire/cajones/component
      if(strlen($this->search) > 0)
      {
       $info = Cajon::leftjoin('tipos as t','t.id', 'cajons.tipo_id')
       ->select('cajons.*','t.name as tipo')
       ->where('cajons.descripcion', 'like', '%' .  $this->search . '%')
       ->orWhere('cajons.estatus', 'like', '%' .  $this->search . '%')
       ->paginate($this->pagination);

       return view('livewire.cajones.component', [
        'info' => $info,
    ]);

   }
   else {

     $cajones = Cajon::leftjoin('tipos as t','t.id', 'cajons.tipo_id')
     ->select('cajons.*','t.name as tipo')
    //  ->orderBy('cajons.id','desc')
  ->paginate($this->pagination);

     return view('livewire.cajones.component', [
        'info' => $cajones,
    ]);
 }
}

    //permite la búsqueda cuando se navega entre el paginado
public function updatingSearch()
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
    $this->tipo = 'Elegir';
    $this->estatus = 'DISPONIBLE';       
    $this->selected_id = null;       
    $this->action = 1;
    $this->search = '';
}

    //buscamos el registro seleccionado y asignamos la info a las propiedades
public function edit($id)
{
    $record = Cajon::findOrFail($id);
    $this->selected_id = $id;
    $this->tipo = $record->tipo_id;
    $this->descripcion = $record->descripcion;
    $this->estatus = $record->estatus;        
    $this->action = 2;

}


    //método para registrar y/o actualizar registros
public function StoreOrUpdate()
{         	

   $this->validate([    		 
     'tipo'   => 'not_in:Elegir'
 ]);


   $this->validate([
    'descripcion' => 'required',
    'tipo' => 'required',
    'estatus' => 'required'
]);


   if($this->selected_id <= 0) { 
    $cajon =  Cajon::create([
        'descripcion' => $this->descripcion,            
        'tipo_id' => $this->tipo,         
        'estatus' => $this->estatus                    
    ]);

}
else 
{    	      
    $record = Cajon::find($this->selected_id);
    $record->update([
        'descripcion' => $this->descripcion,            
        'tipo_id' => $this->tipo,         
        'estatus' => $this->estatus    
    ]);

}


if($this->selected_id)              
   $this->emit('msgok', "Cajón Actualizado con éxito");
else
    $this->emit('msgok', "Cajón Registrado con éxito");             


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
        $records = Renta::where('cajon_id', $id)->count();
        if($records > 0){
             $this->emit('msg-error', "Este número de cajón existe en el historial de ventas y no es posible eliminarlo");      
        }
        else {
            $cajon = Cajon::where('id', $id);
            $cajon->delete();
            $this->resetInput();
             $this->emit('msgok', "Cajón eliminado con éxito");    
        }
    }

}

}
