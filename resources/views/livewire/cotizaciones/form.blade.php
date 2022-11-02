<div class="widget-content-area ">
	<div class="widget-one">
		<form>			
			<div class="row">				
				
				<div class="form-group col-lg-12 col-md-12 col-sm-12">
					<label ><b>Información del viaje</b></label>
					<textarea wire:model.lazy="descripcion" cols="10" rows="4" class="form-control text-left"  placeholder="viaje a manzanillo...."></textarea>		
					 @error('descripcion') <span class="text-danger">{{ $message }}</span> @enderror		
				</div>

				<div class="form-group col-lg-8 col-sm-12 mb-8">
					<label ><b>Nombre del titular</b></label>
					<input wire:model.lazy="titular" type="text" class="form-control"  placeholder="cliente">
					 @error('titular') <span class="text-danger">{{ $message }}</span> @enderror
				</div>
				<div class="form-group col-lg-2 col-md-2 col-sm-12">
					<label ><b>Fecha de salida</b></label>
					<input wire:model.lazy="salida" type="date" class="form-control flatpickr flatpickr-input active" >
					 @error('salida') <span class="text-danger">{{ $message }}</span> @enderror
				</div>
				<div class="form-group col-lg-2 col-md-2 col-sm-12">
					<label ><b>Fecha de regreso</b></label>
					<input wire:model.lazy="regreso" type="date" class="form-control flatpickr flatpickr-input active" >
					 @error('regreso') <span class="text-danger">{{ $message }}</span> @enderror
				</div>

				<div class="form-group col-lg-2 col-md-2 col-sm-12">
					<label ><b>Adultos</b></label>
					<input wire:model.lazy="adultos" type="number" min="0" class="form-control text-center" >
				</div>
				<div class="form-group col-lg-2 col-md-2 col-sm-12">
					<label ><b>Menores</b></label>
					<input wire:model.lazy="menores" type="number" min="0" class="form-control text-center" >
				</div>
				<div class="form-group col-lg-2 col-md-2 col-sm-12">
					<label ><b>Infantes</b></label>
					<input wire:model.lazy="infantes" type="number" min="0" class="form-control text-center" >
				</div>
				<div class="form-group col-lg-2 col-md-2 col-sm-12">
					<label ><b>Total</b></label>
					<input wire:model.lazy="total" type="number" min="0" class="form-control text-center" >
					 @error('total') <span class="text-danger">{{ $message }}</span> @enderror
				</div>
				<div class="form-group col-lg-2 col-md-2 col-sm-12">
					<label ><b>Anticipo</b></label>
					<input wire:model.lazy="anticipo" type="number" min="0" class="form-control text-center" >
				</div>
				<div class="form-group col-lg-2 col-md-2 col-sm-12">
					<label ><b>Estatus</b></label>
					<select wire:model="estatus" class="form-control">
						<option value="Pendiente">Pendiente</option>
						<option value="Pagada">Pagada</option>
						<option value="Cancelada">Cancelada</option>
					</select>
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