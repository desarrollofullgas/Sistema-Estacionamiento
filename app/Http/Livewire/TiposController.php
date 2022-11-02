<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Tipo;
use App\Models\Tarifa;

class TiposController extends Component
{
  use WithPagination;


  //public properties
  public  $name, $image;    //campos de la tabla tipos
  public  $selected_id, $search;   //para búsquedas y fila seleccionada
  public  $action = 1;             //manejo de ventanas
  private $pagination;         //paginación de tabla





    //primer método que se ejecuta al inicializar el componente
  public function mount() 
  {
      //auth()->user()->assignRole('Admin');
  }


    //método que se ejecuta después de mount al inciar el componente
  public function render()
  {

        //si la propiedad buscar tiene al menos un caracter, devolvemos el componente y le inyectamos los registros de una búsqueda con like y paginado a  5 

    if(strlen($this->search) > 0)
    {
     $info = Tipo::where('name', 'like', '%' .  $this->search . '%')
     ->paginate($this->pagination);
     return view('livewire.tipos.component', [
      'info' =>$info,
    ]);
   }
   else {
        // caso contrario solo retornamos el componente inyectado con 5 registros
     return view('livewire.tipos.component', [
      'info' => Tipo::paginate($this->pagination),
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
  $this->action = $action;
}

  //método para reiniciar variables
private function resetInput()
{
  $this->name = '';
  $this->selected_id = null;       
  $this->action = 1;
  $this->search = '';
}

    //buscamos el registro seleccionado y asignamos la info a las propiedades
public function edit($id)
{
  $record = Tipo::findOrFail($id);
  $this->selected_id = $id;
  $this->name = $record->name;
  $this->action = 2;
}


    //método para registrar y/o actualizar info
public function StoreOrUpdate()
{     
        //validación campos requeridos
  $this->validate([
        'name' => 'required|min:4' //validamos que descripción no sea vacío o nulo y que tenga al menos 4 caracteres
      ]);

    //valida si existe otro cajón con el mismo nombre (edicion de tipos)
  if($this->selected_id > 0) {
    $existe = Tipo::where('name', $this->name)
    ->where('id', '<>', $this->selected_id)
    ->select('name')
    ->get();

    if( $existe->count() > 0) {
     session()->flash('msg-error', 'Ya existe el Tipo');
     $this->resetInput();
     return;
   }
 }        
 else 
 {
    //valida si existe otro cajón con el mismo nombre (nuevos registros)
  $existe = Tipo::where('name', $this->name)
  ->select('name')
  ->get();

  if($existe->count() > 0 ) {
   session()->flash('msg-error', 'Ya existe el Tipo');
   $this->resetInput();
   return;
 }
}










if($this->selected_id <= 0) {
    //creamos el registro
  $tipo =  Tipo::create([
    'name' => $this->name            
  ]);
  if($this->image)
  {
    $image = $this->image;
    $fileName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
    $moved = \Image::make($image)->save('images/'.$fileName);

    if($moved) 
    {
      $tipo ->imagen = $fileName;
      $tipo->save();
    }
  }

}
else 
{   
    //buscamos el tipo
  $record = Tipo::find($this->selected_id);
    //actualizamos el registro
  $record->update([
   'name' => $this->name
 ]);                    
  if($this->image)
  {
    $image = $this->image;
    $fileName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
    $moved = \Image::make($image)->save('images/'.$fileName);

    if($moved) 
    {
      $record ->imagen = $fileName;
      $record->save();
    }
  }

}


//enviamos feedback al usuario
if($this->selected_id) 
 session()->flash('message', 'Tipo Actualizado');
else
 session()->flash('message', 'Tipo Creado');

//limpiamos las propiedades
$this->resetInput();

}


//escuchar eventos y ejecutar acción solicitada
protected $listeners = [
  'deleteRow'     => 'destroy',
  'fileUpload' =>'handleFileUpload' 
];  

public function handleFileUpload($imageData)
{
  $this->image = $imageData;
}


   //método para eliminar un registro dado
public function destroy($id)
{
    if ($id) { //si es un id válido
      $records = Tarifa::where('tipo_id', $id)->count();
      if($records > 0){
       $this->emit('msg-error', "No es posible eliminar el registro porque existen tarifas asociadas a este tipo");      
     }
     else {
        $tipo = Tipo::where('id', $id); //buscamos el registro
        $tipo->delete(); //eliminamos el registro
        $this->resetInput(); //limpiamos las propiedades
         $this->emit('msgok', "Tipo eliminado con éxito");  
      }
    }

  }




}
