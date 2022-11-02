<div class="content">
    @section('title','Movimientos')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    @if ($action == 1)
        <div class="row">
            <div class="col-sm-12 col-md-10">
                <div class="card m-0 ps">
                    <div class="card-header">
                        <div class="card-title">Movimientos de Caja.</div>
                    </div>
                    @include('common.alerts')
                    <div class="card-body">
                        <div class="table-responsive scrollbar2 ps">
                            <table id="tabs" class="table mb-0 text-nowrap ps" style="width: 100%">
                                <thead class="bg-light" style="position: sticky">
                                    <tr class="bold">
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Tipo</th>
                                        <th class="text-center">Monto</th>
                                        <th class="text-center">Comprobante</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="table_mov">
                                    @foreach ($info as $r)
                                        <tr class="item-mov text-center">
                                            <td class="text-center">{{ $r->concepto }}</td>
                                            <td class="text-center">{{ $r->tipo }}</td>
                                            <td class="text-center">${{ $r->monto }}</td>
                                            <td class="text-center">
                                                <img class="rounded" src="img/images/{{ $r->comprobante }}"
                                                    alt="" height="40">
                                            </td>
                                            <td class="text-center">{{ $r->created_at }}</td>
                                            <td class="text-center" class="text-center">
                                                @include('common.actions', [
                                                    'edit' => 'movimientos_edit',
                                                    'destroy' => 'movimientos_destroy',
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Menú.</div>
                    </div>
                    <div class="card-body">
                        @include('common.search', ['create' => 'movimientos_create'])
                    </div>
                </div>
            </div>
        </div>
    @elseif($action > 1)
        @include('livewire.movimientos.form')
    @endif
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('fileChoosen', () => {
            console.log($(this))
            let inputField = document.getElementById('image')
            let file = inputField.files[0]
            let reader = new FileReader();
            reader.onloadend = () => {
                window.livewire.emit('fileUpload', reader.result)
            }
            reader.readAsDataURL(file);
        })

    })

    function Confirm(id) {

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
                toastr.success('info', 'Registro eliminado con éxito')
                swal.close()
            })




    }
</script>
