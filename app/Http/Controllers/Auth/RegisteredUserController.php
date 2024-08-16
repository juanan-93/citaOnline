<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = \App\Models\Role::all(); // Obtener todos los roles
        return view('login.auth.register', compact('roles'));
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar los datos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surnames' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validación de la imagen
            'description' => ['nullable', 'string', 'max:500'], // Validación de la descripción
            'age' => ['nullable', 'integer', 'min:1'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'], // Validar que el rol exista en la tabla roles
        ]);

        // Manejo del archivo de imagen (si se sube)
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Crear el usuario y asignar el rol
        $user = User::create([
            'name' => $request->name,
            'surnames' => $request->surnames,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => $profileImagePath,
            'description' => $request->description,
            'age' => $request->age,
            'phone_number' => $request->phone_number,
            'role_id' => $request->role_id, // Asignar el rol al usuario
        ]);

        event(new Registered($user));

        // Autenticar al usuario
        Auth::login($user);

        // Redirigir a la página de inicio o dashboard
        return redirect(RouteServiceProvider::HOME);
    }




}
