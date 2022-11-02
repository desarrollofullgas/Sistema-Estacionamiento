<x-app-layout>
    @section('title', 'Usuarios Eliminados')
    <x-slot name="header">
        {{-- topmenu --}}
    </x-slot>
    <div class="content">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="card m-0 ps">
                    <div class="card-header">
                        <div class="card-title">Usuarios Eliminados del sistema.</div>
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
                                        <th class="border-bottom-0 text-center">Eliminado</th>
                                        <th class="border-bottom-0 text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody class="table_mov">
                                    @foreach ($trashed as $user)
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

                                            <td>{{ $user->deleted_at }}</td>

                                            <td class="d-flex ">
                                                {{-- restaurar --}}
                                                <form method="POST" action="{{ route('user_restore') }}"
                                                    onsubmit="return confirm('Are you sure you want to restore this user ?');">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" value="{{ $user->id }}"
                                                        required />
                                                    <button type="submit"
                                                        class="btn btn-success btn-sm rounded-circle">
                                                        <i class="bi bi-recycle"></i>
                                                    </button>
                                                </form>
                                                {{-- Eliminar Permanente --}}
                                                <form method="POST" action="{{ route('deleteuser_permanently') }}"
                                                    onsubmit="return confirm('Are you sure you want to permanently delete this user ?');">

                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="id" value="{{ $user->id }}"
                                                        required />
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-circle ml-2">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-dark btn-sm" href="{{route('users')}}">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
