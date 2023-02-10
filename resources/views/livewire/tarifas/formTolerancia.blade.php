<div class="content">
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                   
                    <div class="form-group col-sm-12">
                        <label>Tiempo de tolerancia</label>
                        <label for="tolerancia" class="flex__horizontal">
                            0 <input wire:model="tolerancia" type="range" class="form-range text-center"
                            placeholder="minutos" min="0" max="10"> 10
                        </label>
                        
                           <p><b>{{$tolerancia}} minutos</b></p> 
                        @error('costo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="button" wire:click="doAction(1)" class="btn btn-dark mr-1">
                <i class="mbri-left"></i> Regresar
            </button>
            <button type="button" wire:click="StoreTolerance() " class="btn btn-primary ml-2">
                <i class="mbri-success"></i> Guardar
            </button>
        </div>
    </div>
</div>