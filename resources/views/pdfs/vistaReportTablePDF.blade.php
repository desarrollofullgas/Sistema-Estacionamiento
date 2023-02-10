<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
        .red {
            color: red;
        }
        .table__container {
            width: 100%;
            margin: auto;
            text-align: center
        }
        
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            border: 1px black solid;
        }
        table * {
            border: 1px black solid;
        }
        .table__tittles {
            font-size: 1.6rem;
            background-color: black;
            color: white;
        }
        tr,th {
            padding: 1rem;
        }
        .data{
            font-size: 1.4rem;
            font-weight: 100;
        }
        .balance {
            text-align: right;
            font-size: 1.8rem;
            border: 0;
        }
    </style>
</head>

<body>
    <div class="head">
        <h1><b class="red">Full</b>Gas</h1>
    </div>
    <div clas="table__container">
        <table>
            <tr class="table__tittles">
                <th>Código</th>
                <th>Vehículo (Placas)</th>
                <th>Acceso</th>
                <th>Salida</th>
                <th>Tiempo (hr/min/seg)</th>
                <th>Tarifa</th>
                <th>Importe</th>
                <th>Usuario</th>
                <th>Status</th>
                <th>Servicio</th>
            </tr>
            @foreach ($datos as $registro)
            <tr class="data">
                <th>{{$registro->barcode}}</th>
                <th>
                    @if ($registro->descripcion==null)
                    {{$registro->placa}}    
                    @else
                    {{$registro->descripcion}}
                    @endif
                </th>
                <th>{{$registro->acceso}}</th>
                <th>{{$registro->salida}}</th>
                <th>
                    @if ($registro->hours != null)
                        {{$registro->hours}}
                    @else
                        ------
                    @endif
                </th>
                <th>{{$registro->tarifa}}</th>
                <th>
                    @if ($registro->multa > 0)
                    ${{ $registro->total }} <br> (extraviado)
                    @else
                    ${{ $registro->total }}
                    @endif
                </th>
                <th>{{$registro->usuario}}</th>
                <th>{{$registro->estatus}}</th>
                <th>
                    @if ($registro->vehiculo_id == null)
                    RENTA
                    @else
                    PENSIÓN
                    @endif
                </th>
            </tr>
            @endforeach
            <tr>
                <th colspan="10" class="balance">Suma de importes: ${{number_format($total,2)}}</th>
            </tr>
        </table>
    </div>
</body>

</html>