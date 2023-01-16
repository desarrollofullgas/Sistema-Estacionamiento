<x-app-layout>
    @section('title', 'Dashboard')
    <x-slot name="header">

    </x-slot>
    <div class="container">
        <p class="warning">* Al momento de descargar alguna gráfica <b>Habilitar</b> la opción <i>"Gráficos de fondo"</i> antes de guardar.</p>
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="icon_download" onclick="pdf('mes')">
                        <i class="bi bi-download"></i>
                    </div>
                    <div class="card-body" id="mes">
                        <!-- Helper/Metodo  genera un DIV con un id unico y es donde se monta el gráfico   -->
                        {!! $chartVentaxMes->container() !!}
                        <!-- Helper/Metodo incluye el javascript del package Larapex-->
                        <script src="{{ asset('larapex-charts/apexcharts.js') }}"></script>
                        <!-- Helper/Metodo toma la información enviada desde el controlador en formato json y genera un script para renderizar el gráfico -->
                        {{ $chartVentaxMes->script() }}
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card">
                    <div class="icon_download" onclick="pdf('semanal')">
                        <i class="bi bi-download"></i>
                    </div>
                    
                    <div class="card-body" id="semanal">
                        {!! $chartVentaSemanal->container() !!}
                        <script src="{{ asset('larapex-charts/apexcharts.js') }}"></script>
                        {{ $chartVentaSemanal->script() }}
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="card">
                    <div class="icon_download" onclick="pdf('year')">
                        <i class="bi bi-download"></i>
                    </div>
                    <div class="card-body" id="year">
                        {!! $chartBalancexMes->container() !!}
                    <script src="{{ asset('larapex-charts/apexcharts.js') }}"></script>
                    {{ $chartBalancexMes->script() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pdf_layout"></div>
    <script>
        function pdf(tipo) {
            const layout = document.getElementById("pdf_layout");
            let chart;
            let template;
            if(tipo==="semanal"){
                chart=document.getElementById('semanal');            
            }
            if(tipo==="mes"){
                chart=document.getElementById('mes');            
            }
            if(tipo==="year"){
                chart=document.getElementById('year');
            }
            layout.classList.toggle("pdf_card");
            layout.innerHTML=chart.innerHTML;
            setTimeout(() => {
                layout.classList.toggle("pdf_card");
                layout.innerHTML="";
            }, 1);
            window.print();
            
        }

    </script>
</x-app-layout>
