    <div class="content">
        @section('title','Tipos')
        <x-slot name="header">
            {{-- topmenu --}}
        </x-slot>
        <div class="row">
            @if ($action == 1)

                <div class="col-sm-12 col-md-10">
                    <div class="card m-0 ps">
                        <div class="card-header">
                            <div class="card-title">Tipos de Vehículos.</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive scrollbar2 ps">
                                <div class="table-responsive">
                                    <table id="tabs" class="table mb-0 text-nowrap" style="width: 100%">
                                        <thead class="bg-light" style="position: sticky">
                                            <tr class="bold">
                                                <th class="border-bottom-0 text-center">ID</th>
                                                <th class="border-bottom-0 text-center">Tipo Vehículo</th>
                                                <th class="border-bottom-0 text-center">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table_mov">
                                            @foreach ($info as $r)
                                                <tr class="item-mov text-center">
                                                    <td>{{ $r->id }}</td>
                                                    <td>{{ $r->name }}</td>
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
                            @include('livewire.tipos.form')
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
                @include('common.search', ['create' => 'tipos_create'])
            </div>
        </div>
    </div>
    </div>
    @include('common.alerts')



    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('fileChoosen', () => {
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
                    window.livewire.emit('deleteRow', id)
                    // toastr.success('info', 'Registro eliminado con éxito')
                    swal.close()
                })

        }
    </script>
