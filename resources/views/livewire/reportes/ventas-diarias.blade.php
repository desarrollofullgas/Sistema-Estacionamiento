<div class="content">
    @section('title', 'Ventas Diarias')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="row">
        <div class="col-sm-12 col-md-12 width--full">
            <div class="card">
                <div class="card-header justify--around">
                    <div class="card-title">Reporte de ventas diarias.</div>
                    @can('reporte_ventasdiarias_exportar')
                        <div class=" col-md-9  text-right">
                            <button class="btn btn-dark btn-sm" id="pdfout" onclick="PDFDaily()">Exportar a PDF</button>
                        </div>
                    @endcan
                </div>
                <div class="card-body" id="vdiarias">
                    <div class="row">
                        <div class="col-sm-12 col-md-4 text-left">
                            <b>Fecha de Consulta</b>: {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                            <br>
                            <b>Cantidad Registros</b>: {{ $info->count() }}
                            <br>
                            <b>Total Ingresos</b>: ${{ number_format($sumaTotal, 2) }}
                        </div>
                        <div class="col-sm-12 col-md-8 float-right">
                            <p align="right"><img src="{{asset('img/logotype/LogoEstacionamientoFG2.png')}}" style="width: 150px" alt=""></p>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive scrollbar2 ps">
                        <table id="tabs" class="table  table-striped mb-0 " style="width: 100%">
                            <caption>Reporte Ventas Diarias. </br> <small>FullGas Energy Operator &copy;</small>
                            </caption>
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
                                    <th class="border-bottom-0 text-center">Status</th>
                                    <th class="border-bottom-0 text-center">Servicio</th>
                                    <th class="border-bottom-0 text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="table_mov">
                                @foreach ($info as $r)
                                    <tr class="item-mov text-center">
                                        <td>
                                            <p class="mb-0">{{ $r->barcode }}</p>
                                        </td>
                                        <td>
                                            {{ $r->vehiculo }}
                                            @if ($r->descripcion != null)
                                                <br>"{{ $r->descripcion }}"
                                            @endif
                                        </td>
                                        <td>{{ $r->acceso }}</td>
                                        <td>{{ $r->salida }}</td>
                                        <td>{{ $r->hours }} Hrs.</td>
                                        <td>${{ number_format($r->tarifa, 2) }}</td>
                                        <td>
                                            @if ($r->multa > 0)
                                                ${{ $r->total }} <br> (extraviado)
                                            @else
                                                ${{ $r->total }}
                                            @endif
                                        </td>

                                        <td>{{ $r->usuario }}</td>
                                        <td>{{ $r->estatus }}</td>
                                        <td>
                                            @if ($r->vehiculo_id == null)
                                                RENTA
                                            @else
                                                PENSIÓN
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);"
                                                onclick='var w = window.open("print/order/{{ $r->id }}", "_blank", "width=400, height=600"); /* w.close() */'
                                                data-toggle="tooltip" data-placement="top" title="Reimprimir Ticket">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-printer">
                                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                    <path
                                                        d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                                    </path>
                                                    <rect x="6" y="14" width="12" height="8">
                                                    </rect>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right" colspan="10">SUMA IMPORTES:</th>
                                    <th class="text-center" colspan="2">${{ number_format($sumaTotal, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        //ventas diarias
        import {jsPDF} from "jspdf";
        var vdiarias = document.getElementById('vdiarias'),
            pdfout = document.getElementById('pdfout');
        pdfout.onclick = function() {
            var doc = new jsPDF('p', 'pt', 'letter');
            var margin = 20;
            var scale = (doc.internal.pageSize.width - margin * 2) / document.body.clientWidth;
            var scale_mobile = (doc.internal.pageSize.width - margin * 2) / document.body.getBoundingClientRect();


            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {

                doc.html(vdiarias, {
                    x: margin,
                    y: margin,
                    html2canvas: {
                        scale: scale_mobile,
                    },
                    callback: function(doc) {
                        doc.output('dataurlnewwindow', {
                            filename: 'pdf.pdf'
                        });
                    }
                });
            } else {

                doc.html(vdiarias, {
                    x: margin,
                    y: margin,
                    html2canvas: {
                        scale: scale,
                    },
                    callback: function(doc) {
                        doc.output('dataurlnewwindow', {
                            filename: 'pdf.pdf'
                        });
                    }
                });
            }
        };
    </script> --}}
    <script>
        function PDFDaily(){
            window.open("print/reports/daily", "_blank", "width=400, height=600");
        }
    </script>
