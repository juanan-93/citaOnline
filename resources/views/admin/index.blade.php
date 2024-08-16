@extends('layouts.app')

@section('title', 'Usuario de gestion')
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Usuario de gestion</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ">
                    <a href="{{ route('admin.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Crear
                    </a>
                </div>
                <div class="card-body">
                    <table id="admin-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <td>{{ $admin->name }} {{ $admin->surname }}</td>
                                    <td>{{ $admin->phone_number }}</td>
                                    <td>
                                        <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display:inline;" class="form-eliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-eliminar">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- DataTables --}}
    <script>
        $(document).ready(function() {
            $('#admin-table').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false
            });
        });
    </script>
    {{-- SweetAlert2 --}}
    <script>
        $(document).on('click', '.btn-eliminar', function(event) {
            event.preventDefault();
            var form = $(this).closest("form");

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    </script>
@endpush
