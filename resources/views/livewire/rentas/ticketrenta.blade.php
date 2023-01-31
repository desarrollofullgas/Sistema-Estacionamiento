<section id="Salidas">
    <div class="row">
        <div class="col-sm-12 col-md-6" x-data="{ isOpen: true }" @click.away="isOpen = false">
            <div class="card m-0 ps">
                <div class="card-header">
                    <div class="card-title">Datos Cliente</div>
                </div>
                <div class="card-body">
                    <div class="row mt-1" x-data="{ isOpen: true }" @click.away="isOpen = false">
                        <div class="col-md-8  ml-4">
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-search"></i></div>
                                </div>
                                <input type="text" class="form-control" placeholder="Buscar..."
                                    wire:model="buscarCliente" @focus="isOpen = true"
                                    @keydown.escape.window="isOpen = false" @keydown.shift.tab="isOpen = false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i wire:click.prevent="limpiarCliente()"
                                            class="bi bi-trash3" style="cursor: pointer"></i></div>
                                </div>
                            </div>
                            <ul class="list-group" x-show.transition.opacity="isOpen">
                                @if ($buscarCliente != '')
                                    @foreach ($clientes as $r)
                                        <li wire:click="mostrarCliente('{{ $r }}')"
                                            class="list-group-item list-group-item-action">
                                            <b>{{ $r->name }}</b> - <h7 class="text-info">Placa</h7>
                                            :{{ $r->placa }} - <h7 class="text-success">Marca</h7>
                                            :{{ $r->marca }} - <h7 class="text-secondary">Color</h7>
                                            :{{ $r->color }} 
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!--div datos de cliente -->
                    <div class="row mt-1">
                        <div class="form-group col-sm-12 col-md-6">
                            <h7>Nombre* </h7>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-person-lines-fill"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="name" class="form-control" maxlength="30"
                                    placeholder="ej: Nombre Apellido" id="nombre">
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <div class="form-group col-lg-2 col-md-2 col-sm-12">
                            <h7 class="text-info">Teléfono Fijo</h7>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-phone la-lg"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="telefono" class="form-control" maxlength="10"
                                    placeholder="ej: 351 000 0000">
                            </div>
                        </div> --}}
                        <div class="form-group col-sm-12 col-md-6">
                            <h7>Teléfono Celular</h7>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-telephone-fill"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="celular" class="form-control" maxlength="10"
                                    placeholder="ej: 999 99 99 99">
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <h7>E-Mail</h7>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-envelope-fill"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="email" class="form-control"
                                    placeholder="ej: fullgas@fullgas.com.mx">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h7>Dirección*</h7>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-signpost-split"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="direccion" class="form-control" maxlength="255"
                                    placeholder="Calle No. Col.">
                            </div>
                            @error('direccion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12 col-md-8">
                            <h7>Observaciones</h7>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-eyeglasses"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="concepto_multa" class="form-control"
                                    placeholder="ej: multa por vencimiento $50.00">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {{-- <button class="btn btn-dark" wire:click="$set('section',1)">
                        <i class="la la-chevron-left"></i> Regresar
                    </button> --}}
                    <a class="btn btn-dark btn-sm" href="{{url('rentas')}}"">
                        <i class="bi bi-arrow-return-left"></i> Regresar
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card m-0 ps">
                <div class="card-header">
                    <div class="card-title">Datos Vehículo</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <h7>Tipo de vehículo</h7>
                            <select wire:model="tipo" name="tipo" id="tipo" class="form-control text-center">
                                <option value="0">Elegir</option>
                                <option value="1">Automovil</option>
                                <option value="2">Motocicleta</option>
                                <option value="3">Camioneta</option>
                            </select>
                            {{-- <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-question-circle-fill"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="nota" class="form-control" maxlength="30"
                                    placeholder="ej: BORA">
                            </div> --}}
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <h7>Placa *</h7>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-credit-card-2-front-fill"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="placa" class="form-control" maxlength="7"
                                    placeholder="ej: F5T789">
                            </div>
                            @error('placa')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group  col-sm-12 col-md-4 mb-2">
                            <h7>Marca</h7>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-question-circle-fill"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="marca" class="form-control" maxlength="30"
                                    placeholder="ej: HONDA">
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-4 mb-2">
                            <h7>Modelo</h7>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-question-circle-fill"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="modelo" class="form-control" maxlength="30"
                                    placeholder="ej: 2001">
                            </div>
                        </div>
                        <div class="form-group  col-sm-12 col-md-4 mb-2">
                            <h7>Color</h7>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="bi bi-question-circle-fill"></i></div>
                                </div>
                                <input type="text" wire:model.lazy="color" class="form-control" maxlength="30"
                                    placeholder="ej: Azul">
                            </div>
                        </div>
                        <hr>
                        <div class="col-sm-12 col-md-4">
                            Tiempo
                            <select wire:model="tiempo" wire:change="getSalida()" class="form-control text-center">
                                <option value="0">Elegir</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    @if ($i == 1)
                                        <option value="{{ $i }}">{{ $i }} MES</option>
                                    @else
                                        <option value="{{ $i }}">{{ $i }} MESES</option>
                                    @endif
                                @endfor
                            </select>

                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group mb-0">Fecha de Ingreso
                                <input class="form-control" type="text"
                                    value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group mb-0">Fecha de Salida
                                <input wire:model="fecha_fin" class="form-control flatpickr flatpickr-input active"
                                    type="text">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group mb-0">Total Calculado
                                <input class="form-control total" type="text" disabled
                                    value="${{ number_format($totalCalculado, 2) }}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group mb-0">Total Manual
                                <input wire:model="total" class="form-control total" type="number" min="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row justify-content-between">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            @if ($tiempo > 0)
                                <button  wire:click.prevent="RegistrarTicketRenta()" 
                                    class="btn btn-dark mt-4" onclick="registrarTicket()">Registrar Entrada</button>
                            @endif
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12 text-right">
                            <div class="n-chk mt-4">
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input wire:model="printTicket" type="checkbox" class="new-control-input"
                                        checked>
                                    <span class="new-control-indicator"></span>Imprimir Recibo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</section>
<script>

</script>
