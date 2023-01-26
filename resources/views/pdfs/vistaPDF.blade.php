<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de Salida</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html{
            font-size: 62.5%;
        }
        body{
            font-family: Arial, Helvetica, sans-serif;
            
        }
        .head{
            text-align: center;
            font-weight: bold;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap:1rem;
        }
        .head h1{
            font-size: 2.5rem;
            color: white;
            padding: 0.5rem;
            background-color: black;
        }
        h2{
            margin-top: 0.5rem;
        }
        .red{
            color:red;
        }
        .info{
            flex-direction: column;
            align-items: center;
            padding: 1rem;
            font-size: 1.2rem;
        }
        .info p{
            padding-top: 1rem;
        }
        .tarifas{
            padding: 1rem;
            text-align: center;
        }
        ul{
            list-style: none;
        }
        .total{
            font-size: 2rem;
        }
    </style>
</head>
<body>
    <div class="head">
        <h1><b class="red">FULL</b>GAS</h1>
        <h2>Ticket de salida del estacionamiento</h2>
    </div>
    <div class="info">
        <p><b>No. de ticket: </b>{{$datos->barcode}}</p>
        <p><b>Placas del vehículo: </b>{{$datos->descripcion}}</p>
        <p><b>Acceso: </b>{{$datos->acceso}}</p>
        <p><b>Tarifas que aplican para este vehículo:</b></p>
        <div class="tarifas">
            <ul>
                @foreach ($datos->tarifa as $item)
                <li>{{$item->tiempo.": $".$item->costo}}</li>
                @endforeach
            </ul>
        </div>
        <hr>
        
        <p><b>Tiempo Transcurrido: </b>{{ $datos->hours }}</p>
        <p class="total"><b>Total: $</b>{{ number_format($datos->total, 2) }}</p>
    </div>
</body>
</html>