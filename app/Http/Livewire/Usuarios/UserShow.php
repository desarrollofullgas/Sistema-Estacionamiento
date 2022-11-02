<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\User;
use Livewire\Component;

class UserShow extends Component
{
    public $ShowgUsuario;
    public $user_show_id;
    public $photo, $name, $status, $email, $created_at, $tipo;

    public function mount()
    {
        $this->ShowgUsuario = false;
    }

    public function confirmShowUsuario(int $id){
        $user = User::where('id', $id)->first();

        $this->user_show_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;

        $this->status = $user->status;
        $this->tipo = $user->tipo;
        $this->created_at = $user->created_at;
        $this->photo = $user->profile_photo_url;

        $this->ShowgUsuario=true;
    }
    public function render()
    {
        return view('livewire.usuarios.user-show');
    }
}
