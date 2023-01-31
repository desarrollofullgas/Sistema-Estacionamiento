<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Próximas Rentas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 62.5%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;

        }

        .head {
            text-align: center;
            font-weight: bold;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .head h1 {
            font-size: 2.5rem;
            color: white;
            padding: 0.5rem;
            background-color: black;
        }
        h1{
            text-align: center;
            padding: 1rem;
        }

        .red {
            color: red;
        }

        .table__container {
            width: 100%;
            margin: auto;
            text-align: center;
        }

        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            border: 1px black solid;
        }

        table tr td {
            border: 1px black solid;
            text-align: center;
        }

        .table__tittles {
            font-size: 1.6rem;
            background-color: black;
            color: white;
        }

        tr,
        th,
        td {
            padding: 1rem;
        }
        td p{
            padding: 0.3rem;    
        }
        .data {
            font-size: 1.4rem;
        }
        .text-success {
            color: #25C580;
        }
        .text-danger{
            color: #F24137;
        }
        .text-warning {
            color:#DDA803;
        }
    </style>
</head>

<body>
    <div class="head">
        <h1><b class="red">Full</b>Gas</h1>
    </div>
    <h1>Reporte Próximas Rentas.</h1>
    <div class="table__container">
        <table>

            <tr class="table__tittles">
                <th class="border-bottom-0 text-center">Código</th>
                <th class="border-bottom-0 text-center">Cliente</th>
                <th class="border-bottom-0 text-center">Acceso</th>
                <th class="border-bottom-0 text-center">T. Restante</th>
                <th class="border-bottom-0 text-center">Salida</th>
                <th class="border-bottom-0 text-center">Vehiculo</th>
                <th class="border-bottom-0 text-center">Status</th>
            </tr>
            <tbody class="table_mov">
                @foreach ($info as $r)
                <tr class="data">
                    <td>{{ $r->barcode }}</td>
                    <td>{{ $r->cliente }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->acceso)->format('d-m-Y h:i:s') }}</td>
                    <td>
                        {{ $r->restantedias }} días
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($r->salida)->format('d-m-Y h:i:s') }}</td>
                    <td>
                        <p><b>Placa: </b>{{ $r->placa }}</p>
                        <p><b>Modelo: </b>{{ $r->modelo }}</p>
                        <p><b>Marca: </b>{{ $r->marca }}</p>
                    </td>
                    <td>
                        @if ($r->estado == 'VENCIDO')
                        <b class="text-danger">{{ $r->estado }}</b>
                        @else
                        @if ($r->restantedias > 0)
                        @if ($r->restantedias > 0 && $r->restantedias <= 3) 
                            <b class="text-warning">{{ $r->estado}}</b>
                            @else
                            <b class="text-success">{{ $r->estado }}</b>
                            @endif
                            @else
                            <b class="text-danger">{{ $r->estado }}</b>
                            @endif
                            @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            {{-- <tfoot>
                <tr>
                    <th colspan="7"></th>
                    <th class="text-left" colspan="2">
                        <h6 class="text-danger">Rentas Vencidas:{{ $totalVencidos }}</h6>
                        <h6>Próximas a Vencer: {{ $totalProximas }}</h6>
                    </th>
                </tr>
            </tfoot> --}}
        </table>

    </div>
</body>

</html>