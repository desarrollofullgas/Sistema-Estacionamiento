<div class="content">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Gestionar Cajones.</div>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-4">
                        <label>Nombre del Cajón</label>
                        <input wire:model.lazy="descripcion" type="text" class="form-control" placeholder="nombre">
                        @error('descripcion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-4">
                        <label>Tipo</label>
                        <select wire:model="tipo" class="form-control text-center">
                            <option value="Elegir" disabled="">Elegir</option>
                            @foreach ($tipos as $t)
                                <option value="{{ $t->id }}">
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-4">
                        <label>Status</label>
                        <select wire:model="estatus" class="form-control text-center">
                            <option value="DISPONIBLE">DISPONIBLE</option>
                            <option value="OCUPADO">OCUPADO</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="button" wire:click="doAction(1)" class="btn btn-dark mr-1">
                <i class="mbri-left"></i> Regresar
            </button>
            <button type="button" wire:click="StoreOrUpdate() " class="btn btn-primary ml-2">
                <i class="mbri-success"></i> Guardar
            </button>
        </div>
    </div>
</div>
