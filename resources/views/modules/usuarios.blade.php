<x-app-layout>
    @section('title', 'Usuarios')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="content">
        <div class="row">
            <div class="col-sm-12 col-md-10 width--70-100">
                <div class="card m-0 ps">
                    <div class="card-header">
                        <div class="card-title">Usuarios del sistema.</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive scrollbar2 ps">
                            <table id="tabs" class="table mb-0 text-nowrap" style="width: 100%">
                                <thead class="bg-light" style="position: sticky ">
                                    <tr class="bold">
                                        <th class="border-bottom-0 text-center">Id</th>
                                        <th class="border-bottom-0 text-center">Nombre</th>
                                        <th class="border-bottom-0 text-center">Tipo</th>
                                        <th class="border-bottom-0 text-center">Status</th>
                                        <th class="border-bottom-0 text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="table_mov">
                                    @foreach ($users as $user)
                                        <tr class="item-mov text-center">
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->tipo }}</td>
                                            @if ($user->status == 'Activo')
                                                <td class="text-bold text-success"><i
                                                        class="bi bi-toggle-on"></i>{{ $user->status }}</td>
                                            @else
                                                <td class="text-bold text-danger"><i
                                                        class="bi bi-toggle-off"></i>{{ $user->status }}</td>
                                            @endif

                                            <td class="d-flex ">
                                                @can('usuarios_edit')
                                                @livewire('usuarios.user-edit', ['user_edit_id' => $user->id])
                                                @endcan

                                                @livewire('usuarios.user-show', ['user_show_id' => $user->id])

                                                @can('usuarios_destroy')
                                                <form action="{{ route('users.destroy', $user->id) }}"
                                                    class="formulario-eliminar" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-jet-danger-button type="submit"
                                                        class="rounded-circle btn btn-sm ml-2" data-toggle="tooltip"
                                                        rel="tooltip" data-placement="top" title="Eliminar Usuario">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </x-jet-danger-button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Menú.</div>
                    </div>
                    <div class="card-body text-center">
                        @can('usuarios_create')
                        @livewire('usuarios.user-form')
                        @endcan
                    </br>
                        <a class="btn btn-dark btn-sm" href="{{route('users.trashed') }}">
                            Eliminados ({{ $trashed }})
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@if (session('eliminar') == 'ok')
    <script>
        Swal.fire(
            'Listo',
            'Usuario eliminado.',
            'success'
        )
    </script>
@endif
<script>
    $('.formulario-eliminar').submit(function(e) {
        e.preventDefault();

        Swal.fire({
            title: '¿Seguro?',
            text: "{{ $user->name }} será eliminado del sistema",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#000',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire(
                //   'Deleted!',
                //   'Your file has been deleted.',
                //   'success'
                // )
                this.submit();
            }
        })
    });
</script>
