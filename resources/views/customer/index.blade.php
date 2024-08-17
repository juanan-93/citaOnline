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
                                {{-- <th>Descripción</th> --}}
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td><img src="{{ asset('storage/' . $customer->profile_image) }}" alt="Imagen Cliente" class="img-thumbnail" style="width: 50px; height: 50px;"></td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->surnames }}</td>
                                    <td>{{ $customer->age }}</td>
                                    <td>{{ $customer->phone_number }}</td>
                                    {{-- <td>{{ $customer->description }}</td> --}}
                                    <td>
                                        {{-- Botones de acción --}}
                                        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" style="display:inline;" class="form-eliminar">
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
