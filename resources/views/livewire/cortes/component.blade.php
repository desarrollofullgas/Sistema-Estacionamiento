<div class="content">
    @section('title', 'Corte')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="card m-0 ps">
        <div class="card-header">
            <div class="card-title">Corte de caja.</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-2 col-lg-2">Elige Fecha
                    <div class="form-group">
                        <input wire:model.lazy="fecha" class="form-control flatpickr flatpickr-input active"
                            type="text" placeholder="Haz click">
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="form-group">Elige Operador
                        <select wire:model="user" class="form-control">
                            <option value="todos">Todos</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-1 col-lg-1">
                    @if ($fecha != '')
                        @can('cortes_create')
                            <button type="button" wire:click.prevent="Consulta()"
                                class="btn btn-info mt-4 ">Consultar</button>
                        @endcan
                    @endif
                </div>

                <div class="col-sm-12 col-md-2 col-lg-2 text-center">
                    @can('cortes_create')
                        <button type="button" wire:click.prevent="Balance()" class="btn btn-dark mt-4 ">Corte de
                            Hoy</button>
                    @endcan
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="color-box">
                                <span class="cl-example text-center"
                                    style="background-color: #72f14c; font-size: 3rem; color:white">+</span>
                                <div class="cl-info">
                                    <h1 class="cl-title">Ventas</h1>
                                    <span>${{ number_format($ventas, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="color-box">
                                <span class="cl-example text-center"
                                    style="background-color: #72f14c; font-size: 3rem; color:white">+</span>
                                <div class="cl-info">
                                    <h5 class="cl-title">Entradas</h5>
                                    <span>${{ number_format($entradas, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="color-box">
                                <span class="cl-example text-center"
                                    style="background-color: #72f14c; font-size: 3rem; color:white">-</span>
                                <div class="cl-info">
                                    <h5 class="cl-title">Salidas</h5>
                                    <span>${{ number_format($salidas, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--imprimir-->
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <div class="alert alert-secondary text-center" role="alert">
                        ====== BALANCE ======
                    </div>
                    <h2 class="mt-4 text-center">${{ number_format($balance, 2) }}</h2>
                    @if ($balance > 0)
                        @can('cortes_imprimir')
                            <button
                                wire:click.prevent="$emit('info2PrintCorte',{{ $ventas }},{{ $entradas }},{{ $salidas }},{{ $balance }})"
                                class="btn btn-outline-primary mt-5 text-center">Imprimir Corte</button>
                        @endcan
                    @endif
                </div>

            </div>
        </div>
    </div>
