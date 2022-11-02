<div class="content">
    <div class="row">
        <div class="col-sm-12 col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Crear/Editar Movimientos</div>
                </div>
                @include('common.messages')
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-4">
                            <label>Tipo</label>
                            <select wire:model.lazy="tipo" class="form-control text-center">
                                <option value="Elegir">Elegir</option>
                                <option value="Ingreso">Ingreso</option>
                                <option value="Gasto">Gasto</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label>Monto</label>
                            <input wire:model.lazy="monto" type="number" class="form-control text-center"
                                placeholder="Ej: 100.00">
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label>Comprobante</label>
                            <input id="image" wire:change="$emit('fileChoosen',this)"
                                accept="image/x-png,image/gif,image/jpeg" type="file"
                                class="form-control text-center">
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <label>Ingresa la descripción</label>
                            <input wire:model.lazy="concepto" type="text" class="form-control" placeholder="...">
                        </div>
                    </div>
                </div>
				<div class="card-footer">
					<button type="button" wire:click="doAction(1)" class="btn btn-dark mr-1">
						<i class="mbri-left"></i> Regresar
					</button>
					<button type="button"
					wire:click="StoreOrUpdate() " 
					class="btn btn-primary ml-2">
					<i class="mbri-success"></i> Guardar
				</button>
				</div>
            </div>
        </div>
    </div>
</div>
