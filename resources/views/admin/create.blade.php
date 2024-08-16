@extends('layouts.app')

@section('title', 'Crear Usuario')
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Indice</a></li>
        <li class="breadcrumb-item active">Crear usuario de gestion</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Crear Administrador</h3>
                </div>
                <div class="card-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" placeholder="Nombre completo" required>
                        </div>
                        <!-- Apellidos -->
                        <div class="form-group">
                            <label for="name">Apellidos</label>
                            <input type="text" class="form-control" id="surname" placeholder="Apellidos" required>
                        </div>

                        <!-- Teléfono -->
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control" id="phone" placeholder="Teléfono" required>
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" placeholder="Correo Electrónico" required>
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" placeholder="Contraseña" required>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" placeholder="Confirmar Contraseña" required>
                        </div>

                        <!-- Foto de Perfil -->
                        <div class="form-group">
                            <label for="profile_image">Foto de Perfil</label>
                            <input type="file" class="form-control-file" id="profile_image" accept="image/*">
                        </div>

                        <!-- Botones -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Crear</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
