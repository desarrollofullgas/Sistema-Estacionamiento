<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Caja;
use Illuminate\Support\Facades\Auth;

class MovimientosController extends Component
{
	use WithPagination;

	public $tipo,$concepto,$monto,$comprobante,$image1;
	public  $selected_id, $search;  
	public $action = 1, $pagination, $actionTitle ='Nuevo Movimiento';

    public function render()
    {
    	$movs = Caja::orderBy('id')->paginate($this->pagination);

    	if(strlen($this->search) > 0){
    		$movs = Caja::where('concepto', 'like', '%' .  $this->search . '%')
    					->orWhere('tipo', 'like', '%' .  $this->search . '%')
    		            // ->orderBy('id','desc')
                        ->paginate($this->pagination);
    	}
        return view('livewire.movimientos.component', 
        	['info' => $movs]);
    }

   	//
     protected $listeners = [
        'fileUpload'     => 'handleFileUpload',
        'deleteRow'     => 'destroy'
    ];
    public function handleFileUpload($imageData)
    {
        $this->image1 = $imageData;
    }


     //activa la vista edición o creación
    public function doAction($action)
    {
        $this->resetInput();
        $this->action = $action;
        if($action == 2) $this->actionTitle ='Nuevo Movimiento';
        if($action == 3) $this->actionTitle ='Editar Movimiento';
    }

    //método para reiniciar variables
    private function resetInput()
    {
        $this->tipo = 'Elegir';
        $this->concepto = '';
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
        $this->concepto = $record->concepto;
        $this->tipo = $record->tipo;
        $this->monto = $record->monto;
        $this->comprobante = $record->comprobante;        
        $this->action = 3;

    }


    //método para registrar y/o actualizar registros
    public function StoreOrUpdate()
    {         	
    	$record;

    	$this->validate([
    		 'monto' => 'required|numeric|gt:0',
    		 'tipo'   => 'not_in:Elegir',
    		 'concepto'   => 'required|min:3',
    	]);   	

               

    if($this->selected_id <= 0) {
        
        $record =  Caja::create([
            'monto' => $this->monto,            
            'tipo' => $this->tipo,            
            'concepto' => $this->concepto,            
            'user_id' => Auth::user()->id      
        ]);

         
    }
    else 
    {    	
        $record = Caja::find($this->selected_id);
        $record->update([
            'monto' => $this->monto,            
            'tipo' => $this->tipo,            
            'concepto' => $this->concepto,            
            'user_id' => Auth::user()->id     
        ]); 
    }


    if($this->image1)
        {
           $image = $this->image1;           
           $fileName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
           $moved = \Image::make($image)->save('img/images/'.$fileName);
        
           if ($moved) 
           {
               $record->comprobante = $fileName;
               $record->save();
           }
         
    } 


        

        if($this->selected_id) 
             session()->flash('message', 'Movimiento de Caja Actualizado');
         else
             session()->flash('message', 'Movimiento de Caja Registrado');


        $this->resetInput();
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Caja::where('id', $id);
            $record->delete();
             $this->resetInput();
        }

    }




}
