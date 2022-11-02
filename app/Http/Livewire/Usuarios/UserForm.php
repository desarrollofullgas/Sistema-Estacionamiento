<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserForm extends Component
{

    public $newgUsuario;
    public $name, $username, $email, $password, $password_confirmation, $status, $tipo;

    public function resetFilters()
    {
        $this->reset(['name', 'username', 'email', 'password','status','tipo' ]);
    }

    public function mount()
    {
        $this->newgUsuario = false;
    }

    public function showModalFormUsuario(){
        
        $this->resetFilters();

        $this->newgUsuario=true;
    }

    public function addUsuario()
    {
        $this->validate( [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:40', 'unique:users'],
            'tipo' =>['required'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'password_confirmation' => ['required', 'same:password'],
        ],
        [
            'name.required' => 'El campo Nombre es obligatorio',
            'name.max' => 'El campo Nombre no debe ser mayor a 50 carateres',
            'name.string' => 'El campo Nombre no debe contener digitos',
            'email.required' => 'El campo E-mail es obligatorio',
            'email.email' =>'Introduzca un E-mail valido',
            'email.unique' =>'La dirección E-mail ya se encuentra registrada',
            'email.max' =>'El campo E-mail no debe ser mayor a 40 caracteres',
            'password.required' => 'El Campo Contraseña es obligatorio',
            'password_confirmation.required' => 'El Campo Confirmar Contraseña es obligatorio',
            'password.same' => 'Las contraseñas no coinciden',
            'tipo.required' => 'El campo Role es obligatorio'
        ]);

        DB::transaction(function () {
            return tap(User::create([
                'name' => $this->name,
                'email' => $this->email,
                'tipo' => $this->tipo,
                'password' => Hash::make($this->password),
                'status' => $this->status,
            ]));
        });

        $this->mount();

        $this->resetFilters();

        return redirect()->route('users');
    }

    public function render()
    {
        return view('livewire.usuarios.user-form');
    }
}
