<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de Entrada</title>
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
            
            font-size: 1.2rem;
        }
        .info p, .info__auto p{
            padding-top: 0.5rem;
        }
        div{
            padding: 0.5rem 1rem;
        }
        .info__cliente{
            text-align: center;
            height: 1rem;
            overflow: hidden;
        }
        .total{
            font-size: 1.5rem;
            padding: 1rem;
            text-align: center
        }
    </style>
</head>
<body>
    <div class="head">
        <h1><b class="red">FULL</b>GAS</h1>
        <h2>Ticket de Renta</h2>
    </div>
    <div class="info">
        <p><b>No. de ticket: </b>{{$datos->barcode}}</p>
        <p><b>Acceso: </b>{{$datos->acceso}}</p>
        <p class="red"><b>Fecha estimada de salida: </b>{{$datos->acceso}}</p>
    </div>
    <div class="info__cliente">
         - - - - - <b>Cliente:</b> {{$datos->cliente}} - - - - -  
    </div>
    <div class="info__cliente">
        - - - - - <b>Datos del vehículo</b> - - - - -  
   </div>
    <div class="info__auto">
        <p><b>Marca: </b>{{$datos->marca}}</p>
        <p><b>Modelo: </b>{{$datos->modelo}}</p>
        <p><b>Color: </b>{{$datos->color}}</p>
        <p><b>Placas del vehículo: </b>{{$datos->placa}}</p>
    </div>
    <p class="total"><b>Total a pagar:</b><br>${{ number_format($datos->total, 2) }}</p>
</body>
</html>