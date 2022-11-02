<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <p align="center"><img src="{{asset('img/logotype/LogoEstacionamientoFG.png')}}" class="logologin" alt=""></p>
        </x-slot>

        <div class="card-body">
            <div class="mb-3 small text-muted">
                {{ __('Gracias por registrarte! Antes de comenzar, ¿podría verificar su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar? Si no recibiste el correo electrónico, con gusto te enviaremos otro.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" role="alert">
                    {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que se le proporcionó durante el registro.') }}
                </div>
            @endif

            <div class="mt-4 d-flex justify-content-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <x-jet-button type="submit" class="btn-sm">
                            {{ __(' Reenviar correo electrónico de verificación') }}
                        </x-jet-button>
                    </div>
                </form>

                <form method="POST" action="/logout">
                    @csrf

                    <button type="submit" class="btn btn-linkbtn-sm " style="text-decoration: none">
                        {{ __('Cerrar Sesión') }}
                    </button>
                </form>
            </div>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>