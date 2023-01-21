<div class="content">
    @section('title','Tarifas')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="row">
        @if ($action == 1)

            <div class="col-sm-12 col-md-10">
                <div class="card m-0 ps">
                    <div class="card-header">
                        <div class="card-title">Tarifas del sistema.</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive scrollbar2 ps">
                            <div class="table-responsive">
                                <table id="tabs" class="table mb-0 text-nowrap" style="width: 100%">
                                    <thead class="bg-light" style="position: sticky">
                                        <tr class="bold">
                                            <th class="border-bottom-0 text-center">ID</th>
                                            <th class="border-bottom-0 text-center">Tiempo</th>
                                            <th class="border-bottom-0 text-center">Descripcion</th>
                                            <th class="border-bottom-0 text-center">Costo</th>
                                            <th class="border-bottom-0 text-center">Tipo</th>
                                            <th class="border-bottom-0 text-center">Jerarquia</th>
                                            <th class="border-bottom-0 text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table_mov">
                                        @foreach ($info as $r)
                                            <tr class="item-mov text-center">
                                                <td>{{ $r->id }}</td>
                                                <td>{{ $r->tiempo }}</td>
                                                <td>{{ $r->descripcion }}</td>
                                                <td>${{ number_format($r->costo,2,'.',',') }}</td>
                                                <td>{{ $r->tipo }}</td>
                                                <td>{{ $r->jerarquia }}</td>
                                                <td>
                                                    @include('common.actions', [
                                                        'edit' => 'tipos_edit',
                                                        'destroy' => 'tipos_destroy',
                                                    ])
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @elseif($action == 2)
                        @include('livewire.tarifas.form')
        @endif
    </div>

</div>
</div>
<div class="col-sm-12 col-md-2">
    <div class="card m-0">
        <div class="card-header">
            <div class="card-title">Menú.</div>
        </div>
        <div class="card-body">
            @include('common.search', ['create' => 'tarifas_create'])
        </div>
    </div>
</div>
</div>
@include('common.alerts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.0.2/cleave.min.js"></script>    
<script type="text/javascript">         

 document.addEventListener('DOMContentLoaded', function () { 

    $('body').on('keyup','.numeric', function(){
         new Cleave('.numeric', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });

    })
})
 function Confirm(id)
 {
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