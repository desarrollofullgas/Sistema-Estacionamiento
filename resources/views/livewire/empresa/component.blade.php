<div class="content">
    @section('title', 'Empresa')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            @include('common.alerts')
            <div class="card m-0 ps">
                <div class="card-header">
                    <div class="card-title">Datos de la Empresa.</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Nombre*</label>
                            <input wire:model.lazy="nombre" type="text" class="form-control text-left">
                            @error('nombre')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <label>Teléfono*</label>
                            <input wire:model.lazy="telefono" maxlength="10" type="text"
                                class="form-control text-center">
                            @error('telefono')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <label>Email*</label>
                            <input wire:model.lazy="email" maxlength="55" type="text"
                                class="form-control text-center">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <label>Logo</label>
                            <input type="file" class="form-control" id="image"
                                wire:change="$emit('fileChoosen',this)" accept="image/x-png,image/gif,image/jpeg">
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Dirección*</label>
                            <input wire:model.lazy="direccion" type="text" class="form-control text-left">
                            @error('direccion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @can('empresa_create')
                        <button type="button"wire:click="Guardar()"class="btn btn-dark btn-sm text-white">
                            <i class="bi bi-download text-white"></i> Guardar Datos
                        </button> 
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('fileChoosen', () => {

            let inputField = document.getElementById('image')
            let file = inputField.files[0]
            let reader = new FileReader()
            reader.onloadend = () => {
                window.livewire.emit('logoUpload', reader.result)
            }
            reader.readAsDataURL(file)
        })
    })
</script>
