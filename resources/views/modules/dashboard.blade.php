<x-app-layout>
    @section('title', 'Dashboard')
    <x-slot name="header">

    </x-slot>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-body">
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
                    <div class="card-body">
                        {!! $chartVentaSemanal->container() !!}
                        <script src="{{ asset('larapex-charts/apexcharts.js') }}"></script>
                        {{ $chartVentaSemanal->script() }}
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        {!! $chartBalancexMes->container() !!}
                    <script src="{{ asset('larapex-charts/apexcharts.js') }}"></script>
                    {{ $chartBalancexMes->script() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
