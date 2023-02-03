<div class="content">
    @section('title', 'Prox Rentas')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="row">
        <div class="col-sm-12 col-md-12 width--full">
            <div class="card">
                <div class="card-header justify--around">
                    <div class="card-title">Rentas proximas.</div>
                    @can('reporte_rentasavencer_exportar')
                        <div class=" col-md-10  text-right">
                            <button class="btn btn-dark btn-sm" id="pdfoutrent" onclick="PDFCommingSoon()">Exportar a PDF</button>
                        </div>
                        @endcan
                </div>
                <div class="card-body" id="rentasprox">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4 text-left">
                            <b>Fecha de Consulta</b>: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                            <br>
                            <b>Cantidad Registros</b>: {{ $info->count() }}
                        </div>
                        <div class="col-sm-12 col-md-8 float-right">
                            <p align="right"><img src="{{asset('img/logotype/LogoEstacionamientoFG2.png')}}" style="width: 150px" alt=""></p>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive scrollbar2 ps">
                        <table id="tabs" class="table mb-0 " style="width: 100%">
                            <caption>Reporte Próximas Rentas. </br> <small>FullGas Energy Operator &copy;</small> </caption>
                            <thead class="bg-light" style="position: sticky ">
                                <tr class="bold">
                                    <th class="border-bottom-0 text-center">Código</th>
                                    <th class="border-bottom-0 text-center">Cliente</th>
                                    {{-- <th class="border-bottom-0 text-center">Contacto</th> --}}
                                    <th class="border-bottom-0 text-center">Acceso</th>
                                    <th class="border-bottom-0 text-center">T. Restante</th>
                                    <th class="border-bottom-0 text-center">Salida</th>
                                    <th class="border-bottom-0 text-center">Vehiculo</th>
                                    <th class="border-bottom-0 text-center">Status</th>
                                    <th class="border-bottom-0 text-center">Salida</th>
                                </tr>
                            </thead>
                            <tbody class="table_mov">
                                @foreach ($info as $r)
                                    <tr class="item-mov text-center">
                                        <td class="text-center">{{ $r->barcode }}</td>
                                        <td class="text-center">{{ $r->cliente }}</td>
                                        {{-- <td class="text-center">{{ $r->celular }}</td> --}}
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($r->acceso)->format('d-m-Y h:i:s') }}</td>
                                        <td class="text-left">
                                           {{--  <h7>Años:{{ $r->restanteyears }}</h7><br>
                                            <h7>Meses:{{ $r->restantemeses }}</h7><br> --}}
                                            <h7>{{ $r->restantedias }} días</h7><br>
                                            {{-- <h7>Horas:{{ $r->restantehoras }}</h7><br> --}}

                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($r->salida)->format('d-m-Y h:i:s') }}</td>
                                        <td class="text-left">
                                            <h7>Placa:{{ $r->placa }}</h7><br>
                                            <h7>Modelo:{{ $r->modelo }}</h7><br>
                                            <h7>Marca:{{ $r->marca }}</h7>
                                        </td>
                                        <td class="text-center">
                                            @if ($r->estado == 'VENCIDO')
                                                <h7 class="text-danger"><b>{{ $r->estado }}</b></h7>
                                            @else
                                                @if ($r->restantedias > 0)
                                                    @if ($r->restantedias > 0 && $r->restantedias <= 3)
                                                        <h7 class="text-warning"><b>{{ $r->estado }}</b></h7>
                                                    @else
                                                        <h7 class="text-success"><b>{{ $r->estado }}</b></h7>
                                                    @endif
                                                @else
                                                    <h7 class="text-danger"><b>{{ $r->estado }}</b></h7>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @can('reporte_rentasavencer_salidas')
                                                <a href="javascript:void(0);"
                                                   wire:click.prevent="$emit('checkOutTicketPension', {{ $r->id }})" 
                                                    title="Cerrar Ticket"
                                                    class="rounded-circle btn btn-outline-dark btn-sm" onclick="PDFticketSalida({{ $r->id }},'{{ $r->cliente }}')"><i
                                                        class="bi bi-check2-circle"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7"></th>
                                    <th class="text-left" colspan="2">
                                        <h6 class="text-danger">Rentas Vencidas:{{ $totalVencidos }}</h6>
                                        <h6>Próximas a Vencer: {{ $totalProximas }}</h6>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script>
    //ventas diarias
var rentasprox = document.getElementById('rentasprox'),
                    pdfout = document.getElementById('pdfoutrent');
                    pdfout.onclick = function(){
            var doc = new jsPDF('p', 'pt', 'letter'); 
            var margin = 20; 
            var scale = (doc.internal.pageSize.width - margin * 2) / document.body.clientWidth; 
            var scale_mobile = (doc.internal.pageSize.width - margin * 2) / document.body.getBoundingClientRect(); 

            
            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                
                doc.html(rentasprox, { 
                    x: margin,
                    y: margin,
                    html2canvas:{
                        scale: scale_mobile,
                    },
                    callback: function(doc){
                        doc.output('dataurlnewwindow', {filename: 'pdf.pdf'}); 
                    }
                });
            } else{
                 
                doc.html(rentasprox, {
                    x: margin,
                    y: margin,
                    html2canvas:{
                        scale: scale,
                    },
                    callback: function(doc){
                        doc.output('dataurlnewwindow', {filename: 'pdf.pdf'}); 
                    }
                });
            }
        };

</script> --}}
<script>
    function PDFCommingSoon(){
        window.open("print/reports/comming", "_blank", "width=900, height=600");
    }
    function PDFticketSalida(id, cliente){
        url="print/reports/commingEnd/"+id+"+"+cliente;
        window.open(url, "_blank", "width=400, height=600");
    }
</script>
