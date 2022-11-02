<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Component
{


    public $nombre, $telefono, $email, $direccion, $logo, $event;


    public function mount()
    {       

        $this->event =false;
        $empresa = Empresa::all();
        

        if($empresa->count() >0 ) {
            $this->nombre = $empresa[0]->nombre;
            $this->telefono = $empresa[0]->telefono;
            $this->direccion = $empresa[0]->direccion;
            $this->email = $empresa[0]->email;
            $this->logo = $empresa[0]->logo;        
        }
    }



    public function render()
    {
        return view('livewire.empresa.component');
    }


    protected $listeners = [
        'logoUpload' =>  'logoUpload'
    ];  

    public function logoUpload($imageData)
    {
        $this->logo = $imageData;
        $this->event = true;        
    }



    public function Guardar() 
    {
        $rules = [
            'nombre' => 'required',
            'telefono' => 'required',
            'email' => 'required|email',
            'direccion' => 'required'
        ];

        $customMessages = [
            'nombre.required' => 'El campo nombre es requerido',
            'telefono.required' => 'El campo teléfono es requerido',
            'email.required' => 'El campo email es inválido',
            'direccion.required' => 'El campo dirección es requerido'
        ];


        $this->validate($rules, $customMessages);

        DB::table('empresas')->truncate(); //aliminando la info de la tabla


        //tarea
        $empresa = Empresa::create([
            'nombre'=> $this->nombre,
            'telefono'=> $this->telefono,
            'email'=> $this->email,
            'direccion'=> $this->direccion
        ]);


        if($this->logo !=null && $this->event )
        {
            $image = $this->logo;                       
            $fileName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];          
            $moved = \Image::make($image)->save('img/images/'.$fileName);

            if ($moved) 
            {
                $empresa->logo = $fileName;
                $empresa->save();
            }         
        }        


        $this->emit('msgok', 'Información de la empresa registrada');



    }



}
