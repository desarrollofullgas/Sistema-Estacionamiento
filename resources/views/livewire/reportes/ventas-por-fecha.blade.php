<div class="content">
    @section('title','Ventas por Fecha')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="row">
        <div class="col-sm-12 col-md-12 width--full">
            <div class="card">
                <div class="card-header justify--around">
                    <div class="card-title ">Reporte de ventas por fecha.</div>
                    @can('reporte_ventasporfecha_exportar')
                        <div class=" col-md-9  text-right ">
                            <button class="btn btn-dark btn-sm" id="pdfoutfech" onclick="PDFDates()">Exportar a PDF</button>
                        </div>
                        @endcan
                </div>
                <div class="card-body" id="vfechas">
                    <div class="row">
                        <div class="col-sm-12 col-md-2">Fecha Inicial
                            <div class="form-group">
                                <input wire:model.lazy="fecha_ini" class="form-control flatpickr flatpickr-input active"
                                    type="text" placeholder="Haz click" id="dateIn">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2 text-left">
                            <div class="form-group">Fecha final
                                <input wire:model.lazy="fecha_fin" class="form-control flatpickr flatpickr-input active"
                                    type="text" placeholder="Haz click" id="dateEnd">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2 text-left">
                            <button type="submit" class="btn btn-info mt-4 mobile-only">Ver</button>
                        </div>
                        <div class="col-sm-12 col-md-3 ">
                            <b>Fecha de Consulta</b>: {{\Carbon\Carbon::now()->format('d-m-Y')}}
                            <br>
                            <b>Cantidad Registros</b>: {{ $info->count() }}
                            <br>
                            <b>Total Ingresos</b>: ${{ number_format($sumaTotal,2) }}
                        </div>
                        <div class="col-sm-12 col-md-3 ">
                            <p align="right"><img src="{{asset('img/logotype/LogoEstacionamientoFG2.png')}}" style="width: 150px" alt=""></p>
                        </div>
                        <hr>
                    </div>
                    <div class="table-responsive scrollbar2 ps">
                        <table id="tabs" class="table mb-0 " style="width: 100%">
                            <caption>Reporte Ventas por Fecha. </br> <small>FullGas Energy Operator &copy;</small> </caption>
                            <thead class="bg-light" style="position: sticky ">
                                <tr class="bold">
                                    <th class="border-bottom-0 text-center">Código</th>
                                    <th class="border-bottom-0 text-center">Vehículo</th>
                                    <th class="border-bottom-0 text-center">Acceso</th>
                                    <th class="border-bottom-0 text-center">Salida</th>
                                    <th class="border-bottom-0 text-center">Tiempo</th>
                                    <th class="border-bottom-0 text-center">Tarifa</th>
                                    <th class="border-bottom-0 text-center">Importe</th>
                                    <th class="border-bottom-0 text-center">Usuario</th>
                                    <th class="border-bottom-0 text-center">Renta</th>
                                    <th class="border-bottom-0 text-center">Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="table_mov">
                                @foreach ($info as $r)
                                    <tr class="item-mov text-center">
                                        <td>{{$r->barcode}}</td>
                                <td>
                                    {{$r->vehiculo}} 
                                    @if($r->descripcion !=null)
                                    <br>"{{$r->descripcion}}"
                                    @endif
                                </td>
                                <td>{{$r->acceso}}</td>
                                <td>{{$r->salida}}</td>
                                <td>{{$r->hours}} Hrs.</td>
                                <td>${{number_format($r->tarifa,2)}}</td>
                                <td>${{$r->total}}</td>         
                                <td>{{$r->usuario}}</td>        
                                <td>
                                    @if($r->vehiculo_id == null)
                                    VISITA
                                    @else
                                    PENSIÓN
                                    @endif
                                </td>
                                <td>{{$r->created_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right" colspan="9">SUMA IMPORTES:</th>
                                    <th class="text-center" colspan="1">${{ number_format($sumaTotal,2) }}</th>     
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
var vfechas = document.getElementById('vfechas'),
                    pdfout = document.getElementById('pdfoutfech');
                    pdfout.onclick = function(){
            var doc = new jsPDF('p', 'pt', 'letter'); 
            var margin = 20; 
            var scale = (doc.internal.pageSize.width - margin * 2) / document.body.clientWidth; 
            var scale_mobile = (doc.internal.pageSize.width - margin * 2) / document.body.getBoundingClientRect(); 

            
            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                
                doc.html(vfechas, { 
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
                 
                doc.html(vfechas, {
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

</script>--}}
<script>
    function PDFDates(){
        const dateIn=document.getElementById("dateIn").value;
        const dateEnd=document.getElementById("dateEnd").value;
        
        const date = dateIn + "+" + dateEnd;
        const url="print/reports/"+date;
        console.log(date);
        window.open(url, "_blank", "width=400, height=600");
    }
</script>