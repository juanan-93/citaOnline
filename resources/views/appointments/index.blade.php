@extends('layouts.app')

@section('title', 'Reservar Cita')
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Reservar Cita</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calendario de Citas</h3>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            // Obtener el id del usuario autenticado desde el backend
            var authenticatedUserId = {{ Auth::id() }};
            
            // Obtener los eventos ya reservados desde la base de datos
            var existingAppointments = @json($appointments);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'es',  // Idioma en español
                timeZone: 'Europe/Madrid',  // Zona horaria
                selectable: true,
                editable: true, // Habilitar la edición de eventos (pero se controlará evento por evento)
                slotLabelFormat: { // Formato de las horas
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false // Formato 24 horas
                },
                slotMinTime: '08:00:00',  // Comienzo de las horas visibles
                slotMaxTime: '21:00:00',  // Fin de las horas visibles
                slotDuration: '01:00:00', // Intervalos de 1 hora
                events: existingAppointments.map(function(appointment) {
                    return {
                        id: appointment.id,  // Necesario para identificar la cita
                        title: appointment.user_id === authenticatedUserId ? appointment.title : 'Ocupado', // Mostrar "Ocupado" si no es del usuario autenticado
                        start: appointment.start,
                        end: appointment.end,
                        user_id: appointment.user_id, // Asegúrate de que el user_id está presente
                        editable: appointment.user_id === authenticatedUserId // Solo editable si el usuario es el propietario
                    };
                }),
                eventClick: function(info) {
                    // Verificar si el usuario autenticado es el creador de la cita
                    if (info.event.extendedProps.user_id !== authenticatedUserId) {
                        // Mostrar una alerta o mensaje si no es el propietario de la cita
                        Swal.fire('No puedes editar o eliminar citas que no te pertenecen.');
                        return;
                    }

                    // Modal para editar o eliminar la cita (solo si es del usuario autenticado)
                    Swal.fire({
                        title: 'Editar Cita',
                        text: "¿Qué quieres hacer con esta cita?",
                        showCancelButton: true,
                        confirmButtonText: 'Eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Eliminar la cita
                            $.ajax({
                                url: '/appointments/' + info.event.id,  // Ruta al controlador de eliminar
                                method: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    info.event.remove();  // Eliminar del calendario
                                    Swal.fire('Eliminada!', 'Tu cita ha sido eliminada.', 'success');
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error en la solicitud:', xhr.responseText);
                                }
                            });
                        }
                    });
                },
                select: function(info) {
                    // Lógica de selección para crear citas
                    Swal.fire({
                        title: 'Reservar cita',
                        input: 'text',
                        inputLabel: 'Título de la cita',
                        inputPlaceholder: 'Introduce el título de la cita',
                        showCancelButton: true,
                        confirmButtonText: 'Guardar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var title = result.value;
                            if (title) {
                                $.ajax({
                                    url: '/appointments',
                                    method: 'POST',
                                    data: {
                                        title: title,
                                        start: info.start.toISOString(),
                                        end: info.end ? info.end.toISOString() : null,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        calendar.addEvent({
                                            id: response.id, // Añadir el ID para la gestión
                                            title: response.title,
                                            start: response.start,
                                            end: response.end,
                                            allDay: info.allDay,
                                            editable: true,  // Asegurarse de que el evento nuevo es editable
                                            user_id: authenticatedUserId // Añadir user_id
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error en la solicitud:', xhr.responseText);
                                    }
                                });
                            }
                        }
                    });
                },
                eventDrop: function(info) {
                    // Solo permitir el arrastre y la edición si es del usuario autenticado
                    if (info.event.extendedProps.user_id !== authenticatedUserId) {
                        info.revert(); // Revertir el movimiento si no pertenece al usuario
                        Swal.fire('No puedes mover citas que no te pertenecen.');
                        return;
                    }

                    // Actualizar la cita en el backend cuando se mueva
                    $.ajax({
                        url: '/appointments/' + info.event.id,
                        method: 'PUT',
                        data: {
                            start: info.event.start.toISOString(),
                            end: info.event.end ? info.event.end.toISOString() : null,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Cita actualizada!', 'Tu cita ha sido actualizada.', 'success');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la solicitud:', xhr.responseText);
                            info.revert(); // Revertir el cambio si ocurre un error
                        }
                    });
                }
            });

            calendar.render();
        });
    </script>
@endpush




