<x-guest-layout>
    @section('title', 'Inicio de Sesión')
    <x-jet-authentication-card>
        <x-slot name="logo">
           <p align="center"><img src="{{asset('img/logotype/LogoEstacionamientoFG.png')}}" class="logologin" alt=""></p>
        </x-slot> 

        <div class="card-body">

            <x-jet-validation-errors class="mb-3 rounded-0" />

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <x-jet-label value="{{ __('E-mail') }}" />

                    <x-jet-input class="form-control{{ $errors->has('email') ? 'is-invalid' : '' }}" type="text"
                                 name="email" :value="old('email')" required />
                    <x-jet-input-error for="email"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <x-jet-label value="{{ __('Contraseña') }}" />

                    <x-jet-input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password"
                                 name="password" required autocomplete="current-password" />
                    <x-jet-input-error for="password"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <div class="custom-control custom-checkbox">
                        <x-jet-checkbox id="remember_me" name="remember" />
                        <label class="custom-control-label" for="remember_me">
                            {{ __('Recordar Sesión') }}
                        </label>
                    </div>
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        {{-- @if (Route::has('password.request'))
                            <a class="text-muted me-3" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif --}}
                       @livewire('pass-reset') 

                        <x-jet-button class="btn btn-sm">
                            {{ __('Iniciar Sesión') }}
                        </x-jet-button>
                    </div>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
