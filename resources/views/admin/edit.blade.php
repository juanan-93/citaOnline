@extends('layouts.app')

@section('title', 'Editar Usuario')
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Indice</a></li>
        <li class="breadcrumb-item active">Editar usuario de gestion</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Administrador</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Esto es necesario para las solicitudes PUT -->

                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $admin->name }}" required>
                        </div>

                        <!-- Apellidos -->
                        <div class="form-group">
                            <label for="surnames">Apellidos</label>
                            <input type="text" class="form-control" id="surnames" name="surnames" value="{{ $admin->surnames }}" required>
                        </div>

                        <!-- Teléfono -->
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $admin->phone_number }}" required>
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}" required>
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group">
                            <label for="password">Contraseña (dejar en blanco si no desea cambiarla)</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña">
                        </div>

                        <!-- Foto de Perfil -->
                        <div class="form-group">
                            <label for="profile_image">Foto de Perfil</label>
                            <input type="file" class="form-control-file" id="profile_image" name="profile_image" accept="image/*">
                            <img src="{{ asset('storage/' . $admin->profile_image) }}" alt="Imagen Actual" class="img-fluid mt-2" width="100">
                        </div>

                        <!-- Botones -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
