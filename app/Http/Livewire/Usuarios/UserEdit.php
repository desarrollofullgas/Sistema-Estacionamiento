<?php

namespace App\Http\Livewire\Usuarios;

use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UserEdit extends Component
{
    public $EditUsuario;
    public $user_edit_id, $email, $name, $status,  $password, $password_confirmation, $tipo;

    public function resetFilters()
    {
        $this->reset(['name', 'email', 'password','status', 'tipo']);
    }

    public function mount()
    {
        $this->EditUsuario = false;
    }

    public function confirmUserEdit(int $id)
    {
        $user = User::where('id', $id)->first();

        $this->user_edit_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status;
        $this->tipo = $user->tipo;

        $this->EditUsuario = true;
    }

    public function EditarUsuario($id)
    {
        $user = User::where('id', $id)->first();

        $this->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:40', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'confirmed', Password::min(8)],
            'password_confirmation' => ['same:password'],
            'status' => ['required', 'not_in:0'],
            'tipo' => ['required', 'not_in:0'],
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
            'status.required' => 'El Campo Status es obligatorio',
            'tipo.required' => 'El Campo Tipo es obligatorio',
        ]);

        if (
            $this->email !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user);
        } else {
            $user->forceFill([
                'name' => $this->name,
                'email' => $this->email,
                'status' => $this->status,
                'tipo' => $this->tipo,
            ])->save();
        }

        if (!empty($this->password)) {
            $user->forceFill([
                'password' => Hash::make($this->password),
            ])->save();
        } else {
            $user->forceFill([
                'name' => $this->name,
                'email' => $this->email,
                'tipo' => $this->tipo,
                'status' => $this->status,
            ])->save();
        }

        $this->mount();

        $this->resetFilters();

        return redirect()->route('users');
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user)
    {
        $user->forceFill([
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => null,
            'tipo' => $this->tipo,
            'status' => $this->statld,
        ])->save();

        $user->sendEmailVerificationNotification();
    }

    public function render()
    {
        return view('livewire.usuarios.user-edit');
    }
}
