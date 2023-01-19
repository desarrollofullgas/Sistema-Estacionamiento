<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CorteDiario</title>
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
        .red{
            color:red;
        }
        .table__container{
            
            width: 100%;
            margin: auto;
            text-align: center
        }
        .balance{
            text-align: right;
        }
        
        table{
            
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            border:1px black solid;
        }
        table *{
            border:1px black solid;
        }
        .table__tittles{
            font-size: 1.6rem;
            background-color: black;
            color: white;
        }
        tr,th{
            padding: 1rem;
        }
        .info__gral{
            padding: 1rem 2rem ;
            width: 100%;
            font-size: 1.4rem;
            
        }
        .info__gral p{
            padding: 0.5rem;
        }

    </style>
</head>
<body>
    <div class="head">
        <h1><b class="red">Full</b>Gas</h1>
    </div>
    <div class="info__gral">
        <p><b>Fecha:</b> {{$data->d}}</p>
        <p><b>Operador: </b>{{$data->o}}</p>
    </div>
    <div clas="table__container">
        <table>
                <tr class="table__tittles">
                    <th>Ventas</th>
                    <th>Entradas</th>
                    <th>Salidas</th>
                </tr>
                <tr>
                    <th>{{$data->v}}</th>
                    <th>{{$data->e}}</th>
                    <th>{{$data->ex}}</th>
                </tr>
                <tr>
                    <th colspan="3" class="balance">Balance Total: {{$data->b}}</th>
                </tr>
            </table>
    </div>
</body>
</html>