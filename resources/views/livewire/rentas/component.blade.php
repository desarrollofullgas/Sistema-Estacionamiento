<div class="content">
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    @if ($section == 1)
        <div class="colum--reverse">
            <div class="col-sm-12 col-md-12">
                <div class="card m-0-ps">
                    <div class="card-header">
                        <div class="card-title">Rentas. <span class="text-bold" style="color: #72f14c">(Desocupado</span>
                            <span class="text-bold text-danger">Ocupado)</span></div>
                    </div>
                    <div class="card-body scroll-div">
                        <div class="row">
                            @foreach ($cajones as $c)
                                @can('rentas_entradas_salidas')
                                    <div class="d-inline flex col-sm-12 col-md-3 mt-2">
                                        @if ($c->estatus == 'DISPONIBLE')
                                            <div id="{{ $c->tarifa_id }}" style="cursor: pointer;"
                                                data-status="{{ $c->estatus }}" data-id="{{ $c->id }}"
                                                onclick="openModal('{{ $c->tarifa_id }}','{{ $c->id }}')"
                                                class="cajondesoc ">
                                                {{ $c->descripcion }}
                                            </div>
                                        @else
                                            <div id="{{ $c->tarifa_id }}" style="cursor: pointer;"
                                                data-status="{{ $c->estatus }}" data-id="{{ $c->id }}"
                                                data-barcode="{{ $c->barcode }}"
                                                onclick="eventCheckOut('doCheckOut','{{ $c->barcode }}','2')"
                                                class="cajonoc ">
                                                {{ $c->descripcion }}
                                            </div>
                                        @endif
                                    </div>
                                @endcan
                            @endforeach
                        </div>
                    </div>
                    <input type="hidden" id="tarifa" />
                    <input type="hidden" id="cajon" />
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="card m-0 container-main">
                    {{-- <div class="card-header p-2 flex-wrap">
                        <div id="clockdate" class="w-100">
                            <div class="clockdate-wrapper">
                                <div id="clock">
                                    <div id="clock_time"></div>
                                    <span id="clock_ap"></span>
                                </div>
                                <div id="date"></div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                @can('rentas_buscar')
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                        </div>
                                        <input type="text" id="code" wire:keydown.enter="$emit('doCheckOut','',2)"
                                            wire:model="barcode" class="form-control" maxlength="9"
                                            placeholder="Buscar Código" autofocus>
                                        <div class="input-group-append">
                                            <span wire:click="$set('barcode','')" class="input-group-text "
                                                style="cursor:pointer; "><i class="bi bi-eraser-fill"></i> </span>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                            {{-- <div class="col-sm-12 col-md-3">
                                <x-jet-button class="btn btn-sm" wire:click.prevent="TicketVisita()">
                                    <i class="bi bi-printer"></i>
                                    TICKET DE VISITA
                                </x-jet-button>
                            </div> --}}
                            <div class="col-sm-12 col-md-3 ml-3">
                                @can('rentas_ticket_renta')
                                    <x-jet-button class="btn btn-sm" wire:click="$set('section', 3)">
                                        <i class="bi bi-printer"></i>
                                        TICKET DE RENTA
                                    </x-jet-button>
                                @endcan
                            </div>
                            {{-- ======================== --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--modal-->
        <div class="modal fade" id="modalRenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Entrada de Vehículo</h5>
                    </div>
                    <div class="modal-body">
                        <input type="text"
                            {{-- wire:keydown.enter="$emit('doCheckIn', $('#tarifa').val(),  $('#cajon').val(), 'DISPONIBLE', $('#comment').val() )" --}}
                            id="comment" maxlength="7" class="form-control text-center" placeholder="PLACA" autofocus
                            autocomplete="off" minlength="5">
                            
                        <div class="leyenda">
                            <button type="button" onclick="Placa()" class="btn btn-outline-danger">Registrar</button>
                            {{-- <small>Presiona Enter para Agregar</small>
                            <kbd class="kbc-button">
                                <i class="bi bi-arrow-return-left"></i>
                            </kbd> --}}
                            |
                            <small>Presiona Esc para Cerrar</small>
                            <kbd class="kbc-button">
                                Esc
                            </kbd>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button class="btn btn-dark" data-dismiss="modal"> Cancelar</button> --}}
                        {{-- <button type="button" class="btn btn-primary saveRenta">Guardar</button> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- modal salida --}}
        
        
    @elseif($section == 2)
        @include('livewire.rentas.salidas')
    @elseif($section == 3)
        @include('livewire.rentas.ticketrenta')
    @endif
</div>

<script>
   
    function Placa(){
        const textPlaca=document.getElementById("comment").value.toUpperCase();
        const Patron=/^[A-Z]{3}\w{4}$/;
        const PatronMoto=/^[0-9]{2}\w{4}$/;//2N3L1N
        //console.log(textPlaca);
        if(Patron.test(textPlaca) || PatronMoto.test(textPlaca)){
            
            livewire.emit('doCheckIn', $('#tarifa').val(),  $('#cajon').val(), 'DISPONIBLE', $('#comment').val() );
        }
        //console.log(Patron.test(textPlaca));
    }
    function genPDF(){
        window.livewire.on('print', ticket => {
            var ruta = "{{ url('print/order') }}" + '/' + ticket;
            var w = window.open(ruta, "_blank", "width=400, height=600");
            //w.close()  descomentar para que se cierre la ventana del ticket
        });
    }
    /* window.onload=()=>{
        startTime();
    } */
    function openModal(tarifa, cajon) {
        $('#tarifa').val(tarifa)
        $('#cajon').val(cajon)

        $('#modalRenta').modal('show')
        //startTime();
        window.livewire.on('print', ticket => {
            var ruta = "{{ url('printIn/order') }}" + '/' + ticket;
            var w = window.open(ruta, "_blank", "width=400, height=600");
            //w.close()  descomentar para que se cierre la ventana del ticket
        });
    }


    function eventCheckOut(eventName, barcode, actionValue) {
        console.log(eventName, barcode, actionValue)
        window.livewire.emit(eventName, barcode, actionValue)
        $('#modalRenta').modal('hide')
        $('#comment').val('')
        //genPDF();
    }


    document.addEventListener('DOMContentLoaded', function() {

        
        $('body').on('click', '.saveRenta', function() {
            var ta = $('#tarifa').val()
            var ca = $('#cajon').val()
            $('#modalRenta').modal('hide')
            window.livewire.emit('doCheckIn', ta, ca, 'DISPONIBLE', $.trim($('#comment').val()))

        })


        /* window.livewire.on('print', ticket => {
            var ruta = "{{ url('print/order') }}" + '/' + ticket;
            var w = window.open(ruta, "_blank", "width=400, height=600");
            //w.close()  descomentar para que se cierre la ventana del ticket
        }) */

       /*  window.livewire.on('print-pension', ticketP => {
            var ruta = "{{ url('ticket/pension') }}" + '/' + ticketP
            var w = window.open(ruta, "_blank", "width=100, height=100");
            //w.close()  descomentar para que se cierre la ventana del ticket
        }) */

        window.livewire.on('getin-ok', resultText => {
            $('#comment').val('')
            $('#modalRenta').modal('hide')
        })



        $('body').on('click', '.la-lg', function() {
            $('#exampleModal').modal('show');
        });



    })
</script>

{{-- <script src="{{ asset('js/main.js') }}" defer></script> --}}
<script src="{{ asset('js/onscan.js') }}"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            onScan.attachTo(document, {
                //configuración del sufijo/ tecla esperada al finalizar la lectura del scan, esto indica a onScan la finalización del evento
                suffixKeyCodes: [13],
                onScan: function(barcode) { //función callback que se dispara después de una lectura
                    console.log(barcode)
                    window.livewire.emit('doCheckOut', barcode,
                        2) //emitimos el evento para consultar la info y cobrar el ticket
                },
                onScanError: function(e) { //función callback para captura de errores de lectura
                    // toastr.error('', 'Error de lectura' + e) 
                }
            })
            toastr.success('', 'OnScan ready!')
        } catch (e) { //captura de errores generales de inicialización de onscan.js
            toastr.error('', 'Error OnScan' + e)
        }
    })
</script>