<div class="content">
    @section('title', 'Corte')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="card m-0 ps" >
        <div class="card-header">
            <div class="card-title">Corte de caja.</div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-2 col-lg-2">Elige Fecha
                    <div class="form-group">
                        <input id="fecha" wire:model.lazy="fecha" class="form-control flatpickr flatpickr-input active"
                            type="text" placeholder="Haz click">
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="form-group">Elige Operador
                        <select id="operador" wire:model="user" class="form-control">
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
                                    <span id="venta">${{ number_format($ventas, 2) }}</span>
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
                                    <h5  class="cl-title">Entradas</h5>
                                    <span id="entrada">${{ number_format($entradas, 2) }}</span>
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
                                    <span id="salida">${{ number_format($salidas, 2) }}</span>
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
                    <h2 id="balance" class="mt-4 text-center">${{ number_format($balance, 2) }}</h2>
                    @if ($balance > 0)
                        @can('cortes_imprimir')
                        <button type="button"
                                id="imprimir"
                                onclick="pdf()"
                                class="btn btn-outline-primary mt-5 text-center">Imprimir Corte</button>
                            {{-- <button
                                wire:click.prevent="$emit('info2PrintCorte',{{ $ventas }},{{ $entradas }},{{ $salidas }},{{ $balance }})"
                                class="btn btn-outline-primary mt-5 text-center">Imprimir Corte</button> --}}
                                {{-- <a href="{{route('corte.pdf')}}"
                                class="btn btn-outline-primary mt-5 text-center">Imprimir Corte</a> --}}
                        @endcan
                    @endif
                </div>

            </div>
        </div>
    </div>
    <div id="pdf_layout">

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
    
        //import { jsPDF } from "jspdf";
        function pdf(){
            const fecha=document.getElementById("fecha").value;
            const ventas=document.getElementById("venta").textContent;
            const entrada=document.getElementById("entrada").textContent;
            const salida=document.getElementById("salida").textContent;
            const balance=document.getElementById("balance").textContent;
            const combo= document.getElementById("operador");
            const operadorText= combo.options[combo.selectedIndex].text;

            const corte="?v="+ventas+"&e="+entrada+"&ex="+salida+"&b="+balance+"&o="+operadorText+"&d="+fecha;
            /*const layout= document.getElementById("pdf_layout");
            layout.classList.toggle("pdf_card");
            const template=`
            <p>Fecha: ${fecha}</p>
            <p>Operador: ${operadorText}</p>
            <p>Ventas: ${ventas}</p>
            <p>Entrada: ${entrada}</p>
            <p>Salida: ${salida}</p>
            <div>
                ================================================================
                <h2>Balance: ${balance}</h2>
            </div>
            `;
            layout.innerHTML=template;
            //pdf.print();
           
            window.print();
            setTimeout(() => {
                layout.classList.toggle("pdf_card");
            }, 1); */ 
             //const doc = new jsPDF();

            // doc.text("Hello world!", 10, 10);
            // doc.save("a4.pdf");
             var ruta = "{{ url('print/corte') }}" + corte ;
            var w = window.open(ruta, "_blank", "width=400, height=600"); 
        }
    </script>
    {{-- <script src="{{ asset('js/exportar.js') }}">
    </script> --}}

