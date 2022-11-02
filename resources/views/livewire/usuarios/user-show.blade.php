<div>

    <x-jet-secondary-button wire:click="confirmShowUsuario({{ $user_show_id }})" wire:loading.attr="disabled" class=" btn-sm rounded-circle ml-2"
        data-target="ShowUsuario{{ $user_show_id }}">
        <i class="bi bi-eye-fill"></i>
    </x-jet-secondary-button>

    <x-jet-dialog-modal wire:model="ShowgUsuario" id="ShowUsuario{{ $user_show_id }}" maxWidth="md">
        <x-slot name="title">
            {{ __('Información General del Usuario:') }}
        </x-slot>

        <x-slot name="content">
            <div class="containerbx">
                <div class="card">
                    <div class="imgBx" data-text="{{("$this->name")}}">
                        <img src="{{ asset("$this->photo") }}" alt="" style="width:150px !important">
                    </div>
                    <div class="contentbx">
                        <div>
                            <div class="row d-inline align-middle">
                                <div class="mb-3 col-12">
                                    <x-jet-label value="{{ __('Nombre:') }}" />
                                    <label class="text-muted">
                                        {{ $this->name }}
                                    </label>
                                </div>
        
                                <div class="mb-3 col-12">
                                    <x-jet-label value="{{ __('Rol:') }}" />
                                    <label class="text-muted">
                                        {{ $this->tipo }}
                                    </label>
                                </div>
        
                                <div class="mb-3 col-12">
                                    <x-jet-label value="{{ __('E-mail:') }}" />
                                    <label class="text-muted">
                                        {{ $this->email }}
                                    </label>
                                </div>
                                <div class="mb-3 col-12">
                                    <x-jet-label value="{{ __('Estado:') }}" />
                                    <label class="text-muted">
                                        {{ $this->status }}
                                    </label>
                                </div>
                                <div class="mb-3 col-12">
                                    <x-jet-label value="{{ __('Registro:') }}" />
                                    <label class="text-muted">
                                        {{ $this->created_at }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-jet-secondary-button wire:click="$toggle('ShowgUsuario')" wire:loading.attr="disabled">
                Cerrar
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

