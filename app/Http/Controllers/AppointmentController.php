<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        // Obtener todas las citas de todos los usuarios
        $appointments = Appointment::all();

        // Devolver la vista con las citas en formato JSON
        return view('appointments.index', compact('appointments'));
    }


    public function store(Request $request)
    {
        try {
            // Validar los datos
            $request->validate([
                'title' => 'required|string|max:255',
                'start' => 'required|date',  // Validar como fecha
                'end' => 'nullable|date',    // Validar como fecha opcional
            ]);

            // Convertir las fechas a un formato compatible con MySQL
            $start = \Carbon\Carbon::parse($request->start)->format('Y-m-d H:i:s');
            $end = $request->end ? \Carbon\Carbon::parse($request->end)->format('Y-m-d H:i:s') : null;

            // Crear la cita y asignarla al usuario autenticado
            $appointment = Appointment::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'start' => $start,  // Usar el formato convertido
                'end' => $end,      // Usar el formato convertido
            ]);

            // Devolver los datos de la cita creada como JSON
            return response()->json($appointment);

        } catch (\Exception $e) {
            // Captura el error y lo envía al cliente como JSON
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        // Buscar la cita por ID
        $appointment = Appointment::findOrFail($id);
        
        // Verificar que la cita pertenece al usuario autenticado
        if ($appointment->user_id !== Auth::id()) {
            return response()->json(['error' => 'No tienes permiso para eliminar esta cita.'], 403);
        }

        // Eliminar la cita y devolver una respuesta
        $appointment->delete();
        return response()->json(['success' => 'Cita eliminada correctamente.']);
    }

    public function update(Request $request, $id)
    {
        try {
            // Validar los datos
            $request->validate([
                'start' => 'required|date',  // Validar como fecha
                'end' => 'nullable|date',    // Validar como fecha opcional
            ]);

            // Buscar la cita por ID
            $appointment = Appointment::findOrFail($id);

            // Verificar que la cita pertenece al usuario autenticado
            if ($appointment->user_id !== Auth::id()) {
                return response()->json(['error' => 'No tienes permiso para actualizar esta cita.'], 403);
            }

            // Convertir las fechas a un formato compatible con MySQL
            $appointment->start = \Carbon\Carbon::parse($request->start)->format('Y-m-d H:i:s');
            $appointment->end = $request->end ? \Carbon\Carbon::parse($request->end)->format('Y-m-d H:i:s') : null;

            // Guardar los cambios en la cita
            $appointment->save();

            // Devolver una respuesta de éxito
            return response()->json(['success' => 'Cita actualizada correctamente.']);

        } catch (\Exception $e) {
            // Captura el error y lo envía al cliente como JSON
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }






}
