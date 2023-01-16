<section id="Salidas">
    <div class="content">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Registrar Salida.</div>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-dark" href="{{ url('rentas') }}">
                            <i class="la la-chevron-left"></i>
                        </a>
                        <hr>
                        <!--row barcode-->
                        <div class="row mt-4">
                            <div class="col-4">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <small class="text-danger">{{ $error }}</small>
                                    @endforeach
                                @endif

                                @can('rentas_cobrar_ticket')
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                        </div>
                                        <input type="text" id="code" wire:keydown.enter="BuscarTicket()"
                                            wire:model="barcode" class="form-control" maxlength="9"
                                            placeholder="Ingresa el número de ticket o Escanea el código de barras"
                                            autofocus>
                                        <div class="input-group-append ml-4">
                                            <span wire:click="BuscarTicket()" script="" class="input-group-text "
                                                style="cursor:pointer; "><i class="la la-print la-lg "></i> Salida de
                                                Vehículo</span>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </div>
                        <!--row info ticket y cobro -->
                        <div class="row">

                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="col-sm-12">
                                    <h6><b>Folio</b>: {{ $obj->id }} </h6>
                                    <input type="hidden" id="ticketid" value="{{ $obj->id }}" />
                                </div>
                                <div class="col-sm-12">
                                    <h6><b>Estatus</b>: {{ $obj->estatus }} </h6>
                                </div>
                                <div class="col-sm-12">
                                    <h6><b>Tarifa</b>: ${{ number_format($obj->tarifa->costo, 2) }} </h6>
                                </div>
                                <div class="col-sm-12">
                                    <h6><b>Acceso</b>: {{ \Carbon\Carbon::parse($obj->acceso)->format('d/m/Y h:m:s') }}
                                    </h6>
                                </div>
                                <div class="col-sm-12">
                                    <h6><b>Barcode</b>: {{ $obj->barcode }} </h6>
                                </div>
                                @if (strlen($obj->descripcion) > 0)
                                    <div class="col-sm-12">
                                        <h6><b>Placa</b>: {{ $obj->descripcion }} </h6>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <blockquote class="blockquote text-center">
                                    <h5><b>Cobro hasta el momento</b></h5>
                                    <h6><i class="bi bi-alarm"></i> Tiempo Transcurrido: {{ $obj->tiempo }} </h6>
                                    <h6><i class="bi bi-currency-dollar"></i> Total: ${{ number_format($obj->total, 2) }} </h6>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
