<div class="content">
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="row">
        @if ($action == 1)
            <div class="col-sm-12 col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Historial de cajas.</div>
                    </div>
                    @include('common.alerts')
                    <div class="card-body">
                        <div class="table-responsive scrollbar2 ps">
                            <table id="tabs" class="table mb-0 text-nowrap" style="width: 100%">
                                <thead class="bg-light" style="position: sticky ">
                                    <tr class="bold">
                                        <th class="border-bottom-0 text-center">Id</th>
                                        <th class="border-bottom-0 text-center">Monto</th>
                                        <th class="border-bottom-0 text-center">Tipo</th>
                                        <th class="border-bottom-0 text-center">Concepto</th>
                                        <th class="border-bottom-0 text-center">Usuario</th>
                                        <th class="border-bottom-0 text-center">Comporbante</th>
                                        <th class="border-bottom-0 text-center">Fecha</th>
                                        <th class="border-bottom-0 text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="table_mov">
                                    @foreach ($info as $r)
                                        <tr class="item-mov text-center">
                                            <td>
                                                <p class="mb-0">{{ $r->id }}</p>
                                            </td>
                                            <td>${{ $r->monto }}</td>
                                            <td>{{ $r->tipo }}</td>
                                            <td>{{ $r->concepto }}</td>
                                            <td>{{ $r->nombre }}</td>
                                            <td>
                                                <img class="rounded" src="images/{{ $r->comprobante }}" alt=""
                                                    height="40">
                                            </td>
                                            <td>{{ $r->created_at }}</td>
                                            <td>
                                                @include('common.actions', [
                                                    'edit' => 'cajas_edit',
                                                    'destroy' => 'cajas_destroy',
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif($action == 2)
                    @include('livewire.cajas.form')
        @endif
    </div>
</div>
<div class="col-sm-12 col-md-10">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Menú.</div>
        </div>
        <div class="card-body">
            @include('common.search', ['create' => 'cajas_create'])
        </div>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
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
        });
    });

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
