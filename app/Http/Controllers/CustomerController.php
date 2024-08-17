<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class CustomerController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios con el rol de 'customer'
        $customers = User::whereHas('role', function ($query) {
            $query->where('name', 'customer');
        })->get();

        // Pasar los clientes a la vista
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:500',
        ]);

        // Manejar el archivo de imagen si se sube
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Crear el nuevo usuario con el rol de customer
        $user = User::create([
            'name' => $request->name,
            'surnames' => $request->surname,
            'age' => $request->age,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => $profileImagePath,
            'description' => $request->description,
            'role_id' => Role::where('name', 'customer')->first()->id, // Asignar el rol de customer
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('customer.index')->with('success', 'Cliente creado correctamente.');
    }

    public function edit($id)
    {
        // Buscar al cliente por ID
        $customer = User::findOrFail($id);

        // Pasar el cliente a la vista de edición
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $id, // Validar que el email sea único excepto para este usuario
            'password' => 'nullable|confirmed|min:8', // No obligatorio actualizar la contraseña
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:500',
        ]);

        // Buscar al cliente por ID
        $customer = User::findOrFail($id);

        // Manejar el archivo de imagen si se sube
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            $customer->profile_image = $profileImagePath;
        }

        // Actualizar los datos del cliente
        $customer->name = $request->name;
        $customer->surnames = $request->surname;
        $customer->age = $request->age;
        $customer->phone_number = $request->phone;
        $customer->email = $request->email;
        $customer->description = $request->description;

        // Si se proporciona una nueva contraseña, actualizarla
        if ($request->filled('password')) {
            $customer->password = Hash::make($request->password);
        }

        // Guardar los cambios en la base de datos
        $customer->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('customer.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        // Buscar al cliente por ID y eliminarlo
        $customer = User::findOrFail($id);
        
        // Eliminar la imagen de perfil del almacenamiento si existe
        if ($customer->profile_image) {
            Storage::delete('public/' . $customer->profile_image); // Usa Storage correctamente
        }

        // Eliminar el cliente
        $customer->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('customer.index')->with('success', 'Cliente eliminado correctamente.');
    }

}

