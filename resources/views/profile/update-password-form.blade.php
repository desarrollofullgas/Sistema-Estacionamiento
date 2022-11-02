<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Actualizar Contraseña') }}
    </x-slot>

    <x-slot name="description">
        {{ __(' Asegúrese de que su cuenta esté usando una contraseña larga y aleatoria para mantenerse seguro.') }}
        <small class="text-muted">Ej.: <span class="txt-pass">Abc123@k9</span></small>
    </x-slot>

    <x-slot name="form">
        <div class="w-md-75">
            <div class="input-group mb-3">
                <div class="input-group-text" id="btnGroupAddon"><i class="fa-solid fa-lock"></i></div>
                <x-jet-input id="current_password" class="{{ $errors->has('current_password') ? 'is-invalid' : '' }}" wire:model.defer="state.current_password" type="password" placeholder="Contraseña Actual" aria-label="Input group example"
                    aria-describedby="btnGroupAddon"  autocomplete="current_password"/>
                <x-jet-input-error for="current_password"/>
            </div> 

            <div class="input-group mb-3">
                <div class="input-group-text" id="btnGroupAddon"><i class="fa-solid fa-lock"></i></div>
                <x-jet-input id="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" wire:model.defer="state.password" type="password" placeholder="Nueva Contraseña" aria-label="Input group example"
                    aria-describedby="btnGroupAddon"  autocomplete="new-password" required />
                <x-jet-input-error for="password"/>
            </div> 

            <div class="input-group mb-3">
                <div class="input-group-text" id="btnGroupAddon"><i class="fa-solid fa-unlock"></i></div>
                <x-jet-input id="password_confirmation" class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" wire:model.defer="state.password_confirmation" type="password" placeholder="Confirmar Nueva Contraseña" aria-label="Input group example"
                    aria-describedby="btnGroupAddon"  autocomplete="new-password" required />
                <x-jet-input-error for="password_confirmation"/>
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button class="btn-sm">
            {{-- <div wire:loading class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div> --}}

            {{ __('Actualizar') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
