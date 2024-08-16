@extends('layouts.app')

@section('title', 'Gestión de Clientes')
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Gestión de Clientes</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ">
                    <a href="{{route('customer.create')}}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Crear Cliente
                    </a>
                </div>
                <div class="card-body">
                    <table id="customer-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Edad</th>
                                <th>Teléfono</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Ejemplo de fila de cliente -->
                            <tr>
                                <td><img src="#" alt="Imagen Cliente" class="img-thumbnail" style="width: 50px; height: 50px;"></td>
                                <td>Cliente 1</td>
                                <td>Apellido 1</td>
                                <td>30</td>
                                <td>+123456789</td>
                                <td>Descripción breve del cliente 1.</td>
                                <td>
                                    {{-- <a href="#" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detalles
                                    </a> --}}
                                    <a href="#" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="#" method="POST" style="display:inline;" class="form-eliminar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-eliminar">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Fin de ejemplo de fila -->
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
            $('#customer-table').DataTable({
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
