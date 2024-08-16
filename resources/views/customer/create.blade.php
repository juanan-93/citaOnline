@extends('layouts.app')

@section('title', 'Gestión de Clientes')
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Clientes</a></li>
        <li class="breadcrumb-item active">Crear Clientes</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Crear Cliente</h3>
                </div>
                <div class="card-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <!-- Imagen -->
                        <div class="form-group">
                            <label for="profile_image">Imagen de Perfil</label>
                            <input type="file" class="form-control-file" id="profile_image" name="profile_image" accept="image/*">
                        </div>

                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre completo" required>
                        </div>

                        <!-- Apellidos -->
                        <div class="form-group">
                            <label for="surname">Apellidos</label>
                            <input type="text" class="form-control" id="surname" name="surname" placeholder="Apellidos" required>
                        </div>

                        <!-- Edad -->
                        <div class="form-group">
                            <label for="age">Edad</label>
                            <input type="number" class="form-control" id="age" name="age" placeholder="Edad" required>
                        </div>

                        <!-- Teléfono -->
                        <div class="form-group">
                            <label for="phone">Número de Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono" required>
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required>
                        </div>

                        <!-- Descripción -->
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Descripción"></textarea>
                        </div>

                        <!-- Botones -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Crear Cliente</button>
                            <a href="#" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
