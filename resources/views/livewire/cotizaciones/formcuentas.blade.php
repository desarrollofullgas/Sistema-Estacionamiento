<div class="widget-content-area ">
	<div class="widget-one">
		<form>			
			<div class="row">				
				<h5 class="col-12 text-center">Gestión de Abonos</h5>
				<div class="form-group col-lg-9 col-md-9 col-sm-12">
					<label ><b>Operadora </b></label>
					<textarea wire:model.lazy="operadora" cols="10" rows="1" class="form-control text-left"  placeholder="BestDay..."></textarea>		
					 @error('operadora') <span class="text-danger">{{ $message }}</span> @enderror		
				</div>
				<div class="form-group col-lg-3 col-md-3 col-sm-12">
					<label ><b>Estatus</b></label>
					<select wire:model="estatus" class="form-control" {{ $estatus !='Pagado' ? '' : 'disabled' }}  >
						<option value="Pendiente">Pendiente</option>
						<option value="Pagado">Pagado</option>
						<option value="Cancelada">Cancelada</option>
					</select>
				</div>

 

				<div class="form-group col-lg-3 col-sm-12 mb-3">
					<label ><b>Precio Adulto</b></label>
					<input wire:model.lazy="precioadulto" type="number" class="form-control"  placeholder="$0.00"
					{{ $estatus !='Pagado' ? '' : 'disabled' }} >
					 @error('precioadulto') <span class="text-danger">{{ $message }}</span> @enderror
				</div>
				<div class="form-group col-lg-3 col-sm-12 mb-3">
					<label ><b>Precio Jr</b></label>
					<input wire:model.lazy="preciojr" type="number" class="form-control"  placeholder="$0.00"
					{{ $estatus !='Pagado' ? '' : 'disabled' }} >
					 @error('preciojr') <span class="text-danger">{{ $message }}</span> @enderror
				</div>
				<div class="form-group col-lg-3 col-sm-12 mb-3">
					<label ><b>Precio Menor</b></label>
					<input wire:model.lazy="preciomenor" type="number" class="form-control"  placeholder="$0.00"
					{{ $estatus !='Pagado' ? '' : 'disabled' }} >
					 @error('preciomenor') <span class="text-danger">{{ $message }}</span> @enderror
				</div>

				
				<div class="form-group col-lg-3 col-md-3 col-sm-12">
					<label ><b>Total</b></label>
					<input wire:model.lazy="total" type="number" min="0" class="form-control text-center" placeholder="$0.00"
					{{ $estatus !='Pagado' ? '' : 'disabled' }} >
					 @error('total') <span class="text-danger">{{ $message }}</span> @enderror
				</div>				
				

				
			</div>
			<div class="row ">
				<div class="col-lg-5 mt-2  text-left">
					
					<button type="button" wire:click="doAction(1)" class="btn btn-dark mr-1">
					<i class="mbri-left"></i> Regresar
					</button>
					@if($selected_id >0)
					<button type="button" wire:click="Update() "
					class="btn btn-primary ml-2">
					<i class="mbri-success"></i> Actualizar
					</button>
					@else
					<button type="button" wire:click="Store() "
					class="btn btn-primary ml-2">
					<i class="mbri-success"></i> Guardar
					</button>
					@endif
				</div>
			</div>
		</form>
	</div>
</div>