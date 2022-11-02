<div>
    <div class="text-center">
        <x-jet-button wire:click="showModalFormUsuario" class="btn-sm rounded-circle">
            <i class="bi bi-person-plus-fill"></i>
        </x-jet-button> <br>
        <span>Agregar Usuario</span>
    </div>

    <x-jet-dialog-modal wire:model="newgUsuario" id="modalUsuario">
        <x-slot name="title">
            Nuevo Usuario
        </x-slot>

        <x-slot name="content">
            <div class="row">
                <div class="mb-3 col-4">
                    <x-jet-label value="{{ __('Nombre') }}" />
                    <x-jet-input wire:model="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                        name="name" :value="old('name')" required autofocus autocomplete="off" />
                    <x-jet-input-error for="name"></x-jet-input-error>
                </div>

                {{-- <div class="mb-3 col-6">
                    <x-jet-label value="{{ __('Usuario') }}" />
                    <x-jet-input wire:model="username" class="{{ $errors->has('username') ? 'is-invalid' : '' }}"
                        type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                    <x-jet-input-error for="username"></x-jet-input-error>
                </div> --}}

                <div class="mb-3 col-4">
                    <x-jet-label value="{{ __('E-mail') }}" />
                    <x-jet-input wire:model="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        type="email" name="email" :value="old('email')" required autocomplete="off" />
                    <x-jet-input-error for="email"></x-jet-input-error>
                </div>

                <div class="mb-3 col-4">
                    <x-jet-label value="{{ __('Role') }}" />
                    <select id="tipo" wire:model="tipo"
                            class="form-select {{ $errors->has('tipo') ? 'is-invalid' : '' }}" 
                            name="tipo" required>
                            <option hidden value="">Elegir role</option>
                            <option value="Administrador" >Administrador</option>
                            <option value="Empleado" >Empleado</option>
                    </select>
                    <x-jet-input-error for="tipo"></x-jet-input-error>
                </div>

                <div class="mb-3 col-6">
                    <x-jet-label value="{{ __('Contraseña') }}" />
                    <x-jet-input wire:model="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        type="password" name="password" required autocomplete="off"
                        wire:keydown.enter="addUsuario" />
                    <x-jet-input-error for="password"></x-jet-input-error>
                </div>

                <div class="mb-3 col-6">
                    <x-jet-label value="{{ __('Confirmar Contraseña') }}" />
                    <x-jet-input class="form-control" type="password" wire:model="password_confirmation"
                        name="password_confirmation" required autocomplete="off"
                        wire:keydown.enter="addUsuario" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-jet-danger-button class="ml-2" wire:click="addUsuario" wire:loading.attr="disabled">
                Aceptar
            </x-jet-danger-button>
            <x-jet-secondary-button wire:click="$toggle('newgUsuario')" wire:loading.attr="disabled">
                Cancelar
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>


