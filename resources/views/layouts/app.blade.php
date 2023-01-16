<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/loader.js') }}"></script>

    <link rel="shortcut icon" href="{{ asset('img/favicon/faviconnew.png') }}" type="image/x-icon">

    <title> EstacionamientoFG - @yield('title') </title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylesapp.css') }}">

    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/flatpickr/material_red.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.css') }}">
    <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('fonts/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/sweetalert.css') }}">


    {{-- Sweet Alert --}}
    <script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>

    {{-- Iconos Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons-1.9.1/bootstrap-icons.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    {{-- <script src="{{ asset('js/main.js') }}" defer></script> --}}

    {{-- DATATABLES --}}
    <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}">

</head>
<body class="font-sans antialiased">
{{-- <body class="font-sans antialiased" onload="startTime()"> --}}
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->
    <x-jet-banner />
    @livewire('navigation-menu')

    <!-- Page Heading -->
    <header class="d-flex py-1 bg-white responsive">
        <div class="container ">
            {{ $header }}
            <nav>
                <div id="mobile_menu" class="icon-menu">
                    <i class="bi bi-list"></i>
                </div>
                <ul id="nav" class="nav nav-tabs oculto">
                    <li class="nav-item">
                        <a class="nav-link text-dark fs-20 " href="{{ url('dashboard') }}"><i class="bi bi-bar-chart-line"></i>Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="nav-link text-dark fs-20 dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-ticket-perforated"></i>Rentas</button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('rentas') }}">ENTRADAS Y SALIDAS </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('extraviados') }}">TICKETS EXTRAVIADOS</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="nav-link text-dark fs-20 dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-gear"></i>Config</button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('empresa') }}">EMPRESA </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('cajones') }}">CAJONES</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('tipos') }}">TIPOS DE VEHÍCULO</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('permisos') }}">ROLES Y PERMISOS</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fs-20" href="{{ url('tarifas') }}"><i class="bi bi-currency-dollar"></i>Tarifas</a>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="nav-link text-dark fs-20 dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-printer"></i>Caja</button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('cortes') }}">HACER CORTE </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('movimientos') }}">MOVIMIENTOS</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="nav-link text-dark fs-20 dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-newspaper"></i>Reportes</button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('ventasdiarias') }}">VENTAS DEL DIA </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('ventasporfechas') }}">VENTAS POR FECHA</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('proximasrentas') }}">RENTAS PROXIMAS</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fs-20" href="{{ url('users') }}"><i class="bi bi-people"></i>Usuarios</a>
                    </li>
                </ul>
            </nav>
    </header> 

    <!-- Page Content -->
    <main class="container my-5">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="footer">
        <strong class="float-left text-muted ml-1">V 1.0.1.</strong>
        <p class="textf">todos los derechos reservados &copy; 2022
            <b>
                <a class="link1" href="https://fullgas.com.mx" target="_blank"><span
                        class="link2">FullGas</span></a>.
            </b>
        </p>
    </footer>

    @stack('modals')

    @livewireScripts

    @stack('scripts')
    <script src="{{ asset('assets/js/kitfontawesome.js') }}" crossorigin="anonymous"></script>

    {{-- DATATABLES --}}
    <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#tabs').DataTable({
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Todo"]
                ],
                "language": {
                    "url": "{{ asset('assets/Spanish.json') }}"
                }
            });
        });
    </script>

    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>
    <script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('plugins/flatpickr/flatpickr_es.js') }}"></script>


    <script>
        $(document).ready(function() {
            // App.init();
            //OLD WAY
            /*
            $(".flatpickr").flatpickr({
                enableTime: false,
                dateFormat: "d-m-Y",
                'locale': 'es'
            });
            */
        });
        //NEW WAY
        $(document).on("focus", ".flatpickr", function() {
            $(this).flatpickr({
                enableTime: true,
                dateFormat: "d-m-Y",
                'locale': 'es'
            });

        })
    </script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/toast.js') }}"></script>

    <!--    Scripts -->
    <script src="{{ asset('assets/js/jspdf.debug.js') }}"
        integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/js/html2canvas.js') }}"
        integrity="sha512-sk0cNQsixYVuaLJRG0a/KRJo9KBkwTDqr+/V94YrifZ6qi8+OO3iJEoHi0LvcTVv1HaBbbIvpx+MCjOuLVnwKg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @if ($empresa <= 0)
        <script type="text/javascript">
            toastr.warning("POR FAVOR CONFIGURE LOS DATOS DE LA EMPRESA")
        </script>
    @endif
    @if ($tipos <= 0)
        <script type="text/javascript">
            toastr.warning("ES NECESARIO REGISTRAR LOS TIPOS DE VEHÍCULOS")
        </script>
    @endif
    @if ($tarifas <= 0)
        <script type="text/javascript">
            toastr.warning("DEBES INGRESAR LAS TARIFAS DEL SISTEMA")
        </script>
    @endif
    @if ($cajones <= 0)
        <script type="text/javascript">
            toastr.warning("FALTA  AGREGAR LOS CAJONES DEL ESTACIONAMIENTO")
        </script>
    @endif
    @if ($tiposSinTarifa > 0)
        <script type="text/javascript">
            toastr.warning("NO HAY TARIFA DE COBRO PARA ALGUNOS TIPOS DE VEHÍCULOS")
        </script>
    @endif
    @if ($rentasVencidas > 0)
        <script type="text/javascript">
            toastr.error("EXISTEN {{ $rentasVencidas }} RENTAS VENCIDAS")
        </script>
    @endif
    @if ($rentasPorVencer > 0)
        <script type="text/javascript">
            toastr.warning("HAY {{ $rentasPorVencer }} RENTAS PRÓXIMAS A VENCER")
        </script>
    @endif

    <script>
        //escuchamos eventos 200ok
        window.livewire.on('msgok', msgText => {
            toastr.success(msgText, "Info");
        })
        //escuchamos eventos de error
        window.livewire.on('msg-error', msgText => {
            toastr.error(msgText.toUpperCase(), "Alerta!");
        })
    </script>
    <script src="./js/events.js"></script>
</body>

</html>
