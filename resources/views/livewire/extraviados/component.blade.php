<div class="content">
    @section('title', 'Extraviados')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Búsqueda de ticket Extraviado
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive scrollbar2 ps">
                    <table id="tabs" class="table mb-0 text-nowrap" style="width: 100%">
                        <thead class="bg-light" style="position: sticky ">
                            <tr class="bold">
                                <th class="border-bottom-0 text-center">Código</th>
                                <th class="border-bottom-0 text-center">Entrada</th>
                                <th class="border-bottom-0 text-center">Datos Vehículo</th>
                                <th class="border-bottom-0 text-center">Placa</th>
                                <th class="border-bottom-0 text-center">Tipo</th>
                                <th class="border-bottom-0 text-center">Total al Momento</th>
                                <th class="border-bottom-0 text-center">Dar Salida</th>
                            </tr>
                        </thead>
                        <tbody class="table_mov">
                            @foreach ($info as $r)
                                <tr class="item-mov text-center">
                                    <td>{{ $r->barcode }} </td>
                                    <td>{{ \Carbon\Carbon::parse($r->acceso)->format('d/m/Y h:m:s') }}</td>
                                    <td>{{ $r->descripcion }}</td>
                                    <td>{{ $r->placa }}</td>
                                    <td>
                                        @if ($r->vehiculo_id == null)
                                            VISITA
                                        @else
                                            RENTA
                                        @endif
                                    </td>
                                    <td>${{ $r->pago }} + $50.00 multa</td>
                                    <td>
                                        @can('extraviados_salidas')
                                            <a href="#" class="btn btn-dark btn-sm"
                                                onclick="eventCheckOut('{{ $r->barcode }}',{{$r->id}})"
                                                title="COBRAR Y DAR SALIDA DEL VEHÍCULO">
                                                <i class="bi bi-check2-circle"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <input type="hidden" id="barcode" />
                <input type="hidden" id="id" />
            </div>
            <!--MODAL-->
            <div class="modal fade" id="modalSalida" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmar</h5>
                        </div>
                        <div class="modal-body">
                            <h4 class="text-danger">¿Confirmas dar salida al vehículo?</h4>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-dark" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                                Cancelar</button>
                            <button type="button" class="btn btn-primary saveSalida">Aceptar</button>

                        </div>
                    </div>
                </div>
            </div>
            <!--/modal-->
        </div>
    </div>
</div>
<script type="text/javascript">
    function eventCheckOut(barcode,id) {
        $('#id').val(id);
        $('#barcode').val(barcode)
        $('#modalSalida').modal('show')
    }

    document.addEventListener('DOMContentLoaded', function() {

        $('body').on('click', '.saveSalida', function() {
            var code = $('#barcode').val()
            const id= $('#id').val();
            $('#modalSalida').modal('hide')
            window.livewire.emit('doCheckOut', code, 2)
            setTimeout(() => {
                var ruta = "{{ url('print/order') }}" + '/' + id;
                var w = window.open(ruta, "_blank", "width=400, height=600");
            },100);
        })

    })
</script>
