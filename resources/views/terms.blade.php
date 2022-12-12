<x-guest-layout>
    @section('title','Terminos y Condiciones')
    <div class="row justify-content-center pt-4">
        <div class="col-6">
            <div>
                <p align="center"><img src="{{ asset('img/logotype/FullGasLogo.png') }}" style="width: 250px !important"
                    alt="FullGas"></p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    {!! $terms !!}
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>