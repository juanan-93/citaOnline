<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios que tienen el rol de admin
        $admins = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->get();

        // Pasar los usuarios a la vista
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255', // Cambiado a 'surnames'
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Manejar el archivo de imagen de perfil si se sube
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Crear el nuevo usuario con el rol admin
        $user = User::create([
            'name' => $request->name,
            'surnames' => $request->surnames, // Cambiado a 'surnames'
            'phone_number' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => $profileImagePath,
            'role_id' => Role::where('name', 'admin')->first()->id, // Asignar el rol de admin
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.index')->with('success', 'Usuario admin creado correctamente.');
    }

    public function edit($id)
    {
        // Buscar el usuario por ID
        $admin = User::findOrFail($id);

        // Pasar el usuario a la vista de edición
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255', // Cambiado a 'surnames'
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $id, // Asegurar que el email sea único excepto para el usuario actual
            'password' => 'nullable|confirmed|min:8', // No es obligatorio actualizar la contraseña
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Buscar el usuario por ID
        $admin = User::findOrFail($id);

        // Manejar el archivo de imagen de perfil si se sube
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            $admin->profile_image = $profileImagePath;
        }

        // Actualizar los datos del usuario
        $admin->name = $request->name;
        $admin->surnames = $request->surnames; // Cambiado a 'surnames'
        $admin->phone_number = $request->phone;
        $admin->email = $request->email;

        // Si se proporciona una nueva contraseña, actualizarla
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        // Guardar los cambios en la base de datos
        $admin->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.index')->with('success', 'Usuario admin actualizado correctamente.');
    }
    // Método para eliminar un usuario admin
    public function destroy($id)
    {
        // Buscar el usuario por ID
        $admin = User::findOrFail($id);

        // Eliminar el usuario
        $admin->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.index')->with('success', 'Usuario admin eliminado correctamente.');
    }
}
