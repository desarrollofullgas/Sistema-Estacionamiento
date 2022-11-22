<div>

    <x-jet-secondary-button wire:click="confirmShowUsuario({{ $user_show_id }})" wire:loading.attr="disabled"
        class=" btn-sm rounded-circle ml-2" data-target="ShowUsuario{{ $user_show_id }}">
        <i class="bi bi-eye-fill"></i>
    </x-jet-secondary-button>

    <x-jet-dialog-modal wire:model="ShowgUsuario" id="ShowUsuario{{ $user_show_id }}" maxWidth="md">
        <x-slot name="title">
            {{ __('Información General del Usuario:') }}
        </x-slot>

        <x-slot name="content">
            <section style="background-color: #f4f5f7;">
                <div class="container ">
                    <div class="row d-flex justify-content-center align-items-center ">
                        <div class="col col-lg-12 ">
                            <div class="card">
                                <div class="row g-0">
                                    <div class="col-md-4 gradient-custom text-center text-white"
                                        style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                        <img src="{{ asset("$this->photo") }}" alt="Avatar"
                                            class="rounded-circle img-fluid my-4" style="width: 80px;" />
                                        {{-- <h5>{{$this->username}}</h5> --}}
                                        <p class="text-white !important" style="text-transform: uppercase">
                                            {{ $this->tipo }}</p>
                                        <img src="{{ asset('img/favicon/faviconnew.png') }}" class="rounded-circle"
                                            style="width: 100px" alt="">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body p-4">
                                            {{-- <h6>Information</h6> --}}
                                            <hr class="mt-0 ">
                                            <div class="row pt-1">
                                                <div class="col-12">
                                                    <h6>Nombre:</h6>
                                                    <p class="text-muted">{{ $this->name }}</p>
                                                    <h6>Email:</h6>
                                                    <p class="text-muted">{{ $this->email }}</p>
                                                    <h6>Status:</h6>
                                                    <p class="text-muted">{{ $this->status }}</p>
                                                    <h6>Fecha Registro:</h6>
                                                    <p class="text-muted">{{ $this->created_at }}</p>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <a href="#!"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                                                    <a href="#!"><i class="fab fa-twitter fa-lg me-3"></i></a>
                                                    <a href="#!"><i class="fab fa-instagram fa-lg"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </section>
        </x-slot>

        <x-slot name="footer" class="d-none">
            <x-jet-secondary-button wire:click="$toggle('ShowgUsuario')" wire:loading.attr="disabled">
                Cerrar
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
