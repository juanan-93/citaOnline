<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            $start = Carbon::parse($request->start)->format('Y-m-d H:i:s');
            $end = $request->end ? Carbon::parse($request->end)->format('Y-m-d H:i:s') : null;

            // Verificar si la franja horaria ya está reservada por cualquier usuario
            $overlap = Appointment::where(function($query) use ($start, $end) {
                $query->whereBetween('start', [$start, $end])
                      ->orWhereBetween('end', [$start, $end])
                      ->orWhereRaw('? BETWEEN start AND end', [$start])
                      ->orWhereRaw('? BETWEEN start AND end', [$end]);
            })->exists();

            if ($overlap) {
                return response()->json(['error' => 'Esta franja horaria ya está reservada.'], 422);
            }

            // Crear la cita y asignarla al usuario autenticado
            $appointment = Appointment::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'start' => $start,
                'end' => $end,
            ]);

            // Devolver los datos de la cita creada como JSON
            return response()->json($appointment);

        } catch (\Exception $e) {
            // Captura el error y lo envía al cliente como JSON
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validar los datos
            $request->validate([
                'title' => 'required|string|max:255',
                'start' => 'required|date',
                'end' => 'nullable|date',
            ]);

            // Convertir las fechas a un formato compatible con MySQL
            $start = Carbon::parse($request->start)->format('Y-m-d H:i:s');
            $end = Carbon::parse($request->end)->format('Y-m-d H:i:s');

            // Verificar si la franja horaria ya está reservada por otra cita (excluyendo la actual)
            $overlap = Appointment::where('id', '!=', $id) // Excluir la cita actual
                ->where(function($query) use ($start, $end) {
                    $query->where(function ($q) use ($start, $end) {
                        $q->whereBetween('start', [$start, $end])
                        ->orWhereBetween('end', [$start, $end]);
                    })->orWhere(function ($q) use ($start, $end) {
                        $q->whereRaw('? BETWEEN start AND end', [$start])
                        ->orWhereRaw('? BETWEEN start AND end', [$end]);
                    });
                })->exists();

            if ($overlap) {
                return response()->json(['error' => 'Esta franja horaria ya está reservada por otro usuario.'], 422);
            }

            // Buscar la cita por ID
            $appointment = Appointment::findOrFail($id);

            // Verificar que la cita pertenece al usuario autenticado
            if ($appointment->user_id !== Auth::id()) {
                return response()->json(['error' => 'No tienes permiso para editar esta cita.'], 403);
            }

            // Actualizar la cita
            $appointment->update([
                'title' => $request->title,
                'start' => $start,
                'end' => $end,
            ]);

            // Devolver los datos de la cita actualizada como JSON
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
}
