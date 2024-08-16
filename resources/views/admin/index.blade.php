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
                    <a href="{{route('admin.create')}}" class="btn btn-primary btn-sm">
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
                            <!-- Aquí irán los usuarios administradores (puedes maquetar datos de ejemplo) -->
                            <tr>
                                <td>Admin 1</td>
                                <td>+123456789</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Admin 2</td>
                                <td>+987654321</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</button>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- dataTabla --}}
    <script>
        $(document).ready(function() {
            $('#admin-table').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false
            });
        });
    </script>
@endpush
