<div class="content">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <b>
                    @if ($selected_id == 0)
                        Crear Nuevo Tipo
                    @else
                        Editar Tipo
                    @endif
                </b>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <label>Descripción</label>
                    {{-- <div class="input-group ">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-edit-2">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nombre del tipo"
                            wire:model.lazy="name">
                    </div> --}}
                    <select wire:model="name" name="name" id="name" class="form-control text-center">
                        <option value="Bicicleta">Bicicleta</option>
                        <option value="Automovil">Automovil</option>
                        <option value="Motocicleta">Motocicleta</option>
                        <option value="Camioneta">Camioneta</option>
                        <option value="Trailer">Trailer</option>
                    </select>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" wire:click="doAction(1)" class="btn btn-dark mr-1">
                <i class="mbri-left"></i> Regresar
            </button>
            <button type="button" wire:click="StoreOrUpdate() " class="btn btn-primary">
                <i class="mbri-success"></i> Guardar
            </button>
        </div>
    </div>
</div>
