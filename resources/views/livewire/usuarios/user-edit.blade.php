<div>
    
    <x-jet-button class="rounded-circle btn-sm ml-4" wire:click="confirmUserEdit({{ $user_edit_id }})" wire:loading.attr="disabled" 
               data-target="EditUsuario{{ $user_edit_id }}">
        <i class="bi bi-pencil-square"></i>
    </x-jet-button>

    <x-jet-dialog-modal wire:model="EditUsuario" id="EditUsuario{{ $user_edit_id }}">
        <x-slot name="title">
            {{ __('Editar Usuario') }}
        </x-slot>

        <x-slot name="content">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <x-jet-label value="{{ __('Nombre') }}" />
                            <x-jet-input wire:model="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                                        :value="old('name')" required autofocus autocomplete="name" />
                            <x-jet-input-error for="name"></x-jet-input-error>
                        </div>

                        {{-- <div class="mb-3 col-6">
                            <x-jet-label value="{{ __('Usuario') }}" />
                            <x-jet-input wire:model="username" class="{{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username"
                                        :value="old('username')" required autofocus autocomplete="username" />
                            <x-jet-input-error for="username"></x-jet-input-error>
                        </div> --}}
        
                        <div class="mb-3 col-6">
                            <x-jet-label value="{{ __('E-mail') }}" />
                            <x-jet-input wire:model="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
                                        :value="old('email')" required />
                            <x-jet-input-error for="email"></x-jet-input-error>
                            </div>
                            <div class="mb-3 col-6" wire:ignore>
                                <x-jet-label value="{{ __('Role') }}" />
                                <select id="tipo" wire:model="tipo"
                                        class="select-tipo form-select {{ $errors->has('tipo') ? 'is-invalid' : '' }}" 
                                        name="tipo" required aria-required="true">
                                        <option hidden value="">Seleccionar tipo</option>
                                        <option value="Administrador" @if ($tipo == 'Administrador') {{ 'selected' }} @endif>Administrador</option>
                                        <option value="Empleado" @if ($tipo == 'Empleado') {{ 'selected' }} @endif>Empleado</option>
                                </select>
                                <x-jet-input-error for="tipo"></x-jet-input-error>
                            </div>
                            <div class="mb-3 col-6" wire:ignore>
                                <x-jet-label value="{{ __('Status') }}" />
                                <select id="status" wire:model="status"
                                        class="select-status form-select {{ $errors->has('status') ? 'is-invalid' : '' }}" 
                                        name="status" required aria-required="true">
                                        <option hidden value="">Seleccionar Status</option>
                                        <option value="Activo" @if ($status == 'Activo') {{ 'selected' }} @endif>Activo</option>
                                        <option value="Inactivo" @if ($status == 'Inactivo') {{ 'selected' }} @endif>Inactivo</option>
                                </select>
                                <x-jet-input-error for="status"></x-jet-input-error>
                            </div>
                        <div class="mb-3 col-6">
                            <x-jet-label value="{{ __('Contraseña') }}" />
                            <x-jet-input wire:model="password"  type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                                        name="password" autocomplete="new-password" wire:keydown.enter="EditarUsuario" />
                            <x-jet-input-error for="password"></x-jet-input-error>
                        </div>
        
                        <div class="mb-3 col-6">
                            <x-jet-label value="{{ __('Confirmar Contraseña') }}" />
                            <x-jet-input class="form-control" type="password" wire:model="password_confirmation" name="password_confirmation" autocomplete="new-password" 
                            wire:keydown.enter="EditarUsuario({{ $user_edit_id }})" />
                        </div>
                    </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-jet-danger-button class="ml-2" wire:click="EditarUsuario({{ $user_edit_id }})" wire:loading.attr="disabled">
                Aceptar
            </x-jet-danger-button>

            <x-jet-secondary-button wire:click="$toggle('EditUsuario')" wire:loading.attr="disabled">
                Cancelar
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
