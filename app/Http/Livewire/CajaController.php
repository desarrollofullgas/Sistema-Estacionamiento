<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Caja;

class CajaController extends Component
{
    // use WithPagination;

	//properties
	public  $tipo ='Elegir',$concepto,$monto,$comprobante;//campos de la tabla/modelo
	public  $selected_id, $search;   						//para búsquedas y fila seleccionada
    public  $action = 1;             						//manejo de ventanas
    private $pagination;         						//paginación de tabla
   

    //método que se ejecuta al inciar el componente
    public function render()
    {
       //$this->cajas = Tipo::all();
        if(strlen($this->search) > 0)
        {
            return view('livewire.cajas.component', [
            'info' => Caja::where('tipo', 'like', '%' .  $this->search . '%')
            		  ->orWhere('concepto', 'like', '%' .  $this->search . '%')
            			  ->paginate($this->pagination),
        ]);
        }
        else {

			$caja = Caja::leftjoin('users as u','u.id', 'caja.user_id')
				->select('caja.*','u.nombre')
				// ->orderBy('id','desc')
				->paginate($this->pagination);

         return view('livewire.cajas.component', [
            'info' => $caja,
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
        $this->concepto = '';
        $this->tipo = 'Elegir';
        $this->monto = '';
        $this->comprobante = '';          
        $this->selected_id = null;       
        $this->action = 1;
        $this->search = '';
    }

    //buscamos el registro seleccionado y asignamos la info a las propiedades
    public function edit($id)
    {
        $record = Caja::findOrFail($id);
        $this->selected_id = $id;
        $this->tipo = $record->tipo;
        $this->concepto = $record->concepto;
        $this->monto = $record->monto;
        $this->comprobante = $record->comprobante;        
        $this->action = 2;

    }


    //método para registrar y/o actualizar registros
    public function StoreOrUpdate()
    {         	

    	$this->validate([    		 
    		 'tipo'   => 'not_in:Elegir'
    	]);
    	

        $this->validate([
            'monto' => 'required',
            'tipo' => 'required',
            'concepto' => 'required'
        ]);
       

    if($this->selected_id <= 0) { 
        $caja =  Caja::create([
            'monto' => $this->monto,            
            'tipo' => $this->tipo,         
            'concepto' => $this->concepto,            
            'user_id' => Auth::user()->id,            
        ]);
        if($this->comprobante)
        {
           $image = $this->comprobante;           
           $fileName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           $moved = \Image::make($image)->save('images/'.$fileName);
        
           if ($moved) 
           {
               $record->comprobante = $fileName;
               $record->save();
           }         
        } 

         
    }
    else 
    {    	      
        $record = Caja::find($this->selected_id);
        $record->update([
            'monto' => $this->monto,            
            'tipo' => $this->tipo,         
            'concepto' => $this->concepto,            
            'user_id' => Auth::user()->id,     
        ]);
        if($this->comprobante)
        {
           $image = $this->comprobante;           
           $fileName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           $moved = \Image::make($image)->save('images/'.$fileName);
        
           if ($moved) 
           {
               $record->comprobante = $fileName;
               $record->save();
           }         
        }                  

        
    }
        

        if($this->selected_id) 
             session()->flash('message', 'Movimiento de Caja Actualizado');
         else
             session()->flash('message', 'Movimiento de Caja Registrado');


        $this->resetInput();
    }


    //escuchar eventos y ejecutar acción solicitada
    protected $listeners = [
        'deleteRow'     => 'destroy',
        'fileUpload' =>  'handleFileUpload'
    ];  
   	
   	public function handleFileUpload($imageData)
    {
        $this->comprobante = $imageData;
    }

   
   //método para eliminar un registro dado
    public function destroy($id)
    {
        if ($id) {
            $record = Caja::where('id', $id);
            $record->delete();
             $this->resetInput();
        }

    }
}
