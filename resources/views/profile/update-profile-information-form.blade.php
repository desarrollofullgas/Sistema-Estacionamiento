@section('title', 'Actualizar Cuenta')
<x-jet-form-section submit="updateProfileInformation" >
    <x-slot name="title">
        {{ __('Información de Perfíl.') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Actualice la información de perfil y la dirección de correo electrónico de su cuenta.') }}
    </x-slot>

    <x-slot name="form" >

        <x-jet-action-message on="saved">
            {{ __('Actualizado.') }}
        </x-jet-action-message>

        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div class="mb-3" x-data="{photoName: null, photoPreview: null}">
                <!-- Profile Photo File Input -->
                <input type="file" hidden
                       wire:model="photo"
                       x-ref="photo"
                       x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Imagen de Perfíl') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    @if (Auth::user()->profile_photo_path)
                        <img class="h-8 w-8 rounded-full object-cover" src="/storage/{{Auth::user()->profile_photo_path }}" alt="{{ Auth::user()->name }}" />
                    @else
                        <img class="h-8 w-8 rounded-full object-cover" src="{{Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" /> 
                    @endif
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <img x-bind:src="photoPreview" class="rounded-circle" width="80px" height="80px">
                </div>

                <x-jet-button class="newimg rounded-circle btn mt-2 me-2 btn-sm" type="button" x-on:click.prevent="$refs.photo.click()"
                data-toggle="tooltip" rel="tooltip" data-placement="top" title="Cambiar Imagen">
                    <i class="bi bi-image-fill"></i>
				</x-jet-button>
				
				@if ($this->user->profile_photo_path)
                    <x-jet-danger-button type="button" class="deleteimg rounded-circle btn mt-2 btn-sm" wire:click="deleteProfilePhoto"
                    data-toggle="tooltip" rel="tooltip" data-placement="top" title="Remover Imagen">
                        {{-- <div wire:loading wire:target="deleteProfilePhoto" class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div> --}}

                        <i class="bi bi-trash3-fill"></i>
                    </x-jet-danger-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <div class="w-md-75">
            <!-- Name -->
            <div class="input-group mb-3">
                <div class="input-group-text" id="btnGroupAddon"><i class="fa-solid fa-user"></i></div>
                <x-jet-input id="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" wire:model.defer="state.name" type="text" placeholder="Nombre" aria-label="Input group example"
                    aria-describedby="btnGroupAddon"  autocomplete="name" required />
                <x-jet-input-error for="name"/>
            </div> 

            <!-- Email -->
            <div class="input-group mb-3">
                <div class="input-group-text" id="btnGroupAddon"><i class="fa-solid fa-envelope"></i></div>
                <x-jet-input id="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}" wire:model.defer="state.email" type="email" placeholder="Correo Electronico" aria-label="Input group example"
                    aria-describedby="btnGroupAddon"/>
                <x-jet-input-error for="email"/>
            </div>
        </div> 
    </x-slot>

    <x-slot name="actions">
		<div class="d-flex align-items-baseline">
			<x-jet-button class="btn-sm">
                {{-- <div wire:loading class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div> --}}

				{{ __('Actualizar') }}
			</x-jet-button>
		</div>
    </x-slot>
</x-jet-form-section>