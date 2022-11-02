<div class="content">
    @section('title','Cajones')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="row">
        @if ($action == 1)
            <div class="col-sm-12 col-md-10">
                <div class="card m-0 ps">
                    <div class="card-header">
                        <div class="card-title">Cajones del sistema.</div>
                    </div>
                    @include('common.alerts')
                    <div class="card-body">
                        <div class="table-responsive scrollbar2 ps">
                            <table id="tabs" class="table mb-0 text-nowrap" style="width: 100%">
                                <thead class="bg-light" style="position: sticky ">
                                    <tr class="bold">
                                        <th class="border-bottom-0 text-center">Id</th>
                                        <th class="border-bottom-0 text-center">Descripción</th>
                                        <th class="border-bottom-0 text-center">Tipo</th>
                                        <th class="border-bottom-0 text-center">Status</th>
                                        <th class="border-bottom-0 text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="table_mov">
                                    @foreach ($info as $r)
                                        <tr class="item-mov text-center">
                                            <td>{{ $r->id }}</td>
                                            <td>{{ $r->descripcion }}</td>
                                            <td>{{ $r->tipo }}</td>
                                            <td>{{ $r->estatus }}</td>
                                            <td class="text-center">
                                                @include('common.actions', [
                                                    'edit' => 'cajones_edit',
                                                    'destroy' => 'cajones_destroy',
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif($action == 2)
                    @include('livewire.cajones.form')
        @endif
    </div>
</div>
<div class="col-sm-12 col-md-2">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Menu.</div>
        </div>
        <div class="card-body">
            @include('common.search', ['create' => 'tarifas_create'])
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
    function Confirm(id)
    {
       let me = this
       swal({
        title: 'CONFIRMAR',
        text: '¿DESEAS ELIMINAR EL REGISTRO?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        closeOnConfirm: false
    },
    function() {
        console.log('ID', id);
        window.livewire.emit('deleteRow', id)    
        //toastr.success('info', 'Registro eliminado con éxito')
        swal.close()   
    })   
   }
</script>
