<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chart</title>
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
            font-size: 2.8rem;
            color: white;
            padding: 0.5rem;
            background-color: black;
        }
        .red{
            color:red;
        }
        figure{
            width: 80%;
            margin: 2rem auto;
        }
        img{
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="head">
        <h1><b class="red">Full</b>Gas</h1>
    </div>
    <figure>
        <img src="{{$chart}}" alt="chart">
    </figure>
   
    {{-- <p>alkhqsb</p>
    <p>{{$chart}}</p> --}}
    {{-- {!! $chart->container() !!}
    <script src="{{ asset('larapex-charts/apexcharts.js') }}"></script>
    {!! $chart->script() !!}
</body> --}}
</html>